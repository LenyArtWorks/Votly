<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{

    public function register(Request $request) {
        $request->validate([
            'login' => 'required|string|max:12|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|max:20|confirmed'
        ]);

        $user = User::create([
        'login' => $request->login,
        'password' => Hash::make($request->password),
        'email' => $request->email,
        'role' => 'user'
        ]);

        auth()->login($user);

        return redirect('/');
    }

    public function login(Request $request) {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        if (auth()->attempt([
            'login' => $request->login,
            'password' => $request->password
        ])) {
            return redirect('/');
        }
        else {
            return back()->withErrors([
                'message' => 'Неправильный логин или пароль'
            ]);
        }
    }

    public function logout() {
        auth()->logout();
        return redirect('auth/register');
    }
}
