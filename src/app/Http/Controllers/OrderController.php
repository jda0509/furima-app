<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Webhook as StripeWebhook;

class OrderController extends Controller
{
    public function create($item_id)
    {
        $product = Product::findOrFail($item_id);

        $lastOrder = Order::where('user_id', Auth::id())
            ->latest()
            ->first();

        $addr = session('checkout_address');

        if ($addr){
            $lastOrder = (object)[
                'sending_postcode' => $addr['postcode'] ?? ($lastOrder->sending_postcode ?? ''),
                'sending_address'  => $addr['address']  ?? ($lastOrder->sending_address ?? ''),
                'sending_building' => $addr['building'] ?? ($lastOrder->sending_building ?? ''),
            ];
        } elseif (!$lastOrder) {
            $lastOrder = (object)[
                'sending_postcode' => '',
                'sending_address'  => '',
                'sending_building' => '',
            ];
        }

        return view('purchase',[
            'product' => $product,
            'lastOrder' => $lastOrder,
        ]);
    }

    public function createSending($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile ?? null;

        return view('purchase.address', compact('product', 'user', 'profile'));
    }

    public function store(AddressRequest $request, $item_id)
    {
        $user = auth()->user();

        $product = Product::findOrFail($item_id);

        session([
            'checkout_address' => [
                'product_id' => $product->id,
                'postcode'   => $request->postcode,
                'address'    => $request->address,
                'building'   => $request->building ?? '',
            ]
        ]);

        return redirect()
            ->route('purchase.create', ['item_id' => $product->id]);
    }

    public function startCheckout(Request $request)
    {
        $request->validate([
            'item_id' => ['required', 'integer', 'exists:products,id'],
        ]);

        $product = Product::findOrFail($request->item_id);

        $addr = session('checkout_address') ?? [
            'postcode' => '',
            'address' => '',
            'building' => '',
        ];

        if(Order::where('product_id', $product->id)->exists()) {
            return back()->withErrors('この商品はすでに購入されています。');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int)$product->price,
                    'product_data' => [
                        'name' => $product->name,
                    ],
                ],
                'quantity' => 1,
            ]],

            'success_url' => route('index'),
            'cancel_url'  => route('index'),

            'metadata' => [
                'product_id'       => (string) $product->id,
                'user_id'          => (string) Auth::id(),
                'sending_postcode' => (string) $addr['postcode'],
                'sending_address'  => (string) $addr['address'],
                'sending_building' => (string) ($addr['building'] ?? ''),
            ],
        ]);

        return redirect()->away($session->url);

    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        $itemId = (int) $request->query('item_id');

        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $itemId,
                'sending_postcode' => session('checkout_address.postcode'),
                'sending_address' => session('checkout_address.address'),
                'sending_building' => session('checkout_address.building'),
            ]);
        }

        if (!$sessionId || !$itemId){
            return redirect()->route('index')->with('error', '決済情報を取得できませんでした。');
        }

        $product = Product::find($itemId);
        if (!$product) {
            return redirect()->route('index')->with('error', '商品が見つかりませんでした。');
        }

        if (($product->status ?? null) === 'sold' || ($product->is_sold ?? false)) {
            session()->forget('checkout_address');
            return redirect()->route('index')->with('success', '購入は完了しています。');
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        $paid = ($session->payment_status ?? null) === 'paid' || ($session->status ?? null) === 'complete';
        if (!$paid) {
            return redirect()->route('purchase.create', ['item_id' => $product->id])
                ->with('error', '決済が完了していません。');
        }

        $meta = $session->metadata ?? null;
        $userId = (int) ($meta->user_id ?? Auth::id());
        $postcode = (string) ($meta->sending_postcode ?? (session('checkout_address.postcode') ?? ''));
        $address = (string) ($meta->sending_address ?? (session('checkout_address.address') ?? ''));
        $building = (string) ($meta->sending_building ?? (session('checkout_address.building') ?? ''));

        $already = \App\Models\Order::where('product_id', $product->id)->exists();
        if (!$already) {
            \App\Models\Order::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'sending_postcode' => $postcode,
                'sending_address' => $address,
                'sending_building' => $building,
                'status' => 'paid',
                'payment_method' => 'card',
            ]);
        }

        if (array_key_exists('is_sold', $product->getAttributes())) {
            $product->is_sold = true;
        } else {
            $product->status = 'sold';
        }
        $product->save();

        session()->forget('checkout_address');

        return redirect()->route('index')->with('success', '購入が完了しました。');
    }

    public function webhook(Request $request): Response
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret    = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            \Log::error('Stripe webhook verity failed: '.$e->getMessage());
            return new Response('Invalid payload or signature', 400);
        }

        $session = $event->data->object;
        $meta = $session->metadata ?? null;

        if (!$meta || empty($meta->product_id) || empty($meta->user_id)){
            \Log::warning('Stripe webhook missing metadata', ['meta' => $meta]);
        return new Response('missing meta',200);
        }

        $productId = (int) $meta->product_id;
        $userId = (int) $meta->user_id;

        $postcode = (string)($meta->sending_postcode ?? '');
        $address = (string)($meta->sending_address ?? '');
        $building = (string)($meta->sending_building ?? '');

        \App\Models\Order::firstOrCreate(
            ['product_id' => $productId],
            [
                'user_id' => $userId,
                'sending_postcode' => $postcode,
                'sending_address' => $address,
                'sending_building' => $building,
            ]
        );
        
        return new Response('ok', 200);
    }

}
