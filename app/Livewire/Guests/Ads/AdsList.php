<?php

namespace App\Livewire\Guests\Ads;

use App\Models\Ad;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AdsList extends Component
{
    public string $sortBy = 'created_at';

    public string $sortDir = 'desc';

    /** @var array<string, string> */
    protected $listeners = [
        'guests-ads:set-sort' => 'setSort',
        'guests-ads:set-sort-dir' => 'setSortDir',
        'guests-ads:set-sort-both' => 'setSortBoth',
        'guests-ads:set-category' => 'setCategory',
        'guests-ads:set-subcategory' => 'setSubcategory',
        'guests-ads:set-location' => 'setLocation',
        'guests-ads:set-municipality' => 'setMunicipality',
        'guests-ads:set-search' => 'setSearch',
    ];

    public mixed $categoryId = null;

    public mixed $subcategoryId = null;

    public ?string $location = null;

    public ?string $municipality = null;

    public ?string $search = null;

    public int $perPage = 20;

    public int $page = 1;

    protected $queryString = [
        'sortBy' => ['except' => 'created_at'],
        'sortDir' => ['except' => 'desc'],
        'categoryId' => ['except' => null, 'as' => 'categoryId'],
        'subcategoryId' => ['except' => null, 'as' => 'subcategoryId'],
        'location' => ['except' => null, 'as' => 'location'],
        'municipality' => ['except' => null, 'as' => 'municipality'],
        'search' => ['except' => null, 'as' => 'search'],
    ];

    public function setSort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }

    public function setSortDir(string $direction): void
    {
        $this->sortDir = $direction === 'asc' ? 'asc' : 'desc';
    }

    public function setSortBoth(string $column, string $direction): void
    {
        $this->sortBy = $column;
        $this->setSortDir($direction);
    }

    public function setCategory(mixed $id = null): void
    {
        $this->categoryId = $id && is_numeric($id) && $id > 0 ? (int) $id : null;
        // reset subcategory when parent changes
        $this->subcategoryId = null;
        // Reset pagination when filter changes
        $this->page = 1;
    }

    public function setSubcategory(mixed $id = null): void
    {
        $this->subcategoryId = $id && is_numeric($id) && $id > 0 ? (int) $id : null;
        // Reset pagination when filter changes
        $this->page = 1;
    }

    public function setLocation(?string $value = null): void
    {
        $this->location = trim($value ?: '') ?: null;
        // Reset pagination when filter changes
        $this->page = 1;
    }

    public function setMunicipality(?string $value = null): void
    {
        $this->municipality = trim($value ?: '') ?: null;
        // Reset pagination when filter changes
        $this->page = 1;
    }

    public function setSearch(?string $value = null): void
    {
        $this->search = trim($value ?: '') ?: null;
        // Reset pagination when search changes
        $this->page = 1;
    }

    public function loadMore(): void
    {
        $this->page++;
    }

    public function hydrate(): void
    {
        // Clean up properties that might have been set as empty strings from URL
        if (is_string($this->categoryId) && ($this->categoryId === '' || $this->categoryId === '0')) {
            $this->categoryId = null;
        } elseif (is_numeric($this->categoryId) && $this->categoryId > 0) {
            $this->categoryId = (int) $this->categoryId;
        } else {
            $this->categoryId = null;
        }

        if (is_string($this->subcategoryId) && ($this->subcategoryId === '' || $this->subcategoryId === '0')) {
            $this->subcategoryId = null;
        } elseif (is_numeric($this->subcategoryId) && $this->subcategoryId > 0) {
            $this->subcategoryId = (int) $this->subcategoryId;
        } else {
            $this->subcategoryId = null;
        }

        if ($this->location === '') {
            $this->location = null;
        }
        if ($this->municipality === '') {
            $this->municipality = null;
        }
        if ($this->search === '') {
            $this->search = null;
        }
    }

    public function mount(): void
    {
        // Load from session if no URL parameters are provided
        if (! request()->hasAny(['categoryId', 'subcategoryId', 'location', 'municipality', 'search'])) {
            $filters = session('ads_filters', []);
            $this->categoryId = $filters['categoryId'] ?? null;
            $this->subcategoryId = $filters['subcategoryId'] ?? null;
            $this->location = $filters['location'] ?? null;
            $this->municipality = $filters['municipality'] ?? null;
            $this->search = $filters['search'] ?? null;
        }

        // Always save current state to session for next page load
        $this->saveFiltersToSession();

        // Dispatch current filter state to frontend after component mounts
        $this->dispatch('filter-state-updated', [
            'categoryId' => $this->categoryId,
            'subcategoryId' => $this->subcategoryId,
            'location' => $this->location,
            'municipality' => $this->municipality,
            'search' => $this->search,
        ]);
    }

    public function updated($propertyName): void
    {
        // Whenever any filter property is updated, dispatch the new state and save to session
        if (in_array($propertyName, ['categoryId', 'subcategoryId', 'location', 'municipality', 'search'])) {
            $this->saveFiltersToSession();
            $this->dispatch('filter-state-updated', [
                'categoryId' => $this->categoryId,
                'subcategoryId' => $this->subcategoryId,
                'location' => $this->location,
                'municipality' => $this->municipality,
                'search' => $this->search,
            ]);
        }
    }

    protected function saveFiltersToSession(): void
    {
        session(['ads_filters' => [
            'categoryId' => $this->categoryId,
            'subcategoryId' => $this->subcategoryId,
            'location' => $this->location,
            'municipality' => $this->municipality,
            'search' => $this->search,
        ]]);
    }

    public function render(): View
    {
        $totalAdsToShow = $this->page * $this->perPage;

        // Build base query for reuse
        $baseQuery = Ad::query()
            ->when($this->categoryId, fn ($q) => $q->where('category_id', $this->categoryId))
            ->when($this->subcategoryId, fn ($q) => $q->where('subcategory_id', $this->subcategoryId))
            ->when($this->location, fn ($q) => $q->where('location', 'like', $this->location.'%'))
            ->when($this->municipality, fn ($q) => $q->where('municipality', 'like', $this->municipality.'%'))
            ->when($this->search, function ($q) {
                $searchTerm = '%'.$this->search.'%';
                $q->where(function ($subQ) use ($searchTerm) {
                    $subQ->where('ad_name', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                });
            });

        // Get ads with relationships
        $ads = $baseQuery
            ->with(['user', 'category', 'subcategory', 'primaryImage'])
            ->orderBy($this->sortBy, $this->sortDir)
            ->limit($totalAdsToShow)
            ->get();

        // Get total count efficiently
        $totalAvailable = $baseQuery->count();
        $hasMoreAds = $totalAvailable > $totalAdsToShow;

        return view('livewire.guests.ads.ads-list', [
            'ads' => $ads,
            'hasMoreAds' => $hasMoreAds,
            'currentlyShowing' => $ads->count(),
            'totalAvailable' => $totalAvailable,
        ]);
    }
}
