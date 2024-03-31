@if ($comment->user != null)
<div class="comment" data-comment="{{ $comment->id }}">

    <div class="comment-body">
        <div class="row no-gutters">
            <div class="col-xl-1 col-lg-2 col-md-2">
                <a href="{{ route('user.show', $comment->user->slug) }}">
                    <img src="{{ route('image.account', ['filename' => $comment->user->user_image]) }}" alt=""
                        class="img-fluid comment-user-img">
                </a>
            </div>
            <div class="col-lg-3 col-md-10 user-col">
                <a href="{{ route('user.show', $comment->user->slug) }}"
                    class="comment-user custom">{{ $comment->user->name }}</a>
                <small class="d-block">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="col-lg-6 col-md-11 col-11">
                <p class="comment-text">{!! linkify($comment->body) !!}</p>
            </div>
            <div class="col-lg-1 col-md-1 col-1 position-relative" style="text-align: right;padding-right: 22px;">
                <div class="comment-like d-inline-block" data-toggle="tooltip" data-placement="top"
                    title="{{ $comment->likes()->where('like', 1)->count() . " Likes" }}">
                    @if ($comment->likes()->where('user_id', auth()->id())->first())
                    @if ($comment->likes()->where('user_id', auth()->id())->first()->like == 1)
                    <i class="comment-like-btn is-active"></i>
                    @else
                    <i class="comment-like-btn is-active"></i>
                    @endif
                    @else
                    <i class="comment-like-btn"></i>
                    @endif
                </div>
                @if ($comment->user->id == auth()->id() or auth()->id() == $content->user->id)
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn no-focus btn-sm" id="comment_button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="comment_button">
                        @if ($comment->user->id == auth()->id())
                        <a class="edit-comment no-focus dropdown-item" href="#">Edit</a>
                        @endif
                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="no-focus dropdown-item" type="submit">Delete</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>

</div>
@else
<div class="comment" data-comment="{{ $comment->id }}">

    <div class="comment-body">
        <div class="row no-gutters">
            <div class="col-1">
                <img src="{{ route('image.account', ['filename' => 'default.jpg']) }}" alt=""
                    class="img-fluid comment-user-img">
            </div>
            <div class="col pl-20">
                <a href="#" class="comment-user custom">User not found.</a>
                <small class="d-block">{{ $comment->created_at->diffForHumans() }}</small>
            </div>
            <div class="col-6">
                <p class="comment-text">{{ $comment->body }}</p>
            </div>
            <div class="col-1">

            </div>
        </div>

    </div>

</div>
@endif
