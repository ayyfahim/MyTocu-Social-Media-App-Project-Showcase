<div class="col-lg-3 col-md-3 col-6">
    <div class="content-user row align-items-center">
        <div class="content-user-image col-md-4 col-sm-3 col-4">
            <a href="{{ route('user.show', $list->userWithTrashed->slug) }}">
                <img src="{{ route('image.account', ['filename' => $list->userWithTrashed->user_image]) }}" alt=""
                    class="img-fluid">
            </a>
        </div>
        <div class="user-info col-md col">
            <a href="{{ route('user.show', $list->userWithTrashed->slug) }}" class="content-user-name custom">
                {{$list->userWithTrashed->name}}
            </a>

            {{-- User Country --}}
            @if (!empty($list->userWithTrashed->country))
            <small class="d-block">{{$list->userWithTrashed->state->name}},
                {{$list->userWithTrashed->country->name}}</small>
            @else
            <small class="d-block">No location selected.</small>
            @endif

            {{-- Edit button for list user --}}
            @if (auth()->id() == $list->userWithTrashed->id)
            <a role="button" data-toggle="collapse" data-target="#list-collapse" aria-expanded="true"
                aria-controls="list-collapse" href="#" class="d-block" style="color: #8e8e8e;">Edit List</a>
            <div id="list-collapse" class="collapse" style="padding: 10px;">
                <a class="text-success d-block" href="{{ route('list.edit', $list->slug) }}">Add to List</a>
                <a class="text-danger d-block" href="{{ route('list.destroy', $list->slug) }}">Delete the List</a>
            </div>
            @endif

        </div>
    </div>
</div>
<div class="col-lg-3 col-md-3 col-6">
    <div class="interactions list" class="pb-0">
        @if ($list->likes()->where('user_id', auth()->id())->first())
        @if ($list->likes()->where('user_id', auth()->id())->first()->like == 1)
        <div class="like is-active list-like"></div>
        @else
        <div class="like is-active list-like"></div>
        @endif
        @else
        <div class="like list-like"></div>
        @endif
        <div class="comment-icn">
            <i class="far fa-comment"></i>
        </div>
        <span class="like-amount">
            {{ $list->likes->where('like', 1)->count() . " likes"}}
        </span>
    </div>
</div>
<div class="col-lg-10">
    <h4 class="list_title">{{$list->title}}</h4>
</div>
