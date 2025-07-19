<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;
use App\Models\Product;
use App\Models\Order;

class OrderController extends Controller
{
    public function create($item_id){
        $product = Product::findOrFail($item_id);

        $lastOrder = Order::where('user_id', Auth::id())
                            ->latest()
                            ->first();

        return view('purchase', compact('product', 'lastOrder'));
    }

    public function createSending($item_id){
        $product = Product::findOrFail($item_id);
        $user = Auth::user();
        $profile = $user->profile ?? null;

        return view('purchase.address', compact('product', 'user', 'profile'));
    }
}
