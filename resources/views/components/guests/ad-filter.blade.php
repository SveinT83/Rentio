<nav class="navbar navbar" x-data="{
  categoryId: null,
  subcategoryId: null,
  location: null,
  municipality: null,
  search: null,
  
  init() {
    // Load from cookies first
    this.loadFromCookies();
    
    // Then check URL parameters (can override cookies)
    const urlParams = new URLSearchParams(window.location.search);
    const categoryParam = urlParams.get('categoryId');
    const subcategoryParam = urlParams.get('subcategoryId');
    const locationParam = urlParams.get('location');
    const municipalityParam = urlParams.get('municipality');
    const searchParam = urlParams.get('search');
    
    if (categoryParam && categoryParam.trim() !== '') this.categoryId = parseInt(categoryParam);
    if (subcategoryParam && subcategoryParam.trim() !== '') this.subcategoryId = parseInt(subcategoryParam);
    if (locationParam && locationParam.trim() !== '') this.location = locationParam.trim();
    if (municipalityParam && municipalityParam.trim() !== '') this.municipality = municipalityParam.trim();
    if (searchParam && searchParam.trim() !== '') this.search = searchParam.trim();
    
    // Update form values to match state
    this.$nextTick(() => {
      this.updateFormValues();
      // Apply stored filters to Livewire if we have them and no URL params
      if (!window.location.search && (this.categoryId || this.subcategoryId || this.location || this.municipality || this.search)) {
        this.applyStoredFilters();
      }
    });
  },
  
  getCookie(name) {
    const value = '; ' + document.cookie;
    const parts = value.split('; ' + name + '=');
    if (parts.length === 2) {
      try {
        return decodeURIComponent(parts.pop().split(';').shift());
      } catch (e) {
        return null;
      }
    }
    return null;
  },
  
  setCookie(name, value, days = 30) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = name + '=' + encodeURIComponent(value) + '; expires=' + expires + '; path=/; SameSite=Lax';
  },
  
  loadFromCookies() {
    try {
      const stored = this.getCookie('guestAdsFilters');
      if (stored) {
        const filters = JSON.parse(stored);
        this.categoryId = filters.categoryId || null;
        this.subcategoryId = filters.subcategoryId || null;
        this.location = filters.location || null;
        this.municipality = filters.municipality || null;
        this.search = filters.search || null;
      }
    } catch (e) {
      console.warn('Failed to load filters from cookies:', e);
    }
  },
  
  saveToCookies() {
    try {
      const filters = {
        categoryId: this.categoryId,
        subcategoryId: this.subcategoryId,
        location: this.location,
        municipality: this.municipality,
        search: this.search
      };
      this.setCookie('guestAdsFilters', JSON.stringify(filters));
    } catch (e) {
      console.warn('Failed to save filters to cookies:', e);
    }
  },
  
  applyStoredFilters() {
    if (this.categoryId) Livewire.dispatch('guests-ads:set-category', { id: this.categoryId });
    if (this.subcategoryId) Livewire.dispatch('guests-ads:set-subcategory', { id: this.subcategoryId });
    if (this.location) Livewire.dispatch('guests-ads:set-location', { value: this.location });
    if (this.municipality) Livewire.dispatch('guests-ads:set-municipality', { value: this.municipality });
    if (this.search) Livewire.dispatch('guests-ads:set-search', { value: this.search });
  },
  
  updateFormValues() {
    // Update select elements to reflect current state
    const categorySelect = this.$el.querySelector('select[data-category]');
    const subcategorySelect = this.$el.querySelector('select[data-subcategory]');
    const locationInput = this.$el.querySelector('input[data-location]');
    const municipalityInput = this.$el.querySelector('input[data-municipality]');
    
    if (categorySelect) categorySelect.value = this.categoryId || '';
    if (subcategorySelect) subcategorySelect.value = this.subcategoryId || '';
    if (locationInput) locationInput.value = this.location || '';
    if (municipalityInput) municipalityInput.value = this.municipality || '';
  },
  
  setCategory(id) { 
    this.categoryId = id || null; 
    this.subcategoryId = null; 
    this.saveToCookies();
    Livewire.dispatch('guests-ads:set-category', { id: this.categoryId }); 
  },
  
  setSubcategory(id) { 
    this.subcategoryId = id || null; 
    this.saveToCookies();
    Livewire.dispatch('guests-ads:set-subcategory', { id: this.subcategoryId }); 
  },
  
  setLocation(val) { 
    this.location = val || null; 
    this.saveToCookies();
    Livewire.dispatch('guests-ads:set-location', { value: this.location }); 
  },
  
  setMunicipality(val) { 
    this.municipality = val || null; 
    this.saveToCookies();
    Livewire.dispatch('guests-ads:set-municipality', { value: this.municipality }); 
  },
  
  clearAll() {
    this.categoryId = null;
    this.subcategoryId = null;
    this.location = null;
    this.municipality = null;
    this.search = null;
    this.setCookie('guestAdsFilters', '', -1); // Delete cookie
    this.updateFormValues();
    Livewire.dispatch('guests-ads:set-category', { id: null });
    Livewire.dispatch('guests-ads:set-subcategory', { id: null });
    Livewire.dispatch('guests-ads:set-location', { value: null });
    Livewire.dispatch('guests-ads:set-municipality', { value: null });
    Livewire.dispatch('guests-ads:set-search', { value: null });
  }
}" @filter-state-updated.window="
  categoryId = $event.detail.categoryId;
  subcategoryId = $event.detail.subcategoryId;
  location = $event.detail.location;
  municipality = $event.detail.municipality;
  search = $event.detail.search;
  saveToCookies();
  updateFormValues();
