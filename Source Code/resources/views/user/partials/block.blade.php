<div class="each_user">
    <div class="row">
        <div class="col image-col">
            <div class="user-image">
                <a href="{{ route('user.show', $user->slug) }}">
                    <img src="{{ route('image.account', ['filename' => $user->user_image]) }}" alt="{{ $user->name }}"
                        class="img-fluid">
                </a>
            </div>
        </div>
        <div class="col-9">
            <a class="custom m-0" href="{{ route('user.show', $user->slug) }}">
                <h5 class="user-name {{ $user->city ?? 'mb-2' }}">{{ $user->name }}</h5>
            </a>

            @if (!empty($user->city))
            <small class="d-block user-location">{{$user->city->name}}, {{$user->country->name}}</small>
            @endif

            @include('user.partials.friendships')


            @if (!empty($user->city))
            <small class="d-block">{{$user->city->name}}, {{$user->country->name}}</small>
            @endif

        </div>
    </div>
</div>
