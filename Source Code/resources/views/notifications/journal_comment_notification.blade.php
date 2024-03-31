<a class="dropdown-item notification-item"
    href="{{ route('journal.show', $notification->data['comment']['commentable_id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> commented on your journal. </p>
    @isset($notification->data['journal']['journal_image'])
    <span><img src="{{ route('image.post', $notification->data['journal']['journal_image']) }}" alt=""
            class="img-fluid"></span>
    @endisset
</a>
