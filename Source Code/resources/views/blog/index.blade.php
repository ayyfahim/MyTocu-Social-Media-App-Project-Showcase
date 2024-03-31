@extends('layouts.app')

@section('title')
Blogs
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/style.css') }}">
<style>
    body {
        position: unset;
    }

    .blog_area {
        background: #FAFAFA;
    }

    .blog--default .btn_text figure {
        display: none;
    }

    .blog--default .btn_text p:first-child {
        word-break: break-word;
    }
</style>
@endsection
@section('content-fluid')
<!--================================
            START LOGIN AREA
    =================================-->
<section class="blog_area section--padding2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @forelse ($blogs as $blog)
                <div class="single_blog blog--default">
                    <figure>
                        <a href="{{ route('blog.show', $blog->slug) }}">
                            <img src="{{ route('blog.image', $blog->image) }}" alt="Blog image">
                        </a>

                        <figcaption>
                            <div class="blog__content">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="blog__title">
                                    <h4>{{ $blog->title }}</h4>
                                </a>

                                <div class="blog__meta">
                                    <div class="author">
                                        <span class="lnr lnr-user"></span>
                                        <p>by
                                            <a
                                                href="{{ route('user.show', $blog->user->slug) }}">{{ $blog->user->name }}</a>
                                        </p>
                                    </div>
                                    <div class="date_time">
                                        <span class="lnr lnr-clock"></span>
                                        <p>{{ $blog->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="comment_view">
                                        <p class="comment">
                                            <span class="lnr lnr-bubble"></span>{{ $blog->comments->count() }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="btn_text">
                                {{-- <p>{{ str_limit(strip_tags($blog->trixRichText->first()->content), '446') }} --}}
                                {{-- <p>{!! $blog->trixRichText->first()->content !!}</p> --}}
                                <div>
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn--md btn--round">Read
                                        More</a>
                                </div>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!-- end /.single_blog -->
                @empty
                <div>
                    <p>No blogs to show.</p>
                </div>
                @endforelse
                <div>
                    {{ $blogs->links() }}
                </div>
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
@section('scripts')
<script src="{{ asset('js/third-party/main.js') }}"></script>
@endsection
