<?php

namespace App\Livewire\Ads;

use App\Models\Ad;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdsList extends Component
{
    public string $sortBy = 'created_at';

    public string $sortDir = 'desc';

    public function setSort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'asc';
        }
    }
    public function select(int $id): void
    {
        $this->emit('adSelected', $id);
    }

    public function render(): View
    {
        $user = Auth::user();
        $ads = $user
            ? Ad::query()
                ->forUser($user->id)
                ->orderBy($this->sortBy, $this->sortDir)
                ->get()
            : collect();

        return view('livewire.ads.ads-list', [
            'ads' => $ads,
        ]);
    }
}
