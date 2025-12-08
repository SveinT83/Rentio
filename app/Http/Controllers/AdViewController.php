<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\AdView;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdViewController extends Controller
{
    public function store(Request $request, Ad $ad): JsonResponse
    {
        $ip = (string) $request->ip();
        $ipHash = hash('sha256', $ip);
        $sessionId = $request->session()->getId();
        $userId = optional($request->user())->id;
        $viewDate = now()->toDateString();

        // Ensure uniqueness per day across ip/session/user
        AdView::firstOrCreate([
            'ad_id' => $ad->id,
            'view_date' => $viewDate,
            'ip_hash' => $ipHash,
            'session_id' => $sessionId,
            'user_id' => $userId,
        ]);

        return response()->json(['ok' => true]);
    }
}
