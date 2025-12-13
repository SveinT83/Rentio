<?php

namespace App\Http\Controllers\Guests;

use App\Models\Ad;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;

class GuestAdController extends Controller
{
    public function show(Ad $ad): View
    {
        $ad->load([
            'category',
            'subcategory',
            'user.settings',
        ]);

        return view('guests.ads.show', [
            'ad' => $ad,
        ]);
    }
}
