<?php

namespace App\Livewire\Guests\Ads;

use App\Models\AdCategory;
use App\Models\Postnummerregister;
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

        // Get unique locations from postnummerregister
        $locations = Postnummerregister::query()
            ->select('Poststed')
            ->distinct()
            ->whereNotNull('Poststed')
            ->where('Poststed', '!=', '')
            ->whereRaw("Poststed REGEXP '^[A-ZÆØÅ][A-ZÆØÅ ]+$'")
            ->whereRaw('LENGTH(Poststed) > 2')
            ->orderBy('Poststed')
            ->pluck('Poststed')
            ->filter() // Remove any empty/null values
            ->unique()
            ->values();

        return view('livewire.guests.ads.FilterLists', [
            'categories' => $categories,
            'locations' => $locations,
        ]);
    }
}
