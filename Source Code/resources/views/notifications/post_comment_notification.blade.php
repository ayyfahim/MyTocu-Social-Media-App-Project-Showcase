<a class="dropdown-item notification-item"
    href="{{ route('post.show', $notification->data['comment']['commentable_id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> commented on your post:
        <strong>{{ $notification->data['comment']['commentable']['title'] }}</strong>. </p>
    <span><img src="{{ route('image.post', $notification->data['comment']['commentable']['post_image']) }}" alt=""
            class="img-fluid"></span>
</a>
