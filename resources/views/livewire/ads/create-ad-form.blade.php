<!-- ------------------------------------------------------------ -->
<!-- resources/views/livewire/ads/create-ad-form.blade.php -->
<!-- ------------------------------------------------------------ -->

<!--    Created by: Svein Tore Christensen
        Date: 2024-06-06
        Description: Form for creating a new advertisement with fields for ad name, price, description, location (with autocomplete), category, and subcategory. -->


<!-- ------------------------------------------------------------ -->
<!-- Form in an Card style -->
<!-- ------------------------------------------------------------ -->
<form class="card" wire:submit.prevent="submit">

    <!-- Card Body -->
    <div class="card-body">

        <!-- Success Alert -->
        <div x-data="{ show: false }" x-init="
                window.addEventListener('ad-created', () => {
                    show = true;
                    setTimeout(() => show = false, 3000);
                });
                window.addEventListener('ad-updated', () => {
                    show = true;
                    setTimeout(() => show = false, 3000);
                });
            "
            x-show="show"
            x-transition.opacity
            class="alert alert-success"
            role="alert"
        >
            {{ __('Ad saved successfully') }}
        </div>

        <!-- Ad Name -->
        <div class="mb-3">
            <label for="adname" class="form-label">{{ __('Ad Name') }}</label>
            <input type="text" class="form-control" id="adname" placeholder="{{ __('Enter ad name') }}" wire:model="adName"  required>
        </div>

        <!-- Price & Price Period -->
        <div class="row mb-3">

            <!-- Price -->
            <div class="col-6">
                <div class="mb-3">
                    <label for="price" class="form-label">{{ __('Price') }}</label>
                    <input type="number" class="form-control" id="price" placeholder="{{ __('Enter price') }}" wire:model="price" required>
                </div>
            </div>

            <!-- Price Period -->
            <div class="col-6">
                <div class="mb-3">
                    <label for="pricePeriod" class="form-label">{{ __('Price Period') }}</label>
                    <select id="pricePeriod" class="form-select" wire:model.live="pricePeriod" required>
                        <option value="day">{{ __('Per day') }}</option>
                        <option value="week">{{ __('Per week') }}</option>
                        <option value="month">{{ __('Per month') }}</option>
                        <option value="year">{{ __('Per year') }}</option>
                    </select>
                </div>
            </div>

        </div>

        <!-- Image -->
        <div class="mb-3">
            <label for="imageUpload" class="form-label">{{ __('Image') }}</label>
            <input type="file" class="form-control" id="imageUpload" wire:model="imageUpload">
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">{{ __('Description') }}</label>
            <textarea class="form-control" id="description" rows="3" placeholder="{{ __('Enter description') }}" wire:model="description" required></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <!-- Category -->
                <div class="mb-3">
                    <label for="category" class="form-label">{{ __('Category') }}</label>
                    <select class="form-select" id="category" wire:model.live="category" required>
                        <option value="">{{ __('Select category') }}</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Child Categories -->
            <div class="col-6">
                <div class="mb-3">
                    <label class="form-label">{{ __('Subcategories') }}</label>
                    <select class="form-select" wire:model="subcategory"
                        @if(is_null($this->category)) disabled @endif>
                        <option value="">{{ __('Select subcategory') }}</option>
                        @foreach($children as $child)
                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Location with autocomplete -->
        <div class="mb-3 position-relative">
            <label for="location" class="form-label">{{ __('Location') }}</label>
            <input
                type="text"
                class="form-control"
                id="location"
                placeholder="{{ __('Start typing a place') }}"
                wire:model.live="locationQuery"
                autocomplete="off"
                list="location-options"
                required
            >

            <!-- Datalist for location suggestions -->
            <datalist id="location-options">
                @foreach($locationSuggestions as $suggestion)
                    <option value="{{ $suggestion }}"></option>
                @endforeach
            </datalist>
        </div>

        <!-- Button to submit the form -->
        <div class="row mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                {{ $adId ? __('Update Ad') : __('Create Ad') }}
            </button>
        </div>

    <!-- End Card Body -->
    </div>

<!-- End Form -->
</form>
