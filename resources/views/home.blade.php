<x-guest-layout>

    <div class="container">

        <!-- Top Level Row -->
        <div class="row">

            <!-- Left Column: Search and Filters and ADS-->
            <div class="col-10">
                <div class="row mb-3">
                    <div class="col-10">
                        <x-ads-search />
                    </div>
                    <div class="col-2">
                        <livewire:guests.ads.FilterLists />
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">

                        <h2>{{ __('Ads') }}</h2>

                        <livewire:guests.ads.AdsList />
                    </div>
                </div>
            </div> <!-- End Left Column -->

            <!-- Right Column: Sidebar Ads -->
            <div class="col-lg-2">
                <h2>{{ __('Top Ads') }}</h2>
                <div class="d-flex flex-column">
                    @forelse(($popularAds ?? []) as $topAd)
                        <x-guests.ad-card-small :ad="$topAd" />
                    @empty
                        <p class="text-muted small">{{ __('No popular ads yet') }}</p>
                    @endforelse
                </div>
            </div> <!-- End Right Column -->
        </div> <!-- End Top Level Row -->
    </div>

</x-guest-layout>
