<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

<meta name="description" content="" />

<!-- BEGIN: Vendor CSS-->
@vite([
    'resources/assets/vendor/libs/node-waves/node-waves.scss',
])

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap" rel="stylesheet">
@vite([
    'resources/assets/vendor/fonts/tabler-icons.scss',
    'resources/assets/vendor/fonts/flag-icons.scss',
    'resources/assets/vendor/fonts/fontawesome.scss',
])


<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')

<!-- Core CSS -->
@vite([
    'resources/assets/vendor/scss/core.scss',
    'resources/assets/css/demo.css',
])

<!-- Vendor Styles -->
@vite([
    'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss',
    'resources/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.scss',
    'resources/assets/vendor/libs/typeahead-js/typeahead.scss',
    'resources/assets/vendor/libs/select2/select2.scss',
    'resources/assets/vendor/libs/tagify/tagify.scss',
    'resources/assets/vendor/libs/animate-css/animate.scss',
    'resources/assets/vendor/libs/bootstrap-select/bootstrap-select.scss',
    'resources/assets/vendor/libs/notyf/notyf.scss',
])

@yield('vendor-style')

<!-- Page Styles -->
@yield('page-style')

<!-- app CSS -->
@vite(['resources/css/app.css'])
<!-- END: app CSS-->
