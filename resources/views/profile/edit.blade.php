<!-- ----------------------------------------------------------------------- -->
<!-- Profile Edit Page -->
<!-- ----------------------------------------------------------------------- -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">
            {{ __('Profil') }}
        </h2>
    </x-slot>

        <div class="container">
            <div class="row justify-content-center">

                <!-- ------------------------------- -->
                <!-- Info Section -->
                <!-- ------------------------------- -->
                <x-card>
                    @include('profile.partials.update-profile-information-form')
                </x-card>

                <!-- ------------------------------- -->
                <!-- Settings -->
                <!-- ------------------------------- -->
                <x-card>
                    @include('profile.partials.update-user-settings-form')
                </x-card>


                <!-- ------------------------------- -->
                <!-- Update password -->
                <!-- ------------------------------- -->
                <x-card>
                    @include('profile.partials.update-password-form')
                </x-card>

                <!-- ------------------------------- -->
                <!-- Delete user -->
                <!-- ------------------------------- -->
                <x-card>
                    <x-slot:class>border-danger</x-slot:class>
                    @include('profile.partials.delete-user-form')
                </x-card>

            </div>
        </div>
</x-app-layout>
