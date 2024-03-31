@extends('layouts.app')

@section('title')
About Us
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/slick.css') }}">
<link rel="stylesheet" href="{{ asset('css/third-party/owl.carousel.css') }}">
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

    .contact_tile .tiles__icon,
    .content_block1 .content_area .content_area--title .highlight,
    .content_block2 .content_area .content_area--title .highlight,
    .content_block2 .content_area2 .content_area--title .highlight,
    .content_block2 .content_area2 .content_area2--title .highlight,
    .section-title h1 .highlighted,
    .btn.btn--white {
        color: #8e8e8e;
    }

    .single_team_member figure .social,
    .single_team_member figure .single_blog_content .share_tags .share .social_share,
    .single_blog_content .share_tags .share .single_team_member figure .social_share,
    .about_hero:before {
        background-image: -webkit-gradient(linear, right top, left top, from(#BFBCB6), to(#807D79));
    }

    .testimonial {
        border-color: #8e8e8e;
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

    .fa-instagram:hover {
        background-color: #D793C6;
        color: #fff;
    }

    /*.trix-field-text {*/
    /*    font-weight: 300;*/
    /*    font-size: 30px;*/
    /*    line-height: 50px;*/
    /*    color: #fff;*/
    /*}*/
    
    .trix-field-text {
        font-weight: 300;
        font-size: 28px;
        line-height: 42px;
        color: #fff;
        text-align: left;
    } 

</style>
@endsection
@section('content-fluid')
<!--================================
    START ABOUT HERO AREA
=================================-->
<section class="about_hero bgimage">
    <div class="bg_image_holder">
        <img src="{{ asset('images/about_us/banner').'/'.$about_us->image }}" alt="">
    </div>

    <div class="container content_above">
        <div class="row">
            <div class="col-md-12">
                <div class="about_hero_contents">
                    <h1>{{ $about_us->title }}</h1>
                    <div class="trix-field-text">
                        <div style="text-align: center;">
                            <strong>A social network site for anyone who simply wants to record and share the things they love with those who want to do the same.
                            </strong>
                        </div>
                        {!! $about_us->trixRichText->first()->content !!}
                    </div>
                </div>
                <!-- end /.about_hero_contents -->
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row-->
    </div>
    <!-- end /.container -->
</section>
<!--================================
    END ABOUT HERO AREA
=================================-->

@endsection
@section('scripts')
<script src="{{ asset('js/third-party/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/third-party/slick.min.js') }}"></script>
<script src="{{ asset('js/third-party/main.js') }}"></script>
<script>
    $('.testimonial-slider').slick({
        infinite: true,
        slidesToShow: 2,
        slidesToScroll: 1,
        prevArrow: '<span class="lnr lnr-chevron-left"></span>',
        nextArrow: '<span class="lnr lnr-chevron-right"></span>',
        responsive: [{
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true
            }
        }]
    });

    $('.partners').owlCarousel({
        items: 5,
        autoplay: true,
        responsive: {
            0: {
                items: 1
            },
            480: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 5
            }
        }
    });

</script>
@endsection
