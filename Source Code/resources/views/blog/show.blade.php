@extends('layouts.app')

@section('title')
{{ $blog->title }}
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<link rel="stylesheet" href="{{ asset('css/third-party/style.css') }}">
<style>
    .single_blog_content img {
        max-width: 100%;
        height: auto;
    }

    .comment_area .comment___wrapper .media-list .heading_left span {
        font-weight: 300;
        font-size: 13px;
    }

    .comment_area .comment___wrapper .media-list .heading_left a h4 {
        font-size: 18px;
        color: #000;
    }
</style>
@endsection
@section('content-fluid')
<!--================================
            START LOGIN AREA
    =================================-->
<section class="blog_area section--padding2" style="padding: 70px 0 170px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="single_blog blog--default">
                    <article>
                        <figure>
                            <img src="{{ route('blog.image', $blog->image) }}" alt="Blog image">
                        </figure>
                        <div class="blog__content">
                            <a href="#" class="blog__title">
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
                                    <p>24 Feb 2019</p>
                                </div>
                                <div class="comment_view">
                                    <p class="comment">
                                        <span class="lnr lnr-bubble"></span>{{ $blog->comments->count() }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="single_blog_content">
                            {!! $blog->trixRichText->first()->content !!}
                        </div>
                    </article>
                </div>
                <!-- end /.single_blog -->

                <div class="comment_area">
                    <div class="comment__title">
                        <h4>{{ $blog->comments->count().' comments' }}</h4>
                    </div>

                    @foreach ($blog->comments as $comment)
                    <div class="comment___wrapper">
                        <ul class="media-list">
                            <li class="depth-1">
                                <div class="media">
                                    <div class="pull-left no-pull-xs">
                                        <a href="{{ route('user.show', $comment->user->slug) }}" class="cmnt_avatar">
                                            <img width="122"
                                                src="{{ route('image.account', $comment->user->user_image)  }}"
                                                class="media-object" alt="{{ $comment->user->name }}">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <div class="media_top">
                                            <div class="heading_left pull-left">
                                                <a href="#">
                                                    <h4 class="media-heading">{{ $comment->user->name }}</h4>
                                                </a>
                                                <span>{{ $comment->created_at->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                        <p>{{ $comment->body }}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- end /.comment___wrapper -->
                    @endforeach

                </div>
                <!-- end /.col-md-8 -->

                @auth
                <div class="comment_area comment--form">
                    <!-- start reply_form -->
                    <div class="comment__title">
                        <h4>Leave A Reply</h4>
                    </div>
                    <div class="commnet_form_wrapper">
                        <!-- start form -->
                        <form class="cmnt_reply_form" action="{{ route('comments.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea class="input_field" name="body" placeholder="Your text here..."
                                            rows="10" cols="80"></textarea>
                                    </div>

                                    <button type="submit" class="btn btn--round btn--default"
                                        name="btn">Comment</button>
                                </div>
                            </div>
                        </form>
                        <!-- end form -->
                    </div>
                    <!-- end /.commnet_form_wrapper -->
                </div>
                <!-- end /.comment_area_wrapper -->
                @endauth
            </div>
            <!-- end /.col-md-8 -->

            <div class="col-lg-4">
                @can('manage-blogs')
                <aside class="sidebar sidebar--blog">

                    <div class="sidebar-card card--blog_sidebar card--tags">
                        <div class="card-title">
                            <h4>Actions</h4>
                        </div>
                        <div class="p-3 text-center">
                            <a class="btn btn-sm" href="{{ route('blog.edit', $blog->slug) }}">Edit</a>
                            <form action="{{ route('blog.destroy', $blog->slug) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                    <!-- end /.sidebar-card -->
                </aside>
                <!-- end /.aside -->
                @endcan
            </div>
            <!-- end /.col-md-4 -->

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
