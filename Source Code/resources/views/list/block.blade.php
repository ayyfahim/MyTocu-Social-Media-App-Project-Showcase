<div class="col-lg-4 col-md-6 col-sm-6 col-12">
    <article class="post-ac" data-list="{{ $list->id }}">
        @if ($list->posts->count() > 0)
        <div class="post-ac-image">
            <a href="{{ route('list.show', $list->slug) }}">
                <img class="img-fluid" src="{{ route('image.post', ['filename' => $list->posts->last()->post_image]) }}"
                    alt="" class="img-fluid">
            </a>
        </div>
        @endif

        <a href="{{ route('list.show', $list->slug) }}" class="custom">
            <h5 class="post-title">{{ str_limit($list->title, '30') }}</h5>
        </a>

        <div class="interactions">
            @if ($list->likes->where('user_id', Auth::id())->first())
            @if ($list->likes->where('user_id', Auth::id())->first()->like == 1)
            <div class="like list-like is-active"></div>
            @else
            <div class="like list-like is-active"></div>
            @endif
            @else
            <div class="like list-like"></div>
            @endif
        </div>

        <span class="like-amount">
            {{ $list->likes->where('like', 1)->count() . " Likes"}}
        </span>

        <div class="s-comment-section">

            <a class="total-cmnt" href="{{ route('list.show', $list->slug) }}">
                {{ 'View all' }} {{$list->comments->where('commentable_id', $list->id)->count()}}
                {{ str_plural('comment', $list->comments->where('commentable_id', $list->id)->count()) }}
            </a>

            <div class="all-comments">
                @forelse ($list->comments_limit as $comment)
                @if ($comment->user != null)
                <div class="comments">
                    <a href="{{ route('user.show', $comment->user->slug) }}"
                        class="comment-user">{{ $comment->user->name }}</a>
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

            @if ($list->user != null)
            <small>
                {{ $list->created_at->diffForHumans() }} | Posted by: <a
                    href="{{ route('user.show', $list->user->slug) }}">
                    {{$list->user->name}}
                </a>
            </small>
            @else
            <small>
                {{ $list->created_at->diffForHumans() }} | Posted by: <a href="#">
                    User not found.
                </a>
            </small>
            @endif


        </div>
</div>
