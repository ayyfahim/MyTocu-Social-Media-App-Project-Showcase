<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {!! Robots::metaTag() !!}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- Meta Titles -->
    <meta name="api-base-url" content="{{ url('/') }}" />
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/favicon_1.png') }}" type="image/x-icon" sizes="16x16">
    <link rel="shortcut icon" href="{{ asset('images/favicon_2.png') }}" type="image/x-icon" sizes="32x32">
    <link rel="shortcut icon" href="{{ asset('images/favicon_3.png') }}" type="image/x-icon" sizes="96x96">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500|Roboto:400,500,700&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @yield('styles')

</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm px-0">
        <div class="container-lg">
            <a class="navbar-brand" href="{{ route('base.url') }}">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="img-fluid"
                    width="130">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                @auth
                <ul class="navbar-nav ml-auto">
                    <input type="text" class="form-control" placeholder="&#xF002; Search" name="search" id="search">
                </ul>
                @endauth


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto vue">
                    <!-- Authentication Links -->
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('explore.page') }}">{{ __('Explore') }}</a>
                    </li>
                    @else
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link {{(unreadMessages() > 0) ? 'has_notf' : ''}}"
                            href="{{ route('private.chat') }}"><i class="far fa-envelope"></i></a>
                    </li>
                    <li class="nav-item d-md-none d-block">
                        <a class="nav-link {{(unreadMessages() > 0) ? 'has_notf' : ''}}"
                            href="{{ route('private.chat') }}">Messages</a>
                    </li>

                    <notification :user="{{ Auth::user()->id }}" :unreads="{{ Auth::user()->unreadNotifications }}">
                    </notification>

                    <li class="nav-item d-md-none d-block">
                        <a class="nav-link collapsed dropdown-toggle {{ (Auth::user()->unreadNotifications->count() > 0) ? 'has_notf' : '' }}"
                            role="button" data-toggle="collapse" data-target="#notification-collapse"
                            aria-expanded="true" aria-controls="notification-collapse" href="#">Notification</a>
                        <div id="notification-collapse" class="collapse">
                            @forelse (Auth::user()->unreadNotifications as $notification)
                            {{-- @include('notifications.'.snake_case(class_basename($notification->type))) --}}
                            {{-- <a class="dropdown-item notification-item" href="#">
                                Emnei.
                            </a> --}}
                            <notification-item :unread="{{ $notification }}"></notification-item>
                            @empty
                            <a class="dropdown-item notification-item" href="#">
                                No unread notifications.
                            </a>
                            @endforelse
                        </div>
                    </li>

                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link" href="{{ route('base.url') }}"><i class="far fa-user"></i></i></a>
                    </li>
                    <li class="nav-item d-md-none d-block">
                        <a class="nav-link" href="{{ route('base.url') }}">View Account</a>
                    </li>
                    @can('manage-users')
                    <li class="nav-item d-none d-md-block">
                        <a class="nav-link" href="{{ route('admin.users.index') }}"><i
                                class="fas fa-user-shield"></i></a>
                    </li>
                    <li class="nav-item d-md-none d-block">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">Manage Users</a>
                    </li>
                    @endcan

                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content-fluid')
        <div class="container vue">
            {{-- @auth
            <toast-component :userid="{{ Auth::id() }}"></toast-component>
            @endauth --}}
            @yield('content')
        </div>
    </main>

    <footer class="footer shadow-sm">
        <div class="container-lg h-100">
            {{-- <span class="text-muted">Place sticky footer content here.</span> --}}
            <div class="row h-100 align-content-center justify-content-center">
                <div class="col-sm-8 col-12 text-sm-left text-center">
                    <div class="footer-links">
                        <ul>
                            <li><a href="{{ route('terms.use') }}">Terms of Use</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('about.us') }}">About us</a></li>
                            <li><a href="{{ route('blog.index') }}">Blog</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4 col-6 text-sm-right text-center d-none d-sm-block">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}"
                            class="img-fluid" width="130">
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.4.0/umd/popper.min.js"
        integrity="sha256-FT/LokHAO3u6YAZv6/EKb7f2e0wXY3Ff/9Ww5NzT+Bk=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        function markAsRead(count) {
            if (count !== '0') {
                $.get('/markasread');
            }
        }

    </script>
    <script>
        $("#search").keypress(function (e) {
            if (e.which == 13) {
                phrase = $("#search").val();
                window.location.href = "{{route('search')}}" + "?search_query=" + phrase;
            }
        });

    </script>
    <script>
        function preDe(e) {
            e.preventDefault();
        }

    </script>
    @include('sweetalert::alert')
    @yield('scripts')
</body>

</html>