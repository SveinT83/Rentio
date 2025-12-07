<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row justify-content-between">
        <div class="col-auto">
            <h3 class="mb-3">{{ __('Create New Ad') }}</h3>
        </div>
        <div class="col-auto">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('dashboard') }}"><i class="bi bi-arrow-counterclockwise"></i> {{ __('Back to Dashboard') }}</a>
        </div>
    </div>

    <livewire:ads.create-ad-form />


</x-app-layout>