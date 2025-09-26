<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show registration form
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Register user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        DB::insert("INSERT INTO users (name, email, password) VALUES (?, ?, ?)", [
            $request->name,
            $request->email,
            Hash::make($request->password)
        ]);

        // Auto-login after registration
        $user = DB::selectOne("SELECT * FROM users WHERE email = ?", [$request->email]);
        Auth::loginUsingId($user->id);

        return redirect('/')->with('success', 'Registered & Logged in successfully!');
    }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Login user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = DB::selectOne("SELECT * FROM users WHERE email = ?", [$request->email]);
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->id);
            return redirect('/')->with('success', 'Logged in successfully!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logged out successfully!');
    }
}
