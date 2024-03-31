<a class="dropdown-item notification-item" href="{{ route('user.show', $notification->data['user']['id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> Accepted your Friend Request. </p>
    <span><img src="{{ route('image.account', $notification->data['user']['user_image']) }}" alt=""
            class="img-fluid"></span>
</a>
