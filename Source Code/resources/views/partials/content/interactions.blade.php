@if ($content->user != null)
<div class="interactions">
    @if ($content->likes()->where('user_id', auth()->id())->first())
    @if ($content->likes()->where('user_id', auth()->id())->first()->like == 1)
    <div class="like is-active {{ Auth::id() == $content->user->id ? 'cu_like' : 'ru_like' }}"></div>
    @else
    <div class="like is-active {{ Auth::id() == $content->user->id ? 'cu_like' : 'ru_like' }}"></div>
    @endif
    @else
    <div class="like {{ Auth::id() == $content->user->id ? 'cu_like' : 'ru_like' }}"></div>
    @endif
    <div class="comment-icn">
        <i class="far fa-comment"></i>
    </div>
    <span class="like-amount">
        {{ $content->likes->where('like', 1)->count() . " likes"}}
    </span>
</div>
@else
<div class="interactions">
    @if ($content->likes()->where('user_id', auth()->id())->first())
    @if ($content->likes()->where('user_id', auth()->id())->first()->like == 1)
    <div class="like is-active ru_like"></div>
    @else
    <div class="like is-active ru_like"></div>
    @endif
    @else
    <div class="like ru_like"></div>
    @endif
    <div class="comment-icn">
        <i class="far fa-comment"></i>
    </div>
    <span class="like-amount">
        {{ $content->likes->where('like', 1)->count() . " likes"}}
    </span>
</div>
@endif
