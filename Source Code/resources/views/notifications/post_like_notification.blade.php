<a class="dropdown-item notification-item clearfix" href="{{ route('post.show', $notification->data['post']['id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> liked your post.</p>
    <span><img src="{{ route('image.post', $notification->data['post']['post_image']) }}" alt=""
            class="img-fluid"></span>
</a>
