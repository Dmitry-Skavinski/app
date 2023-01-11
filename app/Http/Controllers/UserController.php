<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'name' => 'required|unique:users|min:4|max:16',
            'password' => ['required', Password::min(8)->letters()->numbers()]
        ]);

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return $user->toJson();
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|min:6',
            'password' => 'required|regex:/[a-z]/i|regex:/0-9/|min:8'
        ]);
        $user = User::where('email', $request->login)->orWhere('name', $request->login)->first();
        if (Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return $user->toJson;
        }
    }
}
