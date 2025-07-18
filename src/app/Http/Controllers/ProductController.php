<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::all();

        $tab = $request->query('tab');

        if ($tab === 'mylist'){
            $likesProducts = auth::user()->likesProducts()->get();
        }else{
            $likesProducts = null;
        }

        $products = Product::all();

        return view('index', compact('products','likesProducts','tab'));
    }

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);

        return view('item', compact('product'));
    }
}
