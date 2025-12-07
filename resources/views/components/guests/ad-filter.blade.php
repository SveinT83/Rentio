<nav class="navbar navbar fixed-top" x-data="{
  categoryId: null,
  subcategoryId: null,
  location: null,
  setCategory(id) { this.categoryId = id || null; this.subcategoryId = null; Livewire.dispatch('guests-ads:set-category', { id: this.categoryId }); },
  setSubcategory(id) { this.subcategoryId = id || null; Livewire.dispatch('guests-ads:set-subcategory', { id: this.subcategoryId }); },
  setLocation(val) { this.location = val || null; Livewire.dispatch('guests-ads:set-location', { value: this.location }); },
}">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Filter</a>
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
        <div class="row g-3">
            <div class="col-12 col-md-4">
            <label class="form-label">{{ __('Category') }}</label>
            <select class="form-select" @change="setCategory($event.target.value)">
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
        <div class="row g-3">
          <div class="col-12 col-md-4">
            <label class="form-label">{{ __('Subcategory') }}</label>
            <select class="form-select" :disabled="!categoryId" @change="setSubcategory($event.target.value)">
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
        <div class="row g-3 mb-3">
          <div class="col-12 col-md-4">
            <label class="form-label">{{ __('Location') }}</label>
            <input type="text" class="form-control" @input.debounce.400ms="setLocation($event.target.value)" placeholder="{{ __('City/Town') }}" />
          </div>
        </div>

        <!-- ------------------------------- -->
        <!-- Municipality -->
        <!-- ------------------------------- -->
        <div class="row g-3 mb-3">
          <div class="col-12 col-md-4">
            <label class="form-label">{{ __('Municipality') }}</label>
            <input type="text" class="form-control" @input.debounce.400ms="setMunicipality($event.target.value)" placeholder="{{ __('Municipality') }}" />
          </div>
        </div>

        <!-- Clear Filters Button -->
        <button class="btn btn-outline-secondary" @click="setCategory(null); setSubcategory(null); setLocation(null)"
        >
            <i class="bi bi-x-circle me-1"></i>{{ __('Clear Filters') }}
        </button>

      </div> <!-- End Offcanvas Body -->
    </div> <!-- End Offcanvas -->
  </div> <!-- End Container Fluid -->
</nav> <!-- End Navbar -->

