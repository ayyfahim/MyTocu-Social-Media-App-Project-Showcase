@extends('layouts.app')

@section('content')
<section id="verify-box">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/email_verification.png') }}" alt="" class="img-fluid">
        </div>
        <div class="col-md-8">
            <div class="text-box">
                <p><b>You're one step away</b></p>
                <h1>Enable your account</h1>
                <p>Please confirm you would like to reactivate your account.</p>
                <form class="d-inline" method="POST" action="{{ route('activate.account') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $user['email'] }}">
                    <button type="submit" class="btn btn-success m-0 ">Click here to re-activate your
                        account</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
