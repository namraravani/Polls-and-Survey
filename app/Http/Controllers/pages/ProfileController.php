<?php

namespace App\Http\Controllers\pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
      $disableRole = true; // Set the value based on your server-side logic

      return view('profile.profile', compact('disableRole'));
    }

    public function edit_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'profile_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username' => 'required|unique:users,username,' . auth()->id(),
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_no' => 'required|digits:10|unique:users,phone_no,' . auth()->id(),
            'email' => 'required|unique:users,email,' . auth()->id(),
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $user = Auth::user();

        $user->username = $request->input('username');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_no = $request->input('phone_no');
        $user->email = $request->input('email');

        $previousImage = $user->profile_img;

        if ($request->hasFile('profile_img')) {
            $image = $request->file('profile_img');
            $imageName = date('d-m-y') . "-" . $image->getClientOriginalName();
            $destinationPath = 'uploaded_images/';
            $path = $image->move($destinationPath, $imageName);

            if ($previousImage) {
                File::delete(public_path($previousImage));
            }

            $user->profile_img = $path;
        } elseif ($request->has('delete_profile_img')) {
            if ($previousImage) {
                File::delete(public_path($previousImage));
            }
            $user->profile_img = null;
        } else {
            $user->profile_img = $previousImage;
        }

        $user->save();

        return response()->json(['success' => 'Profile Updated Successfully']);
    }

    public function edit_password(Request $request)
{
    $request->validate([
        'old_password' => 'required',
        'new_password' => ['required', 'string', Password::min(8)->letters()->numbers()->mixedCase()->symbols()],
        'confirm_password' => 'required|same:new_password',
    ], [
        'old_password.required' => 'Please enter your old password.',
        'new_password.required' => 'Please enter a new password.',
        'new_password.string' => 'The new password must be a string.',
        'new_password.min' => 'The new password must be at least 8 characters long and include letters, numbers, mixed case, and symbols.',
        'confirm_password.required' => 'Please confirm your new password.',
        'confirm_password.same' => 'The new password and confirmation password must match.',
    ]);

    if (!Hash::check($request->old_password, Auth::user()->password)) {
        return redirect()->back()->with('error', 'Incorrect old password');
    }

    if ($request->old_password === $request->new_password) {
        return redirect()->back()->with('error', 'Old and new passwords cannot be the same');
    }

    $user = [
        'password' => Hash::make($request->new_password),
    ];

    DB::table('users')
        ->where('id', Auth::user()->id)
        ->update($user);

    return redirect()->back()->with('success', 'Profile Updated Successfully');
}

}
