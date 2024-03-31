@extends('layouts.app')

@section('title')
Terms of Use
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/style.css') }}">
<style>
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

    .term_condition_area {
        background-color: #fafafa;
        padding: 0;
    }

    .section-title p,
    .contact_tile .tiles__content p,
    .term_modules .term p {
        font-weight: 300;
    }

    .contact_tile .tiles__icon {
        color: #8e8e8e;
    }

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

    .term__description {
        padding: 32px 30px 22px;
    }

</style>
@endsection
@section('content')
<!--================================
            START LOGIN AREA
    =================================-->
<section class="term_condition_area py-100">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="cardify term_modules shadow-sm">
                    @forelse ($terms as $term)
                    <div class="term">
                        <div class="term__title">
                            <h4>{{ $term->term_header }}</h4>
                        </div>
                        <div class="term__description">
                            {!! $term->trixRichText->first()->content !!}
                        </div>
                    </div>
                    <!-- end /.term -->
                    @empty
                    <div class="term">
                        <div class="term__title">
                            <h4>No Terms</h4>
                        </div>
                        <p>No Terms hasn't been added yet.</p>
                    </div>
                    <!-- end /.term -->
                    @endforelse
                </div>
                <!-- end /.term_modules -->
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
            END LOGIN AREA
    =================================-->
@endsection
