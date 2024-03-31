@extends('layouts.app')

@section('title')
    Login
@endsection

@section('content')
    <section id="login-page" class="py-100">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card login-box text-center">
                    <div class="card-body">
                        <img class="img-fluid site-logo my-15" src="{{ asset('images/logo.png') }}" alt="website_logo">
                        <form method="POST" action="{{ route('login') }}" class="custom">
                            @csrf
                            <div class="form-group">

                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="email"><span>Email</span></label>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="password"><span>Password</span></label>
                            </div>
                            <button class="btn site-btn" type="submit">Log in</button>
                            <button id="admin_login" class="btn site-btn mt-2 bg-success" type="submit">Log in as Admin
                                User</button>
                            <button id="normal_user_login" class="btn site-btn mt-2 bg-info" type="submit">Log in as Normal
                                User</button>
                        </form>
                        <a href="{{ route('password.request') }}" class="mt-2 text-left d-block">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

<div class="card-body">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
                <button type="submit" class="btn btn-primary">
                    {{ __('Login') }}
                </button>

                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div>
        </div>
    </form>
</div>
</div>
</div>
</div>
</div> --}}
@endsection


@section('scripts')
    <script>
        function checkForInput(element) {
            // element is passed to the function ^

            const $label = $(element);

            if ($(element).val().length > 0) {
                $label.addClass('input-has-value');
            } else {
                $label.removeClass('input-has-value');
            }
        }

        function checkForInputLabel(element) {
            // element is passed to the function ^

            const $label = $(element).siblings('label');

            if ($(element).val().length > 0) {
                $label.addClass('input-has-value');
            } else {
                $label.removeClass('input-has-value');
            }
        }

        // The lines below are executed on page load
        $('.form-control').each(function() {
            checkForInputLabel(this);
        });

        // The lines below (inside) are executed on change & keyup
        $('.form-control').on('change keyup', function() {
            checkForInputLabel(this);
        });

        // The lines below are executed on page load
        $('.form-control').each(function() {
            checkForInput(this);
        });

        // The lines below (inside) are executed on change & keyup
        $('.form-control').on('change keyup', function() {
            checkForInput(this);
        });

        // Login To Website

        $("#admin_login").click(function() {
            $('#email').val("contact@mytocu.com");
            $('#password').val("Ombudsman18");
            $('#login-page form').submit();
        });

        $("#normal_user_login").click(function() {
            $('#email').val("user@mytocu.com");
            $('#password').val("password");
            $('#login-page form').submit();
        });

    </script>

@endsection
