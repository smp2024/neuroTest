<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile()
    {
        $user = auth()->user();
        return view('admin.user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Logic to update user profile
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email'));

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
