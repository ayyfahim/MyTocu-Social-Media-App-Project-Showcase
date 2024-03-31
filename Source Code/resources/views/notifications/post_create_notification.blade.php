<a class="dropdown-item notification-item clearfix"
    href="{{ route('list.show', $notification->data['post_create']['list_id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> created a post.</p>
    <span><img src="{{ route('image.post', $notification->data['post_create']['post_image']) }}" alt=""
            class="img-fluid"></span>
</a>
