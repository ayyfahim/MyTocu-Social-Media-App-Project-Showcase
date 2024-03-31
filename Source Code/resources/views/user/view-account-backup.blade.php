@php
    use Illuminate\Support\Facades\Storage;
    use App\Comment;
@endphp
@extends('layouts.app')

@section('content')

    <section id="user" class="section">
        <div class="row upper-part">

            <div class="col-md-3">
                <div class="user-img">
                    <img src="{{ route('image.account', ['filename' => $user->user_image]) }}" alt="" class="img-responsive">
                </div>
            </div>

            <div class="col-md-9">

                <div class="user-info">
                    <h3 class="user-name">{{ $user->name }}</h3>

                    <div class="user-btn">
                        <a href="{{ route('edit.account') }}" class="btn btn-info">Edit Account</a>
                        <button class="emenei"><i class="fas fa-cogs"></i></button>
                    </div>

                </div>

                <div class="user-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a  href="#posts" data-toggle="tab">Posts</a>
                        </li>
                        <li>
                            <a href="#journals" data-toggle="tab">Journals</a>
                        </li>
                        <li>
                            <a href="#friends" data-toggle="tab">Friends</a>
                        </li>
                        <li>
                            <a href="#explore" data-toggle="tab">Explore</a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
        <div class="lower-part">
            <div class="tab-content ">
                <div class="tab-pane active" id="posts">
                    <div class="row">
                        @foreach ($posts->where('user_id', $user->id) as $post)
                            <div class="col-md-4">
                                <article class="post-ac" data-postid="{{ $post->id }}">
                                    <div class="post-ac-image">
                                        <a href="{{ route('show.post', $post->id) }}">
                                            <img class="img-responsive" src="{{ route('image.post', ['filename' => $post->post_image]) }}" alt="" class="img-responsive">
                                        </a>
                                    </div>

                                        <h4 class="post-title">{{ $post->title }}</h4>

                                    <div class="interactions">
                                        @if ($user->likes()->where('post_id', $post->id)->first())
                                            @if ($user->likes()->where('post_id', $post->id)->first()->like == 1)
                                                <a href="" class="like active"><i class="fas fa-heart"></i></a>
                                            @else
                                                <a href="" class="like"><i class="far fa-heart"></i></a>
                                            @endif
                                        @else
                                            <a href="" class="like"><i class="far fa-heart"></i></a>
                                        @endif
                                    </div>
                                    <span class="like-amount">
                                        {{ $post->likes->where('like', 1)->count() . " Likes"}}
                                    </span>

                                    <div class="s-comment-section">

                                    <a data-toggle="modal" data-target="#postModal{{ $post->id }}"> 
                                        {{ 'View all' }} {{$comments_all->where('post_id', $post->id)->count()}} {{ str_plural('comment', $comments_all->where('post_id', $post->id)->count()) }}
                                    </a>

                                    <div class="all-comments">

                                        @php
                                            $comments_1 = Comment::limit(1)->where('post_id', $post->id)->latest()->get();
                                        @endphp

                                        @forelse ($comments_1 as $comment)
                                        <div class="comments">
                                            <a href="#" class="comment-user">{{ $comment->user->name }}{{-- {{$comment->created_at}} --}} </a> 
                                            <span class="comment-body">{{ $comment->body }}</span>
                                        </div>
                                        @empty
                                        <p>This post has no comments</p>
                                        @endforelse

                                    </div>

                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                <div class="post-user-image">    
                                                    <img src="{{ route('image.account', ['filename' => $post->user->user_image]) }}" alt="" class="img-responsive">
                                                </div>
                                                <div class="user-info">
                                                    <a href="#" class="user-name">{{ $post->user->name }}</a>
                                                </div>
                                            </div>
                                            <div class="modal-body">

                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <h4 class="post-title">{{ $post->title }}</h4>
                                                    </div>

                                                    <div class="col-md-6">

                                                        <article data-postid="{{ $post->id }}">
                                                
                                                            <div class="post-image">
                                                                <img class="img-responsive" src="{{ route('image.post', ['filename' => $post->post_image]) }}" alt="" class="img-responsive">
                                                            </div>

                                                            <p class="post-description">{{ $post->description }}</p>

                                                            <div class="interactions">
                                                                @if ($user->likes()->where('post_id', $post->id)->first())
                                                                    @if ($user->likes()->where('post_id', $post->id)->first()->like == 1)
                                                                        <a href="" class="like active"><i class="fas fa-heart"></i></a>
                                                                    @else
                                                                        <a href="" class="like"><i class="far fa-heart"></i></a>
                                                                    @endif
                                                                @else
                                                                    <a href="" class="like"><i class="far fa-heart"></i></a>
                                                                @endif
                                                            </div>
                                                            <span class="like-amount">
                                                                {{ $post->likes->where('like', 1)->count() . " Likes"}}
                                                            </span>
                                                        </article>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="all-comments">

                                                            @forelse ($comments_all->where('post_id', $post->id) as $comment)
                                                        <div class="comments" data-comment="{{ $comment->id }}">

                                                                    <a href="#" class="comment-user">{{ $comment->user->name }}{{-- {{$comment->created_at}} --}} </a> 
                                                                    <span class="comment-body">{{ $comment->body }}</span>

                                                                    @if ($comment->user == $user)
                                                                        <a class="edit-comment" href="#">Edit</a>
                                                                        <!-- Modal -->
                                                                        <div class="modal comment-modal{{ $comment->id  }}" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                ...
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                            </div>
                                                                        </div>
                                                                        </div>
                                                                    @endif
                                                                
                                                                </div>
                                                            @empty
                                                            <p>This post has no comments</p>
                                                            @endforelse
                                                            

                                                            @if (Auth::check())

                                                                <form action="{{ route('comments.store') }}" method="post">
                                                                    {{ csrf_field() }}
                                                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                                    <div class="form-group">
                                                                    <textarea class="form-control" name="body"></textarea>
                                                                    </div>
                                                                    <div class="form-group">
                                                                    <button class="form-control" type="submit" class="btn btn-default">Submit</button>
                                                                    </div>
                                                                </form>
                                                                
                                                            @endif

                                                        </div>

                                                    </div>

                                                </div>

                                                

                                            </div>
                                            </div>
                                        </div>
                                    </div> 
                                    @if ($post->user == $user)
                                        <a href="{{ route('edit.post', $post->id) }}">Edit Post</a>
                                    @endif
                                </article>
                            </div>
                        @endforeach
                    </div>
                    {{ $posts->links() }}
                </div>
                <div class="tab-pane" id="journals">
                    <h3>Notice the gap between the content and tab after applying a background color</h3>
                </div>
                <div class="tab-pane" id="friends">
                    <h3>add clearfix to tab-content (see the css)</h3>
                </div>
                <div class="tab-pane" id="explore">
                    <h3>add clearfix to tab-content (see the css)</h3>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script src="/js/post.js"></script>
    <script>
        var urlLike = '{{ route('like') }}';
        var token = '{{ Session::token() }}';
    </script>
@endsection
