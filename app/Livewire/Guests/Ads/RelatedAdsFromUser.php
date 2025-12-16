<?php

namespace App\Livewire\Guests\Ads;

use App\Models\Ad;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class RelatedAdsFromUser extends Component
{
    public int $userId;

    public ?int $excludeId = null;

    public function render(): View
    {
        $ads = Ad::query()
            ->with(['category', 'subcategory', 'primaryImage'])
            ->where('user_id', $this->userId)
            ->where('is_active', true)
            ->where('is_available', true)
            ->when($this->excludeId !== null, fn ($q) => $q->where('id', '!=', $this->excludeId))
            ->latest()
            ->limit(6)
            ->get();

        return view('livewire.guests.ads.related-ads-from-user', [
            'ads' => $ads,
        ]);
    }
}
