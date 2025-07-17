<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\User;
use App\Models\Profile;

class UserController extends Controller
{
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
}
