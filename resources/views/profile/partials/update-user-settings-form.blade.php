<!-- ----------------------------------------------------------------------- -->
<!-- User Settings Update Form -->
<!-- ----------------------------------------------------------------------- -->

<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Kontakt instillinger') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Dine kontakt preferanser') }}
        </p>
    </header>

    <!-- ------------------------------- -->
    <!-- Form -->
    <!-- ------------------------------- -->
    <form method="post" action="{{ route('profile.update-settings') }}">
        @csrf
        @method('patch')

        {{-- Vis e-post adresse? --}}
        <div class="mb-3">
            <div class="form-check form-switch">
                <input
                    class="form-check-input" type="checkbox" role="switch" id="show_email"
                    name="show_email" value="1"
                    @checked(old('show_email', $user->settings->show_email ?? false))>

                <label class="form-check-label" for="show_email">
                    {{ __('Vis e-post på annonser') }}
                </label>
            </div>

            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('show_email')"/>
        </div>

        {{-- Vis mobilnummer --}}
        <div class="mb-3">
            <div class="form-check form-switch">
                <input
                    class="form-check-input" type="checkbox" role="switch" id="show_tel"
                    name="show_tel" value="1"
                    @checked(old('show_tel', $user->settings->show_tel ?? false))
                    @disabled(empty($user->tel))>

                <label class="form-check-label" for="show_tel">
                    {{ __('Vis mobilnummer på annonser') }}
                </label>
            </div>

            @empty($user->tel)
                <div class="form-text text-muted">
                    Legg inn mobilnummer i profilen for å kunne vise det på annonser.
                </div>
            @endempty

            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('show_tel')"/>
        </div>

        {{-- Actions --}}
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">
                {{ __('Lagre') }}
            </button>

            @if (session('status') === 'user-setting-updated')
                <span class="text-muted small">{{ __('Lagret.') }}</span>
            @endif
        </div>

    </form>

</section>
