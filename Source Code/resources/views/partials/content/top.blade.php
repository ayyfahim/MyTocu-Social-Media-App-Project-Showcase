@if ($content->user != null)
<div class="content-user row align-items-center">
    <div class="content-user-image col-md-3 col-2">
        <a href="{{ route('user.show', $content->user->slug) }}">
            <img src="{{ route('image.account', ['filename' => $content->user->user_image]) }}" alt=""
                class="img-fluid">
        </a>
    </div>
    <div class="user-info col-md col-6">
        <a href="{{ route('user.show', $content->user->slug) }}" class="content-user-name custom">
            {{$content->user->name}}
        </a>
        @if (!empty($user->country))
        <small class="d-block">{{$content->user->state->name}}, {{$content->user->country->name}}</small>
        @else
        <small class="d-block">No location selected.</small>
        @endif
    </div>
</div>
@else
<div class="content-user row align-items-center">
    <div class="content-user-image col-3">
        <a href="#">
            <img src="{{ route('image.account', ['filename' => 'default.jpg']) }}" alt="" class="img-fluid">
        </a>
    </div>
    <div class="user-info col">
        <a href="#" class="content-user-name custom">
            User Not Found
        </a>
    </div>
</div>
@endif
