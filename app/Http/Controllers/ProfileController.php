<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    // Display user profile
    public function user()
    {
        $user = auth()->user();
        return view('profile.user', compact('user'));
    }

    // Upload a new profile picture
    public function uploadProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Delete existing profile picture if it exists
        if ($user->profile_picture) {
            Storage::delete('public/' . $user->profile_picture);
        }

        // Store the new profile picture under the 'profile_pictures' directory in the 'public' disk
        $path = $request->file('profile_picture')->store('profile_pictures', 'public');

        // Update the user's profile picture path
        $user->profile_picture = $path;
        $user->save();

        return redirect()->back()->with('success', 'Profile picture uploaded successfully!');
    }

    // Remove profile picture
    public function removeProfilePicture()
    {
        $user = auth()->user();

        if ($user->profile_picture) {
            Storage::delete('public/' . $user->profile_picture);
            $user->profile_picture = null;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile picture removed successfully!');
    }

    // Serve profile picture with permission logic
    public function getProfilePicture($filename)
    {
        $user = auth()->user();

        // Check if the current user is authorized to access the picture
        if ($user->role === 'admin' || $user->id === (int) $filename) {
            $path = public_path('storage/profile_pictures/' . $filename);

            // Check if the file exists
            if (file_exists($path)) {
                return response()->file($path);
            }

            return abort(404);
        }

        // If unauthorized, abort with a 403 error
        return abort(403, 'Unauthorized action');
    }
}
