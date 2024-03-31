<div class="user-tabs">
    <ul class="list-group" role="tablist">

        @auth

        @if ($user->status != 1 || auth()->id() == $user->id || auth()->user()->isFriendWith($user))

        <li>
            <a href="{{ route('user.lists') }}" data-target="#lists" class="list-group-item list-group-item-action"
                data-toggle="tab" role="tab">
                <i class="fas fa-th"></i>Lists
            </a>
        </li>
        <li>
            <a href="{{ route('user.journals') }}" data-target="#journals"
                class="list-group-item list-group-item-action" data-toggle="tab" role="tab">
                <i class="fas fa-book"></i> Journal
            </a>
        </li>

        @endif

        @if (auth()->id() == $user->id)
        <li>
            <a href="{{ route('user.friends') }}" data-target="#friends" class="list-group-item list-group-item-action"
                data-toggle="tab" role="tab">
                <i class="fas fa-user-friends"></i> Friends
            </a>
        </li>
        <li>
            <a href="{{ route('user.explore') }}" data-target="#explore" class="list-group-item list-group-item-action"
                data-toggle="tab" role="tab">
                <i class="fab fa-wpexplorer"></i> Explore
            </a>
        </li>
        @endif

        @else

        @if ($user->status != 1)

        <li>
            <a href="{{ route('user.lists') }}" data-target="#lists" class="list-group-item list-group-item-action"
                data-toggle="tab" role="tab">
                <i class="fas fa-th"></i>Lists
            </a>
        </li>
        <li>
            <a href="{{ route('user.journals') }}" data-target="#journals"
                class="list-group-item list-group-item-action" data-toggle="tab" role="tab">
                <i class="fas fa-book"></i> Journal
            </a>
        </li>

        @endif

        @endauth

    </ul>
</div>