">
  <div class="container-fluid">
    
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- Offcanvas Body -->
      <div class="offcanvas-body">

        <!-- ------------------------------- -->
        <!-- Parent Categories -->
        <!-- ------------------------------- -->
        <div class="row mb-3">
            <div class="col-12">
            <label class="form-label">{{ __('Category') }}</label>
            <select class="form-select" data-category @change="setCategory($event.target.value)">
                <option value="">{{ __('All categories') }}</option>
                @foreach(($categories ?? collect())->whereNull('parent_id') as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
            </div>
        </div>

        <!-- ------------------------------- -->
        <!-- Subcategory -->
        <!-- ------------------------------- -->
        <div class="row mb-3">
          <div class="col-12">
            <label class="form-label">{{ __('Subcategory') }}</label>
            <select class="form-select" data-subcategory :disabled="!categoryId" @change="setSubcategory($event.target.value)">
              <option value="">{{ __('All subcategories') }}</option>
              @foreach(($categories ?? collect()) as $child)
                <template x-if="categoryId && {{ (int) $child->parent_id }} === Number(categoryId)">
                  <option value="{{ $child->id }}">{{ $child->name }}</option>
                </template>
              @endforeach
            </select>
          </div>
        </div>


        <!-- ------------------------------- -->
        <!-- Location -->
        <!-- ------------------------------- -->
        <div class="row mb-3">
          <div class="col-12">
            <label class="form-label">{{ __('Location') }}</label>
            <input type="text" class="form-control" list="locationOptions" data-location @input.debounce.400ms="setLocation($event.target.value)" placeholder="{{ __('City/Town') }}" />
          
            <!-- Datalist for Location -->
            <datalist id="locationOptions">
              @foreach($locations ?? [] as $location)
                <option value="{{ $location }}">
              @endforeach
            </datalist>
          
          </div>
        </div>

        <!-- ------------------------------- -->
        <!-- Municipality -->
        <!-- ------------------------------- -->
        <div class="row mb-3">
          <div class="col-12">
            <label class="form-label">{{ __('Municipality') }}</label>
            <input type="text" class="form-control" data-municipality @input.debounce.400ms="setMunicipality($event.target.value)" placeholder="{{ __('Municipality') }}" />
          </div>
        </div>

        <!-- ------------------------------- -->
        <!-- Clear Filters Button -->
        <!-- ------------------------------- -->
        <div class="row">
          <button class="btn btn-outline-secondary" @click="clearAll()">
              <i class="bi bi-x-circle me-1"></i>{{ __('Clear Filters') }}
          </button>
        </div>

      </div> <!-- End Offcanvas Body -->
    </div> <!-- End Offcanvas -->
  </div> <!-- End Container Fluid -->
</nav> <!-- End Navbar -->

