<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;

class UserController extends Controller
{
    public function show()
    {
        $tab = request()->get('tab', 'sell');

        $myProducts = [];
        $myPurchases = [];

        if ($tab === 'sell') {
            $myProducts = Product::where('user_id', Auth::id())->get();
        } elseif ($tab === 'buy') {
            $myPurchases = Auth::user()->orders()->with('product')->get();
        }

        return view('mypage', compact('tab', 'myProducts', 'myPurchases'));
    }
    public function store(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('mypage.profile');
    }

    public function showProfileForm()
    {
        return view('mypage.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function storeProfile(ProfileRequest $request)
    {
        $profile = Profile::create([
            'user_id' => Auth::id(),
            'postcode' => $request->postcode,
            'address' => $request->address,
            'building' => $request->building
        ]);

        if($request->hasFile('image')){
            $path = $request->file('image')->store('profile_images', 'public');
            $profile -> image = $path;
            $profile -> save();
        }

        return redirect()->route('index');
    }

    public function update(ProfileRequest $request)
    {
        $profile = Profile::where('user_id', Auth::id())->first();

        if($request->hasFile('image')){
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $profile->image = $imagePath;
        }

        $profile->postcode = $request->postcode;
        $profile->address = $request->address;
        $profile->building = $request->building;

        $profile->save();

        return redirect()->route('index');
    }
}
