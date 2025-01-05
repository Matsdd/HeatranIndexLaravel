<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('profile.adminView', compact('users'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully');
    }
}
