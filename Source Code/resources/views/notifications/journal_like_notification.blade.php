<a class="dropdown-item notification-item" href="{{ route('journal.show', $notification->data['journal']['id'] ) }}">
    <p class="d-inline-block m-0"><b> {{ $notification->data['user']['name'] }} </b> liked your journal.</p>
    @if ($notification->data['journal']['journal_image'])
    @isset($notification->data['journal']['journal_image'])
    <span><img src="{{ route('image.journal', $notification->data['journal']['journal_image']) }}" alt=""
            class="img-fluid"></span>
    @endisset
    @endif

</a>
