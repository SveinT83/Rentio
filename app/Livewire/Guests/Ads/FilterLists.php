<?php

namespace App\Livewire\Guests\Ads;

use App\Models\AdCategory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class FilterLists extends Component
{
    public function render(): View
    {
        $categories = AdCategory::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('livewire.guests.ads.FilterLists', [
            'categories' => $categories,
        ]);
    }
}