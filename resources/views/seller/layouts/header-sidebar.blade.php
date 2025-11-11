<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="utf-8"/>
    <title>@yield('title', 'Seller Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Seller Dashboard" name="description"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">

    <link href="{{asset('admin-src/libs/toastr/build/toastr.min.css')}}" rel="stylesheet" type="text/css"/>
    <!-- App css -->
    <link href="{{asset('admin-src/css/app.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('admin-src/css/icons.min.css')}}" rel="stylesheet" type="text/css"/>
    
    <!-- Custom admin css (loaded last to override defaults) -->
    <link href="{{asset('css/admin.css')}}" rel="stylesheet" type="text/css"/>
    @yield('styles')

</head>

<!-- body start -->
<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid"
      data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default'
      data-sidebar-user='true'>

<!-- Begin page -->
<div id="wrapper">


    <!-- Topbar Start -->
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-end mb-0">

            <li class="d-none d-lg-block">
                <a id="light-dark-mode" role="button" href="javascript:void(0)"
                   class="nav-link dropdown-toggle waves-effect waves-light">
                    <i class="mdi mdi-moon-waning-crescent"></i>
                </a>
            </li>

            <li class="dropdown notification-list topbar-dropdown">
                <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown"
                   href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    @if(auth()->check() && auth()->user()->avatar)
                        <img src="{{asset(auth()->user()->avatar) }}" alt="user-image" class="rounded-circle">
                    @else
                        <img src="{{asset('admin-src/images/users/user-1.jpg')}}" alt="user-image"
                             class="rounded-circle">
                    @endif
                    <span class="pro-user-name ms-1">
                                    {{auth()->user()->name}} <i class="mdi mdi-chevron-down"></i>
                                </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>

                    <!-- item-->
                    <a href="{{route('profile.index')}}" class="dropdown-item notify-item">
                        <i class="fe-user"></i>
                        <span>My Account</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                    <a href="javascript:void(0)" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                       class="dropdown-item notify-item">
                        <i class="fe-log-out"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </div>
            </li>

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{route('seller.products.index')}}" class="logo logo-light text-center">
                <span class="logo-sm">
                    <img src="{{asset('/logo.png')}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{asset('/logo.png')}}" alt="" height="48">
                </span>
            </a>
            <a href="{{route('seller.products.index')}}" class="logo logo-dark text-center">
                <span class="logo-sm">
                    <img src="{{asset('/logo.png')}}" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="{{asset('/logo.png')}}" alt="" height="48">
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
            <li>
                <button class="button-menu-mobile disable-btn waves-effect">
                    <i class="fe-menu"></i>
                </button>
            </li>

            <li>
                <h4 class="page-title-main">@yield('title', 'Dashboard')</h4>
            </li>

        </ul>

        <div class="clearfix"></div>

    </div>
    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left-side-menu">

        <div class="h-100" data-simplebar>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul id="side-menu">
                    <li>
                        <a href="{{ route('seller.products.index') }}">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="#sidebarProducts" data-bs-toggle="collapse">
                            <i class="mdi mdi-shopping"></i>
                            <span> Products </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarProducts">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{ route('seller.products.index') }}">All Products</a>
                                </li>
                                <li>
                                    <a href="{{ route('seller.products.create') }}">Add Product</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    
                    <li>
                        <a href="{{ route('seller.plans.select') }}">
                            <i class="mdi mdi-credit-card"></i>
                            <span> My Plan </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    @yield('content')
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor -->
<script src="{{asset('admin-src/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('admin-src/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('admin-src/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('admin-src/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('admin-src/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('admin-src/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('admin-src/libs/feather-icons/feather.min.js')}}"></script>

<!-- knob plugin -->
<script src="{{asset('admin-src/libs/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{asset('admin-src/libs/toastr/build/toastr.min.js')}}"></script>

<!-- App js-->
<script src="{{asset('admin-src/js/app.js')}}"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function () {
        let themeFromStorage = localStorage.getItem('theme')
        let themeIconFromStorage = localStorage.getItem('theme-icon')
        if (themeFromStorage && themeIconFromStorage) {
            document.body.setAttribute('data-layout-color', themeFromStorage)
            document.body.setAttribute('data-topbar-color', themeFromStorage)
            document.body.setAttribute('data-leftbar-color', themeFromStorage)
            $('#light-dark-mode i').removeClass('mdi mdi-moon-waning-crescent').removeClass('ti-shine').addClass(themeIconFromStorage)
        }
        $('#light-dark-mode').on('click', function () {
            let currentTheme = document.body.getAttribute('data-layout-color')
            let newTheme = 'light'
            let themeIconClass = 'mdi mdi-moon-waning-crescent'
            if (currentTheme === 'light') {
                newTheme = 'dark'
                themeIconClass = 'ti-shine'
            }
            document.body.setAttribute('data-layout-color', newTheme)
            document.body.setAttribute('data-topbar-color', newTheme)
            document.body.setAttribute('data-leftbar-color', newTheme)
            $(this).find('i').removeClass('mdi mdi-moon-waning-crescent').removeClass('ti-shine').addClass(themeIconClass)
            localStorage.setItem('theme', newTheme)
            localStorage.setItem('theme-icon', themeIconClass)
        })
        @if ($errors->any())
        @foreach ($errors->all() as $error)
        toastr.error('{{ $error }}')
        @endforeach
        @endif
    })
</script>
@yield('scripts')

</body>
</html>