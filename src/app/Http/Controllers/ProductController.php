<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('index', compact('products'));
    }

    public function show($item_id)
    {
        $product = Product::findOrFail($item_id);

        return view('item', compact('product'));
    }
}
