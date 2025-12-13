<!-- ----------------------------------------------------------------------- -->
<!-- Footer - In the bottom of all pages -->
<!-- ----------------------------------------------------------------------- -->

<!-- ------------------------------- -->
<!-- Main Row -->
<!-- ------------------------------- -->
<div class="row">

    <!-- ------------------------------- -->
    <!-- Copyright -->
    <!-- ------------------------------- -->
    <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
        <p>V2 - Beta &copy; {{ date('Y') }} {{ 'Lerstadgrind Transport' }}. {{ __('All rights reserved.') }}</p>
    </div>

    <!-- ------------------------------- -->
    <!-- Footer links -->
    <!-- ------------------------------- -->
    <div class="col-md-4 text-center text-md-start mb-3 mb-md-0">
        <ul class="nav">

            <!-- About -->
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/about">{{ __('About') }}</a>
            </li>

            <!-- Price -->
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/price">{{ __('Price') }}</a>
            </li>

            <!-- GDPR -->
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="/gdpr">{{ __('GDPR') }}</a>
            </li>
        </ul>
    </div>

    <!-- ------------------------------- -->
    <!-- Trønder Data -->
    <!-- ------------------------------- -->
    <div class="col-md-4 text-center text-md-end">
        {{ __('Powered by') }} <a href="https://tronderdata.no" class="text-decoration-none text-light" target="_blank">Trønder Data</a>
    </div>
</div>
