<div>
    <x-guests.ad-filter :categories="$categories" />
    <script>
        // Optional: expose a helper to clear filters globally
        window.clearGuestAdsFilters = function() {
            Livewire.dispatch('guests-ads:set-category', { id: null });
            Livewire.dispatch('guests-ads:set-subcategory', { id: null });
            Livewire.dispatch('guests-ads:set-location', { value: null });
        };
    </script>
</div>