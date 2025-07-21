<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Order;
use App\Http\Requests\AddressRequest;

class OrderController extends Controller
{
    public function create($item_id){
        $product = Product::findOrFail($item_id);

        $lastOrder = Order::where('user_id', Auth::id())
                            ->where('product_id', $item_id)
                            ->first();

        return view('purchase', compact('product', 'lastOrder'));
    }

    public function createSending($item_id){
        $product = Product::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile ?? null;

        return view('purchase.address', compact('product', 'user', 'profile'));
    }

    public function store(AddressRequest $request, $item_id)
    {
        $user = auth()->user();

        $order = Order::updateOrCreate(
        [
            'user_id' => Auth::id(),
            'product_id'=> $item_id,
        ],
        [
            'sending_postcode'  => $request->postcode,
            'sending_address'   => $request->address,
            'sending_building'  => $request->building,
            'payment_method' => null,
        ]);

        return redirect()->route('purchase.create', [
            'item_id' => $item_id,
            'product' => Product::findOrFail($item_id),
            'lastOrder' => $order,
        ]);
    }
}
