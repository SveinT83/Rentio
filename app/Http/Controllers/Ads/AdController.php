<?php

namespace App\Http\Controllers\Ads;

use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;

class AdController extends Controller
{

    public function create()
    {
        return view('ads.create');
    }

    public function edit(Ad $ad): View
    {
        $this->authorizeOwner($ad);

        return view('ads.create', [
            'ad' => $ad,
        ]);
    }

    public function show(Ad $ad): View
    {
        $this->authorizeOwner($ad);

        return view('ads.show', [
            'ad' => $ad,
        ]);
    }

    public function toggleAvailability(Ad $ad): RedirectResponse
    {
        $this->authorizeOwner($ad);
        $ad->update(['is_available' => ! $ad->is_available]);

        return back();
    }

    public function toggleActive(Ad $ad): RedirectResponse
    {
        $this->authorizeOwner($ad);
        $ad->update(['is_active' => ! $ad->is_active]);

        return back();
    }

    public function destroy(Ad $ad): RedirectResponse
    {
        $this->authorizeOwner($ad);
        $ad->delete();

        return redirect()->route('dashboard');
    }

    protected function authorizeOwner(Ad $ad): void
    {
        $user = Auth::user();
        if (! $user || $ad->user_id !== $user->id) {
            abort(403);
        }
    }
}
