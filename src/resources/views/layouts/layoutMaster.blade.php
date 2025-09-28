<!doctype html>
<html lang="{{ app()->getLocale() }}" class="layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
      data-skin="default"
      data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}"
      data-template="horizontal-menu-template" data-bs-theme="light">

<head>
    @include('sections.head')
    <title>
        @yield('title') | {{trans('app.brand_name') }}
    </title>
</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
    <div class="layout-container">
        <!-- Navbar -->
        @include('sections.navbar')
        <!-- / Navbar -->
        <!-- Layout container -->
        <div class="layout-page">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Menu -->
                <x-menu></x-menu>
                <!-- / Menu -->

                <!-- Content -->
                <div class="container flex-grow-1 container-p-y">
                    @if (session('message'))
                        <x-alert-message :type="session('message')['type']" :content="session('message')['content']"
                                         :dismissible="true"/>
                    @endif
                    <div class="layout-services">
                        @yield('content')
                    </div>
                </div>
                <!--/ Content -->

                <!-- Footer -->
                @include('sections.footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!--/ Content wrapper -->
        </div>

        <!--/ Layout container -->
    </div>
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>

<!--/ Layout wrapper -->


@include('sections.scripts')
</body>

</html>
