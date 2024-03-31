<a class="dropdown-item notification-item clearfix"
    href="{{ route('post.show', $notification->data['post_update']['id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> updated
        {{ $notification->data['user']['gender'] == 'male' ? 'his' : 'her' }} post.</p>
    <span><img src="{{ route('image.post', $notification->data['post_update']['post_image']) }}" alt=""
            class="img-fluid"></span>
</a>
