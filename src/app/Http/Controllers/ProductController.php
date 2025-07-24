<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\ExhibitionRequest;


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

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell',compact('categories','conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();

        $product = new Item();
        $product->user_id = Auth::id();
        $product->condition_id = $validated['condition_id'];
        $product->name = $validated['name'];
        $product->brand_name = $validated['brand_name'];
        $product->explanation = $validated['explanation'];
        $product->price = $validated['price'];

        if ($request->hasFile('image')){
            $image = $request->file('image')->store('items', 'public');
            $product->image = $image;
        }

        $product->save();

        if (isset($validated['categories'])){
            $product->categories()->sync($validated['categories']);
        }

        return redirect()->route('mypage.show');
    }
}
