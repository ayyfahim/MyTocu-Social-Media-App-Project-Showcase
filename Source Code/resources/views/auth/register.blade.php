@extends('layouts.app')

@section('title')
Register
@endsection

@section('content-fluid')

<div class="container-lg">
    <section id="register-page" class="py-100">
        <div class="row justify-content-center">
            <div class="col-md-6 d-none d-md-block">
                <div class="register-image">
                    <img class="img-fluid" src="{{ asset('images/register-page.jpg') }}" alt="background_image">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-center register-box">
                    <div class="card-body">
                        <img class="img-fluid site-logo" src="{{ asset('images/logo.png') }}" alt="website_logo">
                        <h5 class="my-15">Sign up to create lists of your favourite things, experience or hobbies and
                            share them with your friends.</h5>

                        <form class="custom" method="POST" action="{{ route('register') }}">
                            @csrf
                            @isset ($invite)
                            <input type="hidden" name="invited_friend" value="{{ $invite['user'] }}" readonly>
                            @endisset
                            <div class="form-group">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name">
                                <label for="name"><span>Enter your name</span></label>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                @if (isset($invite))
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $invite['email'] }}" required autocomplete="email" readonly>
                                @else
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email">
                                @endif

                                <label for="email"><span> Enter your email
                                        address</span></label>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password">
                                <label for="password"><span>Please enter
                                        your password</span></label>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" required autocomplete="new-password">
                                <label for="password-confirm"><span>Please re-enter
                                        your password</span></label>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group text-left">
                                <p class="label text-left">Gender</p>

                                <div class="custom-control custom-radio custom-control-inline">
                                    <input value="male" type="radio" id="male" name="gender"
                                        class="custom-control-input" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="male">Male</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input value="female" type="radio" id="female" name="gender"
                                        class="custom-control-input" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="female">Female</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input value="other" type="radio" id="other" name="gender"
                                        class="custom-control-input" {{ old('gender') == 'other' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="other">Other</label>
                                </div>
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <p class="label text-left">Select your Birthday</p>

                                <div class="multiple-select">
                                    <select name="birth_day" class="form-control" id="birth_day">
                                        <option>Day</option>
                                        @foreach (days() as $day)
                                        <option value="{{$day}}" {{ old('birth_day') == $day ? 'selected' : '' }}>
                                            {{$day}}</option>
                                        @endforeach
                                    </select>
                                    <select name="birth_month" class="form-control" id="birth_month">
                                        <option>Month</option>
                                        @foreach (months() as $number => $month)
                                        <option value="{{$number}}"
                                            {{ old('birth_month') == $number ? 'selected' : '' }}>{{$month}}</option>
                                        @endforeach
                                    </select>
                                    <select name="birth_year" class="form-control" id="birth_year">
                                        <option>Year</option>
                                        @foreach (years() as $year)
                                        <option value="{{$year}}" {{ old('birth_year') == $year ? 'selected' : '' }}>
                                            {{$year}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <p class="label text-left">Select where you live</p>

                                <div class="multiple-select" style="column-count: 2;">
                                    <select name="country" class="form-control dynamic" id="country"
                                        data-dependent="state">
                                        <option value="{{ $user->country->id ?? '' }}">
                                            {{ $user->country->name ?? 'Select Country' }}</option>
                                        @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">
                                            {{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <select name="state" class="form-control" id="state" data-dependent="city">
                                        <option value="{{ $user->state->id ?? '' }}">
                                            {{ $user->state->name ?? 'Select State' }}</option>
                                    </select>
                                </div>
                            </div>
                            <button class="btn site-btn w-100">Register Now</button>
                        </form>
                        <p>
                            By signing up, you agree to our Terms. Learn how we collect, use and share your data in our
                            <b>Data Policy</b> and how we use cookies and simillar technology in our <b>Cookies
                                Policy.</b>
                        </p>
                    </div>
                </div>
                <div class="card text-center my-15">
                    <div class="card-body">
                        Have an account? <a href="{{ url('/login') }}">Log In</a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="text-center py-5">
                    <h3>MyTocu is a simple but fun way to record and share your favourite
                        experiences with those you choose</h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card register-box h-100">
                    <h5>How does it work?</h5>
                    <p>Have you ever found yourself trying to list your favourite movies, books, music, TV shows,
                        concerts
                        or any other category of things you enjoy? Do you enjoy discussing and sharing this with your
                        friends
                        or people with similar interests?</p>
                    <p>Have you ever got into a discussion about this with
                        your friends or people with similar interests?
                        MyTocu is a place specifically designed to record
                        those things and share them with friends.</p>
                    <p>Create a list, add a description to each entry and
                        share. You can add to the list when you want and
                        view the lists of your friends.</p>
                    <p>MyTocu is a simple and fun way to get to know
                        people better and a great way to keep a record of the
                        experiences you have enjoyed.</p>
                    <br>
                    <h5>Our Goal is Simple…</h5>
                    <p>To create a platform that allows you to only focus on
                        the experience that have made you happy and share
                        them with the friends you choose.</p>
                </div>
            </div>
            <div class="col-md-6">
                <img src="{{ asset('images/register-page_2.jpg') }}" alt="" class="img-fluid">
            </div>
            <div class="col-md-6 mt-5 d-none d-md-block">
                <img src="{{ asset('images/register-page_3.jpg') }}" alt="" class="img-fluid">
            </div>
            <div class="col-md-6 mt-5 d-none d-md-block">
                <div class="card register-box h-100">
                    <h5>Why join MyTocu?</h5>
                    <ul class="mt-2">
                        <li>A free social network platform that allows
                            you to record the best things or experiences
                            you’ve enjoyed and share those with the
                            friends you choose.</li>
                        <li>Get to really know your friends better.
                            Interact with like-minded people. Cut out
                            the unnecessary noise and focus on the
                            reasons that make you happy to socialise
                            online</li>
                        <li>It’s simple to use.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 mt-5 d-block d-md-none">
                <div class="card register-box h-100">
                    <h5>Why join MyTocu?</h5>
                    <ul class="mt-2">
                        <li>A free social network platform that allows
                            you to record the best things or experiences
                            you’ve enjoyed and share those with the
                            friends you choose.</li>
                        <li>Get to really know your friends better.
                            Interact with like-minded people. Cut out
                            the unnecessary noise and focus on the
                            reasons that make you happy to socialise
                            online</li>
                        <li>It’s simple to use.</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 mt-5 d-block d-md-none">
                <img src="{{ asset('images/register-page_3.jpg') }}" alt="" class="img-fluid">
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')
<script>
    $('.dynamic').change(function () {
        if ($(this).val() != '') {
            var select = $(this).attr("id");
            var value = $(this).val();
            var dependent = $(this).data('dependent');
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ route('get.state') }}",
                method: "POST",
                data: {
                    select: select,
                    value: value,
                    _token: _token,
                    dependent: dependent
                },
                success: function (result) {
                    $('#' + dependent).html(result);
                }

            })
        }
    });

    $('#country').change(function () {
        $('#state').val('');
    });

</script>
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
    $('.form-control').each(function () {
        checkForInputLabel(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.form-control').on('change keyup', function () {
        checkForInputLabel(this);
    });

    // The lines below are executed on page load
    $('.form-control').each(function () {
        checkForInput(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.form-control').on('change keyup', function () {
        checkForInput(this);
    });

</script>

@endsection