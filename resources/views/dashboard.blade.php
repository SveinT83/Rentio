<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mt-5 bg-white p-4 rounded">
        <div class="p-4 text-dark">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                    
            <div class="row mt-3">
                <div class="col-10">
                    {{ __("You're logged in!") }}
                </div>

                <div class="col-2 text-end">
                    <a href="{{ route('ads.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-1"></i>
                        {{ __('Create New Ad') }}
                    </a>
                </div>
            </div>
                    
            <!-- Split the view in half to show the create ad form -->
            <div class="row mt-3">

                <!-- Liste over ads som brukeren har laget ifra før -->
                <div class="col-md-12">
                    <div class="mt-6">
                        <livewire:ads.ads-list />
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
