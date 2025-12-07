<div>
    <div class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-12 col-md-3">
                <label class="form-label">{{ __('Category') }}</label>
                <input type="number" class="form-control" wire:model.lazy="categoryId" placeholder="ID" />
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label">{{ __('Subcategory') }}</label>
                <input type="number" class="form-control" wire:model.lazy="subcategoryId" placeholder="ID" />
            </div>
            <div class="col-12 col-md-3">
                <label class="form-label">{{ __('Location') }}</label>
                <input type="text" class="form-control" wire:model.lazy="location" placeholder="{{ __('City/Town') }}" />
            </div>
            <div class="col-12 col-md-3 text-end">
                <button class="btn btn-outline-secondary" wire:click="$set('categoryId', null); $set('subcategoryId', null); $set('location', null)">
                    <i class="bi bi-x-circle me-1"></i>{{ __('Clear Filters') }}
                </button>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        
        @forelse($ads as $ad)
            
            <x-guests.ad-card :ad="$ad" />


        @empty
            {{ __('No ads yet') }}
        @endforelse
    </div>
</div>