<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Return login view
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($request->only('email', 'password'))) {

            // Redirect to the discover page
            return redirect('/discover');
        }

        return back()->withErrors([
            'email' => 'The Email you entered is incorrect.',
            'password' => 'The password you entered is incorrect.',
        ]);
    }



    public function logout()
    {
        Auth::logout(); // Log the user out
        return redirect('/login');
    }
}
