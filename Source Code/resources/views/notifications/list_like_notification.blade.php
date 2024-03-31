<a class="dropdown-item notification-item clearfix"
    href="{{ route('lists.show', $notification->data['list_like']['id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> liked your list.</p>
</a>
