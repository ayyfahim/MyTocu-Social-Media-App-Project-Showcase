@extends('layouts.app')

@section('title')
Contact Us
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/style.css') }}">
<style>
    .contact-area {
        background: #fafafa;
    }

    body {
        background-color: #fafafa;
        color: #262626;
        font-family: "Montserrat", "Roboto", sans-serif;
        font-size: 14px;
        line-height: 18px;
        letter-spacing: -0.4px;
        margin-bottom: 100px;
        position: unset;
    }

    .section-title p,
    .contact_tile .tiles__content p {
        font-weight: 300;
    }

    .contact_tile .tiles__icon {
        color: #8e8e8e;
    }

    /* .btn {
        background: #8e8e8e;
    } */

    .site-btn {
        border: 1px solid transparent;
        background-color: #3897f0;
        border-radius: 4px;
        color: #fff;
        position: relative;
        width: 100%;
        font-size: 13.5px;
        font-weight: 500;
    }

</style>
@endsection
@section('content')
<!--================================
        START AFFILIATE AREA
    =================================-->
<section class="contact-area py-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <!-- start col-md-12 -->
                    <div class="col-md-12">
                        <div class="section-title">
                            <h1>{{ $contact_us->header }}</h1>
                            <p>{{ $contact_us->header_description }}</p>
                        </div>
                    </div>
                    <!-- end /.col-md-12 -->
                </div>
                <!-- end /.row -->

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="contact_tile">
                            <span class="tiles__icon lnr lnr-map-marker"></span>
                            <h4 class="tiles__title">Office Address</h4>
                            <div class="tiles__content">
                                <p>{{ $contact_us->office_address }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->

                    <div class="col-lg-4 col-md-6">
                        <div class="contact_tile">
                            <span class="tiles__icon lnr lnr-phone"></span>
                            <h4 class="tiles__title">Phone Number</h4>
                            <div class="tiles__content">
                                <p>{!! $contact_us->phone_number !!}</p>
                            </div>
                        </div>
                        <!-- end /.contact_tile -->
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->

                    <div class="col-lg-4 col-md-6">
                        <div class="contact_tile">
                            <span class="tiles__icon lnr lnr-inbox"></span>
                            <h4 class="tiles__title">Phone Number</h4>
                            <div class="tiles__content">
                                <p>{!! $contact_us->email_address !!}</p>
                            </div>
                        </div>
                        <!-- end /.contact_tile -->
                    </div>
                    <!-- end /.col-lg-4 col-md-6 -->

                    <div class="col-md-12">
                        <div class="contact_form cardify">
                            <div class="contact_form__title">
                                <h3>Leave Your Messages</h3>
                            </div>

                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <div class="contact_form--wrapper">
                                        <form action="{{ route('contact_us.store') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" placeholder="Name" name="name"
                                                            value="{{ old('name') }}">
                                                    </div>
                                                </div>

                                                <div class=" col-md-6">
                                                    <div class="form-group">
                                                        <input type="email" placeholder="Email" name="email"
                                                            value="{{ old('email') }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <textarea cols="30" rows="10" placeholder="Yout text here"
                                                name="message">{{ old('message') }}</textarea>

                                            <div class="sub_btn">
                                                <button type="submit" class="btn site-btn btn-sm">Send
                                                    Request</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- end /.col-md-8 -->
                            </div>
                            <!-- end /.row -->
                        </div>
                        <!-- end /.contact_form -->
                    </div>
                    <!-- end /.col-md-12 -->
                </div>
                <!-- end /.row -->
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
        END BREADCRUMB AREA
    =================================-->
@endsection
