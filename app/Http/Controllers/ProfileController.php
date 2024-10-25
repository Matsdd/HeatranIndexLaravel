<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function user()
    {
        $user = auth()->user();
        return view('profile.user', compact('user'));
    }

}
