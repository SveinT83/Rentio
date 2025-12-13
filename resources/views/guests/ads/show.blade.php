<!-- --------------------------------------------------------------------- -->
<!-- Show AD to guests                                                     -->
<!-- Route: guests.ads.show                                                -->
<!-- Controller: Guests\GuestAdController@show                                 -->
<!-- --------------------------------------------------------------------- -->

<x-guest-layout>
    <div class="container my-4">

        <!-- ------------------------------- -->
        <!-- Back button row -->
        <!-- ------------------------------- -->
        <div class="row mb-3">
            <div class="col-12 text-end">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> {{ __('Back') }}
                </a>
            </div>
        </div>

        <div class="row">

            <!-- ----------------------------------------------------------------------- -->
            <!-- Ad Card Column -->
            <!-- ----------------------------------------------------------------------- -->
            <div class="col-md-10">

                <!-- ----------------------------------------------------------------------- -->
                <!-- Ad Card -->
                <!-- ----------------------------------------------------------------------- -->
                <div class="card mb-4">

                    <div class="card-body">

                        <!-- ------------------------------- -->
                        <!-- Split -->
                        <!-- ------------------------------- -->
                        <div class="row">

                            <!-- ------------------------------- -->
                            <!-- Image -->
                            <!-- ------------------------------- -->
                            <div class="col-md-6">

                                <img src="https://via.placeholder.com/600x400" class="img-fluid rounded" alt="Ad Image">

                            </div> <!-- Image END -->

                            <!-- ------------------------------- -->
                            <!-- Ad -->
                            <!-- ------------------------------- -->
                            <div class="col-md-6">
                                <!-- Ad Title -->
                                <h1 class="h3 mb-3">{{ $ad->ad_name }}</h1>

                                <!-- Price and Period -->
                                <div class="text-muted mb-2">
                                    {{ number_format($ad->price, 0, ',', ' ') }} kr · {{ __($ad->price_period) }}
                                </div>

                                <!-- Category and Subcategory -->
                                <div class="mb-3">
                                    <span class="badge bg-secondary">
                                        {{ $ad->category?->name ?? __('Unknown category') }}
                                        @if($ad->subcategory)
                                            / {{ $ad->subcategory->name }}
                                        @endif
                                    </span>
                                </div>

                                <!-- Description -->
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {!! nl2br(e($ad->description)) !!}
                                    </div>
                                </div>

                                <!-- Contact Annonsør Button to the right-->
                                @php
                                    $settings = $ad->user->settings;
                                @endphp

                                <div class="row">

                                    <!-- Show tel if allowed in settings and tel is filled -->
                                    @if(($settings->show_tel ?? false) && filled($ad->user->tel))
                                        <a href="tel:{{ $ad->user->tel ?? '—' }}"
                                            class="btn btn-primary mb-2">
                                            <i class="bi bi-telephone-fill"></i>
                                            {{ $ad->user->tel ?? '—' }}
                                        </a>
                                    @endif

                                    <!-- Show email if allowed in settings and email is filled -->
                                    @if(($settings->show_email ?? false) && filled($ad->user->email))
                                        <a href="mailto:{{ $ad->user?->email ?? '—' }}?subject={{ urlencode('Forespørsel av din annonse: ' . $ad->ad_name) }}"
                                            class="btn btn-primary mb-1">
                                            <i class="bi bi-envelope-fill me-1"></i>
                                            {{ __('E-mail to') }} {{ $ad->user?->name ?? '—' }}
                                        </a>
                                    @endif
                                </div> <!-- Contact Annonsør Button END -->
                            </div> <!-- Ad END -->
                        </div>
                    </div> <!-- End Card Body -->

                    <!-- ------------------------------- -->
                    <!-- Card Footer -->
                    <!-- ------------------------------- -->
                    <div class="card-footer text-body-secondary text-muted small">
                        <div class="row">
                            <!-- Left aligned posted and updated timestamps -->
                            <div class="col-6">
                                {{ __('Posted') }}: {{ $ad->created_at?->format('Y-m-d H:i') }}
                                @if($ad->updated_at)
                                    · {{ __('Updated') }}: {{ $ad->updated_at->diffForHumans() }}
                                @endif
                            </div>

                            <!-- Right aligned location -->
                            <div class="col-6 text-end">
                                <i class="bi bi-geo-alt-fill"></i>
                                {{ $ad->location ?? __('Unknown location') }}
                            </div>

                        </div> <!-- End Row -->
                    </div> <!-- End Card Footer -->
                </div> <!-- End Ad Card -->

                <livewire:guests.ads.AdsList />

            </div> <!-- End Ad Card Column -->

            <!-- ----------------------------------------------------------------------- -->
            <!-- Sidebar Column -->
            <!-- ----------------------------------------------------------------------- -->
            <div class="col-md-2">

                <!-- ------------------------------- -->
                <!-- Annonsør Card -->
                <!-- ------------------------------- -->
                <div class="card mb-4">
                    <!-- Card Body -->
                    <div class="card-body text-center">

                        <!-- Card Title -->
                        <h5 class="card-title strong">Annonsør</h5>

                        <!-- Card Image -->
                        <img src="/images/defaults/default-profile.png" class="card-img-top" alt="Profile image">

                        <!-- Annonsør Name -->
                        <h3>{{ $ad->user?->name ?? '—' }}</h3>

                        <!-- View Profile button disabled -->
                        <a href="#" class="btn btn-outline-secondary disabled">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ __('View Profile') }}
                        </a>

                    </div> <!-- End Card Body -->
                </div> <!-- End Annonsør Card -->

                <!-- ------------------------------- -->
                <!-- Relaterte annonser fra samme bruker -->
                <!-- ------------------------------- -->
                <div class="card mb-4">
                    <div class="card-header">{{ __('Related ads from this user') }}</div>
                    <div class="card-body p-0 m-0">
                        <livewire:guests.ads.related-ads-from-user :userId="$ad->user?->id" :excludeId="$ad->id" />
                    </div>
                </div>

            </div> <!-- End Sidebar Column -->
        </div> <!-- End og first Row -->
    </div> <!-- End Container -->
</x-guest-layout>
