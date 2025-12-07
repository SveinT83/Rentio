<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ad Profile') }}
        </h2>
    </x-slot>

    <div class="container mt-5 bg-white p-4 rounded">
        <div class="p-6 text-gray-900">

            <div class="row justify-content-between">
                <!-- Ad Name -->
                <div class="col-auto">
                    <h5 class="mb-1">{{ $ad->ad_name }}</h5>

                    <div class="text-muted">{{ $ad->price }} / {{ $ad->price_period }}</div>

                    @if($ad->location)
                        <div class="text-muted">{{ $ad->location }}</div>
                    @endif

                    <div class="mt-2">
                        <span class="badge bg-{{ $ad->is_active ? 'success' : 'secondary' }}">{{ $ad->is_active ? __('Active') : __('Inactive') }}</span>
                        <span class="badge bg-{{ $ad->is_available ? 'info' : 'dark' }}">{{ $ad->is_available ? __('Available') : __('Unavailable/Rented') }}</span>
                    </div>

                </div>

                <div class="col-auto">
                    <a class="btn btn-outline-secondary btn-sm" href="{{ route('dashboard') }}"><i class="bi bi-arrow-counterclockwise"></i> {{ __('Back to Dashboard') }}</a>
                </div>
            </div>


            <div class="row justify-content-start mt-4 mb-4">

                <!-- Mark as Available/Unavailable -->
                <form class="col-auto" method="POST" action="{{ route('ads.toggle-availability', $ad) }}">
                    @csrf
                    <button class="btn btn-outline-primary" type="submit">
                        {{ $ad->is_available ? __('Mark Unavailable/Rented') : __('Mark Available') }}
                    </button>
                </form>

                <!-- Activate/Deactivate Ad -->
                <form class="col-auto" method="POST" action="{{ route('ads.toggle-active', $ad) }}">
                    @csrf
                    <button class="btn btn-outline-secondary" type="submit">
                        {{ $ad->is_active ? __('Deactivate') : __('Activate') }}
                    </button>
                </form>

                <!-- Delete Ad -->
                <form class="col-auto" method="POST" action="{{ route('ads.destroy', $ad) }}" onsubmit="return confirm('{{ __('Delete this ad?') }}')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger" type="submit">{{ __('Delete') }}</button>
                </form>
            </div>

            <div class="mt-4">
                <livewire:ads.create-ad-form :ad-id="$ad->id" />
            </div>
        </div>
    </div>
</x-app-layout>
