<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
    <link rel="apple-touch-icon" href="dashboard-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="dashboard-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard-assets/vendors/css/extensions/tether-theme-arrows.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/vendors/css/extensions/tether.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard-assets/vendors/css/extensions/shepherd-theme-default.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('dashboard-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/core/colors/palette-gradient.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/pages/dashboard-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/pages/card-analytics.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard-assets/css/plugins/tour/tour.css') }}">
    @yield('styles')
    <!-- END: Page CSS-->

    {{-- <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS--> --}}

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 2-columns  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon feather icon-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link"
                                id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span
                                    class="selected-language">English</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"
                                    data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a
                                    class="dropdown-item" href="#" data-language="fr"><i
                                        class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#"
                                    data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a
                                    class="dropdown-item" href="#" data-language="pt"><i
                                        class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
                        </li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon feather icon-maximize"></i></a></li>
                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span
                                        class="user-name text-bold-600">{{ Auth::user()->name }}</span><span
                                        class="user-status">Available</span></div><span><img class="round"
                                        src="{{ route('image.account', Auth::user()->user_image) }}" alt="avatar"
                                        height="40" width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i
                                        class="feather icon-power"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}"
                            class="img-fluid" width="130">
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                            data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a href="index.html"><i class="feather icon-home"></i><span class="menu-title"
                            data-i18n="Dashboard">Dashboard</span><span
                            class="badge badge badge-warning badge-pill float-right mr-2">1</span></a>
                    <ul class="menu-content">
                        <li><a href="{{ route('admin.dashboard.index') }}"><i class="feather icon-circle"></i><span
                                    class="menu-item" data-i18n="Analytics">Analytics</span></a>
                        </li>
                    </ul>
                </li>
                <li class=" navigation-header"><span>Apps</span>
                </li>
                <li class="nav-item"><a href="#"><i class="feather icon-user"></i><span class="menu-title"
                            data-i18n="User">User</span></a>
                    <ul class="menu-content">
                        <li @yield('users.list')><a href="{{ route('admin.users.index') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="List">List</span></a>
                        </li>
                        <li @yield('users.view')><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="View">View</span></a>
                        </li>
                        <li @yield('users.edit')><a href="#"><i class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="Edit">Edit</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a href="#"><i class="feather icon-clipboard"></i><span class="menu-title"
                            data-i18n="User">Frontend</span></a>
                    <ul class="menu-content">
                        <li @yield('frontend.terms')><a href="{{ route('admin.terms-of-use.create') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="View">Terms of
                                    Use</span></a>
                        </li>
                        <li @yield('frontend.privacy')><a href="{{ route('admin.privacy-policy.create') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="Edit">Privacy
                                    Policy</span></a>
                        </li>
                        <li @yield('frontend.about')><a href="{{ route('admin.about-us.create') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="Edit">About
                                    us</span></a>
                        </li>
                    </ul>
                </li>
                </li>
                <li class="nav-item">
                    <a href="#">
                        <i class="feather icon-compass"></i>
                        <span class="menu-title" data-i18n="User">Contents</span>
                    </a>
                    <ul class="menu-content">
                        <li @yield('lists.index')><a href="{{ route('admin.lists.index') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="List">All
                                    Lists</span></a>
                        </li>
                        <li @yield('posts.index')><a href="{{ route('admin.posts.index') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="View">All
                                    Posts</span></a>
                        </li>
                        <li @yield('journals.index')><a href="{{ route('admin.journals.index') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="Edit">All
                                    Journals</span></a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#">
                        <i class="feather icon-layout"></i>
                        <span class="menu-title" data-i18n="User">Blog</span>
                    </a>
                    <ul class="menu-content">
                        <li @yield('blog.index')><a href="{{ route('blog.index') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item" data-i18n="View">All
                                    Blogs</span></a>
                        </li>
                        <li @yield('blog.create')><a href="{{ route('blog.create') }}"><i
                                    class="feather icon-circle"></i><span class="menu-item"
                                    data-i18n="List">Create</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <style>
        .alert-fixed {
            position: fixed;
            bottom: 60px;
            left: 30px;
            width: 500px;
            z-index: 9999;
            border-radius: 0px;
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
            -webkit-animation-name: bounceInRight;
            animation-name: bounceInRight;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .alert-fixed .close:focus {
            outline: none;
        }
    </style>
    @if (session('success'))
    <div class="alert alert-fixed alert-success alert-dismissible show" role="alert">
        <strong>{{ session('success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-fixed alert-danger alert-dismissible show" role="alert">
        <strong>{{ session('error') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-fixed alert-danger alert-dismissible show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <ul class="mb-0">
            @foreach ($errors->all() as $message)
            <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('dashboard-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('dashboard-assets/vendors/js/charts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendors/js/extensions/tether.min.js') }}"></script>
    <script src="{{ asset('dashboard-assets/vendors/js/extensions/shepherd.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('dashboard-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('dashboard-assets/js/scripts/components.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('dashboard-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>
    @yield('scripts')
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
