<!-- BEGIN: Vendor JS-->
@vite([
    'resources/assets/vendor/libs/jquery/jquery.js',
    'resources/assets/vendor/libs/popper/popper.js',
    'resources/assets/vendor/js/bootstrap.js',
    'resources/assets/vendor/libs/node-waves/node-waves.js',
    'resources/assets/vendor/libs/@algolia/autocomplete-js.js',
])

@vite([
    'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
    'resources/assets/vendor/libs/hammer/hammer.js',
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.js',
    'resources/assets/vendor/libs/moment/moment.js',
    'resources/assets/js/forms-selects.js',
    'resources/assets/vendor/libs/select2/select2.js',
    'resources/assets/vendor/libs/tagify/tagify.js',
    'resources/assets/vendor/libs/notyf/notyf.js',
    'resources/assets/vendor/js/menu.js',
    'resources/assets/vendor/js/helpers.js',
])

@if(request()->filled('only_trash'))
    <script>
        window.only_trash = 1;
    </script>
@endif

@yield('vendor-script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
@vite(['resources/assets/js/config.js'])
@vite(['resources/assets/js/main.js'])
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<!-- app JS -->
@vite(['resources/js/app.js'])
<!-- END: app JS-->
