<div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <article class="post-ac" data-post="{{ $post->id }}">
        <div class="post-ac-image">
            <a href="{{ route('list.show', $post->list->slug) }}">
                <img class="img-fluid" src="{{ route('image.post', ['filename' => $post->post_image]) }}" alt=""
                    class="img-fluid">
            </a>
        </div>

        <h5 class="post-title">{{ str_limit($post->title, '30') }}</h5>

        <div class="interactions">
            @if ($post->likes()->where('user_id', Auth::id())->first())
            @if ($post->likes()->where('user_id', Auth::id())->first()->like == 1)
            <div class="like post-like is-active"></div>
            @else
            <div class="like post-like is-active"></div>
            @endif
            @else
            <div class="like post-like"></div>
            @endif
        </div>

        <span class="like-amount">
            {{ $post->likes->where('like', 1)->count() . " Likes"}}
        </span>

        <div class="s-comment-section">

            <a class="total-cmnt" href="{{ route('list.show', $post->list->slug) }}">
                {{ 'View all' }} {{$post->comments->where('commentable_id', $post->id)->count()}}
                {{ str_plural('comment', $post->comments->where('commentable_id', $post->id)->count()) }}
            </a>

            <div class="all-comments">

                @php
                $comments_1 = $post->comments_limit(1)->get();
                @endphp

                @forelse ($comments_1 as $comment)
                @if ($comment->user != null)
                <div class="comments">
                    <a href="#" class="comment-user">{{ $comment->user->name }}</a>
                    <span class="comment-body">{{ str_limit($comment->body, '35') }}</span>
                </div>
                @else
                <div class="comments">
                    <a href="#" class="comment-user custom">User not found.</a>
                    <span class="comment-body">{{ $comment->body }}</span>
                </div>
                @endif

                @empty
                <p>This post has no comments</p>
                @endforelse

            </div>

            @if ($post->user != null)
            <small>
                {{ $post->created_at->diffForHumans() }} | Posted by: <a
                    href="{{ route('user.show', $post->user->slug) }}">
                    {{$post->user->name}}
                </a>
            </small>
            @else
            <small>
                {{ $post->created_at->diffForHumans() }} | Posted by: <a href="#">
                    User not found.
                </a>
            </small>
            @endif


        </div>
</div>
