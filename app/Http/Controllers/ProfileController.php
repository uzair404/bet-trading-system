<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->validate([
            'user_name' => ['required', 'string', 'max:255', 'lowercase', 'max:255', 'unique:users,user_name,'.Auth::user()->id],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255', 'in:public,private'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.Auth::user()->id]
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // $request->user()->save();
        $user = Auth::user();
        $user->update([
            'user_name' => $request->input('user_name'),
            'name' => $request->input('name'),
            'type' => $request->type,
            'email' => $request->input('email'),
        ]);
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
