<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('backend.pages.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users,phone,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'avatar' => $request->avatar,
            ]);

            return response()->json(['success' => 'Profile updated successfully !']);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage(), 'type' => 'error'], 200);
        }
    }

    public function change_password()
    {
        return view('backend.pages.profile.change_password');
    }

    public function password_update(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully!', 'type' => 'success', 'redirectUrl' => url()->previous()]);
    }
}
