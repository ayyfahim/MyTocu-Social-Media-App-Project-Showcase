@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/style.css') }}">
<style>
    body {
        position: unset;
    }

    .gif {
        width: 350px;
        padding-right: 40px;
    }
</style>
@endsection
@section('content-fluid')
<!--================================
            START 404 AREA
    =================================-->
<section class="four_o_four_area section--padding2">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <img class="gif" src="{{ asset('images/404.gif') }}" alt="404 page">
                <div class="not_found">
                    <h3>Oops! Page Not Found</h3>
                    <img class="logo" src="{{ asset('images/logo.png') }}" alt="MyTocu" width="130">
                </div>
            </div>
        </div>
    </div>
</section>
<!--================================
            END 404 AREA
    =================================-->
@endsection
@section('scripts')
<script src="{{ asset('js/third-party/main.js') }}"></script>
@endsection
