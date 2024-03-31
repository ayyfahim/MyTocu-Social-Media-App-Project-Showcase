<a class="dropdown-item notification-item"
    href="{{ route('lists.show', $notification->data['comment']['commentable_id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> commented on your list:
        <strong>{{ $notification->data['comment']['commentable']['title'] }}</strong>. </p>
</a>
