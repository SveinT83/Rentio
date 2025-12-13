<!-- ----------------------------------------------------------------------- -->
<!-- ABOUT -->
<!-- ----------------------------------------------------------------------- -->

<x-guest-layout>

    <!-- ------------------------------- -->
    <!-- Main Container -->
    <!-- ------------------------------- -->
    <div class="container">

        <div class="row mb-3 pb-3">
            <div class="col-12">
                <h1 class="mb-3">Våre priser</h1>

                <h3 class="mt-2">Prisene over viser planlagt prismodell når Rentio lanseres offisielt. Ingen betaling før beta er avsluttet.</h3>
            </div>
        </div>

        <!-- ------------------------------- -->
        <!-- Price colums -->
        <!-- ------------------------------- -->
        <div class="row g-4">
            <div class="col-12 col-lg-3">
                <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ __("Gratis") }}</h5>
                    <div class="display-6 fw-bold">0 kr</div>
                    <div class="text-muted mb-3">{{ __("per måned") }}</div>

                    <hr>

                    <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>{{ __("Opptil 1") }}</strong> {{ __("annonse") }}</li>
                    <li class="text-muted small">{{ __("Passer for private") }}</li>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ __("Start") }}</h5>
                    <div class="display-6 fw-bold">149 {{ __("kr") }}</div>
                    <div class="text-muted mb-3">{{ __("per måned") }}</div>

                    <hr>

                    <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>{{ __("Opptil") }} 5</strong> {{ __("annonser") }}</li>
                    <li class="text-muted small">{{ __("Passer for små utleiere") }}</li>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ __("Standard") }}</h5>
                    <div class="display-6 fw-bold">249 {{ __("kr") }}</div>
                    <div class="text-muted mb-3">{{ __("per måned") }}</div>

                    <hr>

                    <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>{{ __("Opptil") }} 10</strong> {{ __("annonser") }}</li>
                    <li class="text-muted small">{{ __("For de fleste bedrifter") }}</li>
                    </ul>
                </div>
                </div>
            </div>

            <div class="col-12 col-lg-3">
                <div class="card h-100 shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title mb-1">{{ __("Pro") }}</h5>
                    <div class="display-6 fw-bold">449 {{ __("kr") }}</div>
                    <div class="text-muted mb-3">{{ __("per måned") }}</div>

                    <hr>

                    <ul class="list-unstyled mb-0">
                    <li class="mb-2"><strong>{{ __("Opptil") }} 20</strong> {{ __("annonser") }}</li>
                    <li class="text-muted small">{{ __("For større aktører") }}</li>
                    </ul>
                </div>
                </div>
            </div>
            </div>

    </div>

</x-guest-layout>
