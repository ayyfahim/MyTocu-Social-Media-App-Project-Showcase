<div class="col-xl-2 col-md-3 col-sm-4 col-4">
    @if ($user)
    <div class="user-img">
        <img src="{{ route('image.account', ['filename' => $user->user_image]) }}" alt="" class="img-fluid">
    </div>
    @else
    <div class="user-img">
        <img src="{{ route('image.account', ['filename' => 'default.jpg']) }}" alt="" class="img-fluid">
    </div>
    @endif
</div>

<div class="col-xl-9 col-md-9 col-sm-8 col-8">
    <span class="user-name h2">{{ $user->name }}</span>

    @auth

    @if ($user->id == auth()->id())
    <div class="user-btn">
        <a href="{{ route('user.edit', auth()->user()->slug) }}" class="btn btn-sm">Edit Account</a>
    </div>
    @endif

    @include('user.partials.friendships')

    @endauth

</div>

<div class="col-xl-9 offset-xl-2 col-md-9 offset-md-3 col-sm-12 ">
    @include('user.partials.tabs')
</div>
