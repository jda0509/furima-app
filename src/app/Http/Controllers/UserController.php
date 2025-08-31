<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Models\Profile;
use App\Models\Product;

class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません',
        ])->onlyInput('email');
    }

    public function show()
    {
        $tab = request()->get('tab', 'sell');

        $myProducts = [];
        $myPurchases = [];

        $user = Auth::user();

        if ($tab === 'sell') {
            $myProducts = Product::where('user_id', Auth::id())->get();
        } elseif ($tab === 'buy') {
            $myPurchases = Auth::user()->orders()->with('product')->get();
        }

        return view('mypage', compact('tab', 'myProducts', 'myPurchases','user'));
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
        $user = Auth::user();
        $profile = $user->profile;
        return view('mypage.profile', compact('user','profile'));
    }

    public function storeProfile(ProfileRequest $request, $user_id)
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

    public function profile(ProfileRequest $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'postcode' => 'nullable|string|max:8',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $validated['name'];
        $user->save();

        $profile = $user->profile ?? new Profile();

        $profile->user_id = $user->id;
        $profile->postcode = $validated['postcode'];
        $profile->address = $validated['address'];
        $profile->building = $validated['building'];

        if($request->hasFile('image')){
            $image = $request->file('image')->store('images', 'public');
            $profile->image = $image;
        }

            $profile->save();

            $user->update(['name' => $validated['name']]);
            $user->save();

            return redirect()->route('mypage.profile');
    }
}
