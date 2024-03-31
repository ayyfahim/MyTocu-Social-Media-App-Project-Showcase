<a class="dropdown-item notification-item"
    href="{{ route('view.profile', $notification->data['journal_update']['id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> updated
        {{ $notification->data['user']['gender'] == 'male' ? 'his' : 'her' }} Journal. </p>
    <span>
        @isset($notification->data['journal_update']['journal_image'])
        <img src="{{ route('image.journal', $notification->data['journal_update']['journal_image']) }}" alt=""
            class="img-fluid">
        @endisset
    </span>
</a>
