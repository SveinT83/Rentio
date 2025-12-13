<!-- ----------------------------------------------------------------------- -->
<!-- Profile Information Update Form -------------------------------------------- -->
<!-- ----------------------------------------------------------------------- -->

<section>
    <header class="mb-4">
        <h2 class="h5 mb-1">
            {{ __('Profil informasjon') }}
        </h2>

        <p class="text-muted mb-0">
            {{ __("Oppdater profilinformasjon og e-postadresse.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="mb-3">
            <x-input-label for="name" :value="__('Navn')" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="form-control"
                :value="old('name', $user->name)"
                required
                autofocus
                autocomplete="name"
            />
            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <x-input-label for="email" :value="__('E-post')" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="form-control"
                :value="old('email', $user->email)"
                required
                autocomplete="username"
            />
            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <div class="alert alert-warning py-2 mb-2">
                        <small>
                            {{ __('E-postadressen din er ikke verifisert.') }}
                        </small>

                        <button
                            type="submit"
                            form="send-verification"
                            class="btn btn-link p-0 ms-1 align-baseline"
                        >
                            {{ __('Send verifiseringsmail på nytt') }}
                        </button>
                    </div>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success py-2 mb-0">
                            <small>{{ __('Ny verifiseringslenke er sendt til e-posten din.') }}</small>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        {{-- Tel --}}
        <div class="mb-3">
            <x-input-label for="tel" :value="__('Mobilnummer')" />
            <x-text-input
                id="tel"
                name="tel"
                type="number"
                class="form-control"
                :value="old('tel', $user->tel)"
                autofocus
                autocomplete="tel"
            />
            <x-input-error class="invalid-feedback d-block" :messages="$errors->get('tel')" />
        </div>

        {{-- Actions --}}
        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary">
                {{ __('Lagre') }}
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-muted small">{{ __('Lagret.') }}</span>
            @endif
        </div>
    </form>
</section>
