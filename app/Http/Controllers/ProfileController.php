<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
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
        $user = $request->user()->load('settings');

        $user->settings()->firstOrCreate([]); // sørger for rad

        $user->load('settings'); // refresh

        return view('profile.edit', compact('user'));
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'show_email' => ['sometimes', 'boolean'],
            'show_tel'   => ['sometimes', 'boolean'],
        ]);

        $data = [
            'show_email' => (bool) $request->input('show_email', 0),
            'show_tel'   => (bool) $request->input('show_tel', 0),
        ];

        // Minst én må være aktiv
        if (! $data['show_email'] && ! $data['show_tel']) {
            return back()
                ->withErrors([
                    'show_email' => 'Du må vise enten e-post eller mobilnummer.',
                ])
                ->withInput();
        }

        $request->user()->settings()->updateOrCreate([], $data);

        return Redirect::route('profile.edit')->with('status', 'settings-updated');
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
