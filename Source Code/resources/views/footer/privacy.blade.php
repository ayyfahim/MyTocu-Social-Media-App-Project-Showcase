@extends('layouts.app')

@section('title')
Privacy Policy
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
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

    .faq_area {
        background: #fafafa;
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
    
    ol li {
        list-style-type: decimal;
        margin-bottom: 15px;
    }

</style>
@endsection
@section('content')
<!--================================
            START FAQ AREA
    =================================-->
<section class="faq_area section--padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cardify faq_module shadow-sm">
                    <div class="faq-title">
                        <span class="lnr lnr-file-add"></span>
                        <h4>Privacy Policies</h4>
                    </div>

                    <div class="faqs">
                        @forelse ($policies as $policy)
                        @if ($loop->first)
                            <div class="panel-group accordion" role="tablist" id="accordion">
                            <div class="panel accordion__single" id="panel-one">
                                <div class="single_acco_title">
                                    <h4>
                                        <a data-toggle="collapse" href="#collapse1" class="active"
                                            aria-expanded="true" data-target="#collapse{{ $loop->iteration }}"
                                            aria-controls="collapse1">
                                            <span>{{ $policy->policy_header }}</span>
                                            <i class="lnr lnr-chevron-down indicator"></i>
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapse{{ $loop->iteration }}" class="panel-collapse collapse show"
                                    aria-labelledby="panel-one" data-parent="#accordion">
                                    <div class="panel-body p-4">
                                        {!! $policy->trixRichText->first()->content !!}
                                    </div>
                                </div>
                            </div>
                            <!-- end /.accordion__single -->
                        </div>
                        @continue
                        @endif
                        <div class="panel-group accordion" role="tablist" id="accordion">
                            <div class="panel accordion__single" id="panel-one">
                                <div class="single_acco_title">
                                    <h4>
                                        <a data-toggle="collapse" href="#collapse1" class="collapsed"
                                            aria-expanded="false" data-target="#collapse{{ $loop->iteration }}"
                                            aria-controls="collapse1">
                                            <span>{{ $policy->policy_header }}</span>
                                            <i class="lnr lnr-chevron-down indicator"></i>
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapse{{ $loop->iteration }}" class="panel-collapse collapse"
                                    aria-labelledby="panel-one" data-parent="#accordion">
                                    <div class="panel-body p-4">
                                        {!! $policy->trixRichText->first()->content !!}
                                    </div>
                                </div>
                            </div>
                            <!-- end /.accordion__single -->
                        </div>
                        <!-- end /.accordion -->
                        @empty
                        <div class="panel-group accordion" role="tablist" id="accordion">
                            <div class="panel accordion__single" id="panel-one">
                                <div class="single_acco_title">
                                    <h4>
                                        <a data-toggle="collapse" href="#collapse1" class="collapsed"
                                            aria-expanded="false" data-target="#collapse1" aria-controls="collapse1">
                                            <span>No Policy</span>
                                            <i class="lnr lnr-chevron-down indicator"></i>
                                        </a>
                                    </h4>
                                </div>

                                <div id="collapse1" class="panel-collapse collapse" aria-labelledby="panel-one"
                                    data-parent="#accordion">
                                    <div class="panel-body">
                                        <p>No policies added.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end /.accordion__single -->
                        </div>
                        <!-- end /.accordion -->
                        @endforelse
                        <span style="
                            text-align: right;
                            display: block;
                            margin-top: 25px;
                        ">Last updated {{ $policies->last()->updated_at->format('d M Y') }}</span>
                    </div>
                </div>
                <!-- end /.cardify -->
            </div>
            <!-- end /.col-md-12 -->
        </div>
        <!-- end /.row -->
    </div>
    <!-- end /.container -->
</section>
<!--================================
            END FAQ AREA
    =================================-->
@endsection
@section('scripts')
<script src="{{ asset('js/third-party/main.js') }}"></script>
@endsection
