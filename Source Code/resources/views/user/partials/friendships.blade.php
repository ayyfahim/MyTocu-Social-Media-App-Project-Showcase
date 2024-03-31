@if (Auth::id() != $user->id)
@if (Auth::user()->isFriendWith($user))
<form id="friendship" action="{{ route('friendship') }}" method="POST" class="d-inline-block">
    @csrf
    <input type="hidden" name="user" value="{{ $user->slug }}">
    <button type="submit" class="btn frd_btn btn-danger btn-sm">Remove Friend</button>
</form>
<a class="btn frd_btn btn-info btn-sm" href="{{ route('private.chat', $user->slug)}}">Send Message</a>
@elseif (Auth::user()->hasSentFriendRequestTo($user))
<form id="friendship" action="{{ route('friendship') }}" method="POST">
    @csrf
    <input type="hidden" name="user" value="{{ $user->slug }}">
    <button type="submit" class="btn frd_btn btn-warning btn-sm">Cancel Request</button>
</form>
@elseif (Auth::user()->hasFriendRequestFrom($user))
<form id="friendship" action="{{ route('friendship') }}" method="POST" class="d-inline-block">
    @csrf
    <input type="hidden" name="user" value="{{ $user->slug }}">
    <button data-action="accept" type="submit" id="accept_request" class="btn frd_btn btn-info btn-sm">Accept
        Request</button>
    <button data-action="cancel" type="submit" id="cancel_request" class="btn frd_btn btn-warning btn-sm">Cancel
        Request</button>
</form>
@else
<form id="friendship" action="{{ route('friendship') }}" method="POST">
    @csrf
    <input type="hidden" name="user" value="{{ $user->slug }}">
    <button type="submit" class="btn frd_btn btn-success btn-sm">Send Request</button>
</form>
@endif
@endif