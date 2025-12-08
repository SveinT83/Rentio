<div>

    <x-guests.ad-filter :categories="$categories" :locations="$locations" />

    <script>
        // Optional: expose a helper to clear filters globally
        window.clearGuestAdsFilters = function() {
            // Try to find the Alpine component and call clearAll
            const filterNav = document.querySelector('[x-data]');
            if (filterNav && filterNav._x_dataStack && filterNav._x_dataStack[0].clearAll) {
                filterNav._x_dataStack[0].clearAll();
            } else {
                // Fallback to dispatching events and clearing cookies
                document.cookie = 'guestAdsFilters=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                Livewire.dispatch('guests-ads:set-category', { id: null });
                Livewire.dispatch('guests-ads:set-subcategory', { id: null });
                Livewire.dispatch('guests-ads:set-location', { value: null });
                Livewire.dispatch('guests-ads:set-municipality', { value: null });
                Livewire.dispatch('guests-ads:set-search', { value: null });
            }
        };
    </script>
</div>