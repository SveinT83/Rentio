<?php

namespace App\Livewire\Ads;

use App\Models\Ad;
use App\Models\AdCategory;
use App\Models\Postnummerregister;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateAdForm extends Component
{
    public Collection $categories;

    public ?string $adName = null;

    public ?int $price = null;

    public string $pricePeriod = 'day';

    public ?string $description = null;

    public ?int $category = null;

    public ?int $subcategory = null;

    public ?string $location = null;

    public ?string $locationQuery = null;

    public bool $showLocationSuggestions = false;

    public ?int $adId = null;

    public function mount(?int $adId = null): void
    {
        $this->categories = AdCategory::query()
            ->active()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        if ($adId) {
            $this->loadAd($adId);
        }
    }

    public function getChildrenProperty(): Collection
    {
        if ($this->category === null) {
            return collect();
        }

        return AdCategory::query()
            ->active()
            ->where('parent_id', (int) $this->category)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function updatedCategory($value): void
    {
        $this->category = $value !== null && $value !== '' ? (int) $value : null;
        // Reset subcategory when parent changes
        $this->subcategory = null;
    }

    public function render(): View
    {
        return view('livewire.ads.create-ad-form', [
            'children' => $this->children,
            'locationSuggestions' => $this->locationSuggestions(),
        ]);
    }

    protected function locationSuggestions(): Collection
    {
        $term = trim((string) ($this->locationQuery ?? ''));

        if (mb_strlen($term) < 2) {
            return collect();
        }

        return Postnummerregister::query()
            ->select('Poststed')
            ->where('Poststed', 'like', $term.'%')
            ->groupBy('Poststed')
            ->orderBy('Poststed')
            ->limit(10)
            ->pluck('Poststed');
    }

    public function selectLocation(string $value): void
    {
        $this->location = $value;
        $this->locationQuery = $value;
        $this->showLocationSuggestions = false;
    }

    public function updatedLocationQuery(): void
    {
        $this->showLocationSuggestions = true;
        // Keep the stored location in sync with what the user typed/selected
        $this->location = $this->locationQuery;
    }

    public function submit(): void
    {
        $validated = $this->validate([
            'adName' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'pricePeriod' => ['required', Rule::in(['day', 'week', 'month', 'year'])],
            'description' => ['required', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'integer', Rule::exists('ad_categories', 'id')->where(fn ($q) => $q->whereNull('parent_id'))],
            'subcategory' => ['nullable', 'integer', Rule::exists('ad_categories', 'id')->where(fn ($q) => $q->where('parent_id', $this->category))],
        ]);

        $user = Auth::user();
        if (! $user) {
            abort(403);
        }
        if ($this->adId) {
            $ad = Ad::query()->forUser($user->id)->findOrFail($this->adId);
            $ad->update([
                'ad_name' => $validated['adName'],
                'price' => $validated['price'],
                'price_period' => $validated['pricePeriod'],
                'description' => $validated['description'],
                'category_id' => $validated['category'],
                'subcategory_id' => $validated['subcategory'] ?? null,
                'location' => $validated['location'] ?? null,
            ]);
            $this->dispatch('ad-updated');
        } else {
            Ad::query()->create([
                'user_id' => $user->id,
                'ad_name' => $validated['adName'],
                'price' => $validated['price'],
                'price_period' => $validated['pricePeriod'],
                'description' => $validated['description'],
                'category_id' => $validated['category'],
                'subcategory_id' => $validated['subcategory'] ?? null,
                'location' => $validated['location'] ?? null,
                'images' => [],
            ]);
            $this->dispatch('ad-created');
            // Flash success for dashboard
            session()->flash('status', __('Ad saved successfully'));
            // Redirect to dashboard after creating a new ad
            $this->redirectRoute('dashboard');
        }

        $this->reset(['adId', 'adName', 'price', 'pricePeriod', 'description', 'category', 'subcategory', 'location', 'locationQuery']);
    }

    #[On('edit-ad')]
    public function loadAd(int $id): void
    {
        $user = Auth::user();
        if (! $user) {
            abort(403);
        }
        $ad = Ad::query()->forUser($user->id)->findOrFail($id);

        $this->adId = $ad->id;
        $this->adName = $ad->ad_name;
        $this->price = (int) $ad->price;
        $this->pricePeriod = $ad->price_period;
        $this->description = $ad->description;
        $this->category = $ad->category_id;
        $this->subcategory = $ad->subcategory_id;
        $this->location = $ad->location;
        $this->locationQuery = $ad->location;
    }
}
