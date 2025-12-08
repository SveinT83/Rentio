<div>
    <div class="row">
        
        @forelse($ads as $ad)
            
            <div class="col-md-6">
                <x-guests.ad-card :ad="$ad" />
            </div>


        @empty
            <div class="col-12 text-center py-5">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ __('No ads found matching your criteria') }}
                </div>
            </div>
        @endforelse
    </div>

    @if($ads->count() > 0)
        <!-- Load More / Statistics Section -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                
                <!-- Statistics -->
                <p class="text-muted small mb-3">
                    {{ __('Showing :current of :total ads', ['current' => $currentlyShowing, 'total' => $totalAvailable]) }}
                </p>

                <!-- Load More Button -->
                @if($hasMoreAds)
                    <button 
                        wire:click="loadMore" 
                        class="btn btn-outline-primary" 
                        wire:loading.attr="disabled"
                        wire:loading.class="btn-outline-secondary"
                    >
                        <span wire:loading.remove wire:target="loadMore">
                            <i class="bi bi-arrow-down-circle me-2"></i>
                            {{ __('Load More Ads') }}
                        </span>
                        <span wire:loading wire:target="loadMore">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            {{ __('Loading...') }}
                        </span>
                    </button>

                    <!-- Optional: Infinite Scroll -->
                    <div 
                        x-data="{
                            init() {
                                let observer = new IntersectionObserver((entries) => {
                                    entries.forEach(entry => {
                                        if (entry.isIntersecting) {
                                            @this.loadMore();
                                        }
                                    });
                                });
                                observer.observe(this.$el);
                            }
                        }"
                        class="invisible"
                        style="height: 200px;"
                    ></div>
                @else
                    <p class="text-muted">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ __('All ads have been loaded') }}
                    </p>
                @endif
                
            </div>
        </div>
    @endif
</div>