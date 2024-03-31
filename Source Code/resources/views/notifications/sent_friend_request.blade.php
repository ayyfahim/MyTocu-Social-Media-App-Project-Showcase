@php
use App\User;
$user = User::find($notification->data['user']['id']);
@endphp
<a class="dropdown-item notification-item" href="{{ route('user.show', $notification->data['user']['id'] ) }}">
    <p class="d-inline-block m-0"> <b> {{ $notification->data['user']['name'] }} </b> Sent you a Friend Request.</p>
    <span><img src="{{ route('image.account', $user->user_image) }}" alt="" class="img-fluid"></span>
</a>
