<a href="{{ route('guests.ads.show', $ad->id) }}" class="card m-2 p-0">
    <img src="{{ $ad->primaryImage ? asset('storage/'.$ad->primaryImage->path) : 'https://placehold.co/200' }}" class="card-img-top" style="aspect-ratio:1/1;object-fit:cover;object-position:center;" alt="{{ $ad->ad_name }}">

    <!-- Card Body -->
    <div class="card-body">
        <h5 class="card-title">{{ $ad->ad_name }}</h5>
        
        <p class="card-text">
            {{ number_format($ad->price, 0, ',', ' ') }} kr {{ __($ad->price_period) }}
        </p>
    </div>

    <!-- Card Footer -->
    <div class="card-footer text-body-secondary">
        <div class="row text-muted small align-items-center">
            <div class="col-6">
                {{ $ad->category?->name }}
                @if($ad->subcategory)
                    / {{ $ad->subcategory->name }}
                @endif
            </div>
            <!-- Right aligned location -->
            <div class="col-6 text-end">
                <p> <i class="bi bi-geo-alt-fill"></i> {{ $ad->location ?? __('Unknown location') }}</p>
            </div>
        </div>
    </div>
</a>