<nav class="layout-navbar navbar navbar-expand-xl align-items-center" id="layout-navbar">
    <div class="container">
        <div class="navbar-brand app-brand demo d-none d-xl-flex align-items-center py-0 me-4 ms-0">
            <a href="{{route('admin.dashboard')}}" class="app-brand-link me-4">
                <img src="{{asset('/assets/images/logo-esanj.png')}}" alt="logo">
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                <i
                        class="icon-base ti tabler-x icon-sm d-flex align-items-center justify-content-center"></i>
            </a>
        </div>

        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="icon-base ti tabler-menu-2 icon-md"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-md-auto">
                <!-- theme -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                       href="javascript:void(0);" data-bs-toggle="dropdown">
                        <i class="icon-base ti tabler-sun icon-22px text-heading"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <button type="button" class="dropdown-item align-items-center waves-effect"
                                    data-bs-theme-value="light" aria-pressed="false">
                                            <span><i class="icon-base ti tabler-sun icon-22px me-3"
                                                     data-icon="sun"></i>Light</span>
                            </button>
                        </li>
                        <li>
                            <button type="button"
                                    class="dropdown-item align-items-center waves-effect active"
                                    data-bs-theme-value="dark" aria-pressed="true">
                                            <span><i class="icon-base ti tabler-moon icon-22px me-3"
                                                     data-icon="moon-stars"></i>Dark</span>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="dropdown-item align-items-center waves-effect"
                                    data-bs-theme-value="system" aria-pressed="false">
                                            <span><i class="icon-base ti tabler-device-desktop-analytics icon-22px me-3"
                                                     data-icon="device-desktop-analytics"></i>System</span>
                            </button>
                        </li>
                    </ul>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                       data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{asset('/assets/images/avatar-user.png')}}" alt class="rounded-circle"/>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item mt-0" href="pages-account-settings-account.html">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar avatar-online">
                                            <img src="{{asset('/assets/images/avatar-user.png')}}" alt
                                                 class="rounded-circle"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">{{\Illuminate\Support\Facades\Auth::guard('manager')->user()->name}}</h6>
                                        <small
                                                class="text-body-secondary">{{\Illuminate\Support\Facades\Auth::guard('manager')->user()->role}}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider my-1 mx-n2"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('admin.profile')}}">
                                <i class="icon-base ti tabler-user me-3 icon-md"></i><span
                                    class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <div class="d-grid px-2 pt-2 pb-1">
                                <a class="btn btn-sm btn-danger d-flex" href=""
                                   target="_blank">
                                    <small class="align-middle">Logout</small>
                                    <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!--/ User -->
            </ul>
        </div>
    </div>
</nav>
