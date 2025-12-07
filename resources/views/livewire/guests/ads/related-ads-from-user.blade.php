<div class="row justify-content-center">
    @forelse($ads as $ad)
        <div class="col-md-12">
            <x-guests.ad-card-small :ad="$ad" />
        </div>
    @empty
        <div class="text-muted small py-3 text-center w-100">{{ __('No related ads') }}</div>
    @endforelse
</div>
