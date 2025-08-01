<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;


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

        $product = Product::with('comments.user')->findOrFail($item_id);

        return view('item', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('sell', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $validated = $request->validated();
        \Log::debug('Validated data:', $validated);

        $product = new Product();
        $product->user_id = Auth::id();
        $product->condition_id = $validated['condition_id'];
        $product->name = $validated['name'];
        $product->brand_name = $validated['brand_name'];
        $product->explanation = $validated['explanation'];
        $product->price = $validated['price'];

        if ($request->hasFile('image')){
            $path = $request->file('image')->store('images', 'public');
            $product->image = $path;
        }

        \Log::debug('Saving product...', ['data' => $validated]);
        $product->save();
        \Log::debug('Product save:', ['id' => $product->id]);

        $product->categories()->sync($validated['categories']);

        return redirect()->route('mypage.show');
    }

    public function toggleLike(Product $product)
    {
        $user = auth()->user();

        if($product->likesUsers()->where('user_id', $user->id)->exists()){
            $product->likesUsers()->detach($user->id);
        } else {
            $product->likesUsers()->attach($user->id);
        }

        return back();
    }

    public function comment(CommentRequest $request, Product $item)
    {
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->product_id = $item->id;
        $comment->comment = $request->comment;
        $comment->save();

        return redirect()->route('item.show', ['item_id' => $item->id]);
    }
}
