<div class="input-group mb-3" x-data="{
  searchTerm: '',
  
  init() {
    // Listen for filter state updates to sync search term
    this.$el.addEventListener('filter-state-updated', (e) => {
      this.searchTerm = e.detail.search || '';
      this.$refs.searchInput.value = this.searchTerm;
    });
  },
  
  performSearch() {
    Livewire.dispatch('guests-ads:set-search', { value: this.searchTerm });
  },
  
  clearSearch() {
    this.searchTerm = '';
    this.$refs.searchInput.value = '';
    Livewire.dispatch('guests-ads:set-search', { value: null });
  }
}">
  <span class="input-group-text"><i class="bi bi-search"></i></span>
  <div class="form-floating">
    <input 
      type="text" 
      class="form-control" 
      id="floatingInputGroup1" 
      placeholder="Search"
      x-ref="searchInput"
      x-model="searchTerm"
      @input.debounce.500ms="performSearch()"
      @keyup.enter="performSearch()"
    >
    <label for="floatingInputGroup1">{{ __('Search ads...') }}</label>
  </div>
  <button 
    class="btn btn-outline-secondary" 
    type="button" 
    @click="clearSearch()"
    x-show="searchTerm.length > 0"
    style="display: none;"
  >
    <i class="bi bi-x-circle"></i>
  </button>
</div>

