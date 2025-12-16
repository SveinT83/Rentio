<!-- ----------------------------------------------------------------------- -->
<!-- Ad Card Component -->
<!-- ----------------------------------------------------------------------- -->
<a href="{{ route('guests.ads.show', $ad->id) }}" class="card m-2 p-0 text-decoration-none" x-data="{}" @click.prevent="navigator.sendBeacon('{{ route('ads.view', $ad->id) }}'); window.location.href='{{ route('guests.ads.show', $ad->id) }}'">

    <!-- ------------------------------- -->
    <!-- Card Body -->
    <!-- ------------------------------- -->
    <div class="card-body">

        <!-- Top level row -->
        <div class="row">

            <!-- ------------------------------- -->
            <!-- Left side -->
            <!-- ------------------------------- -->
            <div class="col-md-6">

                <!-- ------------------------------- -->
                <!-- Image (Primary if available, else placeholder) -->
                <!-- ------------------------------- -->
                <img 
                    src="{{ $ad->primaryImage ? asset('storage/'.$ad->primaryImage->path) : 'https://placehold.co/200' }}" 
                    class="card-img-top"
                    style="aspect-ratio:1/1;object-fit:cover;object-position:center;"
                    alt="{{ $ad->ad_name }}"
                >

            </div> <!-- End Left side -->

            <!-- ------------------------------- -->
            <!-- Right side -->
            <!-- ------------------------------- -->
            <div class="col-md-6">

                <!-- ------------------------------- -->
                <!-- Card Title - Name of the ad -->
                <!-- ------------------------------- -->
                <h5 class="card-title mb-1">{{ $ad->ad_name }}</h5>
                
                <!-- ------------------------------- -->
                <!-- Price -->
                <!-- ------------------------------- -->
                <p class="card-text text-muted small mb-2">
                    {{ number_format($ad->price, 0, ',', ' ') }} kr {{ __($ad->price_period) }}
                </p>

                <!-- ------------------------------- -->
                <!--Category and Subcategory -->
                <!-- ------------------------------- -->
                <div class="text-muted small">
                    {{ $ad->category?->name }}@if($ad->subcategory) / {{ $ad->subcategory->name }}@endif
                </div>
            </div> <!-- End Right side -->
        </div> <!-- End Top level row -->
    </div>

    <!-- ------------------------------- -->
    <!-- Card Footer -->
    <!-- ------------------------------- -->
    <div class="card-footer text-body-secondary text-muted small">
        <div class="d-flex justify-content-between align-items-center">

            <!-- Location -->
            <span><i class="bi bi-geo-alt-fill"></i> {{ $ad->location ?? __('Unknown location') }}</span>
            
            <!-- Created At -->
            <span>{{ $ad->created_at?->diffForHumans() }}</span>
        </div>
    </div>
</a>