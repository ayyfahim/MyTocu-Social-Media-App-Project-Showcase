@extends('layouts.app')

@section('title')
Verify Your Email
@endsection

@section('content')
<section id="verify-box" class="py-100">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <img src="{{ asset('images/email_verification.png') }}" alt="" class="img-fluid">
        </div>
        <div class="col-md-8">
            <div class="text-box">
                <p><b>You're one step away</b></p>
                <h1>Verify your email Address</h1>
                <p>To complete your profile and start taking social media ride with MyTocu, you'll need to verify your
                    email address. </p>
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link m-0 p-0 text-info">Click here to request another</button>.
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
