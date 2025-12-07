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
    ];

    public ?int $categoryId = null;

    public ?int $subcategoryId = null;

    public ?string $location = null;

    public ?string $municipality = null;

    protected $queryString = [
        'sortBy' => ['except' => 'created_at'],
        'sortDir' => ['except' => 'desc'],
        'categoryId' => ['except' => null],
        'subcategoryId' => ['except' => null],
        'location' => ['except' => null],
        'municipality' => ['except' => null],
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

    public function setCategory(?int $id = null): void
    {
        $this->categoryId = $id ?: null;
        // reset subcategory when parent changes
        $this->subcategoryId = null;
    }

    public function setSubcategory(?int $id = null): void
    {
        $this->subcategoryId = $id ?: null;
    }

    public function setLocation(?string $value = null): void
    {
        $this->location = $value ?: null;
    }

    public function render(): View
    {
        $ads = Ad::query()
            ->with(['user', 'category', 'subcategory'])
            ->when($this->categoryId, fn ($q) => $q->where('category_id', $this->categoryId))
            ->when($this->subcategoryId, fn ($q) => $q->where('subcategory_id', $this->subcategoryId))
            ->when($this->location, fn ($q) => $q->where('location', 'like', $this->location.'%'))
            ->orderBy($this->sortBy, $this->sortDir)
            ->limit(20)
            ->get();

        return view('livewire.guests.ads.ads-list', [
            'ads' => $ads,
        ]);
    }
}