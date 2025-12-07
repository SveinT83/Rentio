<a href="{{ route('guests.ads.show', $ad->id) }}" class="card col-md-5 col-lg-2 m-2 p-0 text-decoration-none">
    <img src="https://via.placeholder.com/600x400" class="card-img-top" alt="...">

    <div class="card-body">
        <h5 class="card-title mb-1">{{ $ad->ad_name }}</h5>
        
        <p class="card-text text-muted small mb-2">
            {{ number_format($ad->price, 0, ',', ' ') }} kr {{ __($ad->price_period) }}
        </p>
        <div class="text-muted small">
            {{ $ad->category?->name }}@if($ad->subcategory) / {{ $ad->subcategory->name }}@endif
        </div>
    </div>

    <div class="card-footer text-body-secondary text-muted small">
        <div class="d-flex justify-content-between align-items-center">
            <span><i class="bi bi-geo-alt-fill"></i> {{ $ad->location ?? __('Unknown location') }}</span>
            <span>{{ $ad->created_at?->diffForHumans() }}</span>
        </div>
    </div>
</a>