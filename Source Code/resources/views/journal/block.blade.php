@if ($journal->journal_image)
<div class="col-md-12 each-journal">
    <article class="journal-ac" data-journal="{{ $journal->id }}">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        {{ $journal->created_at->format('d M Y') }}
                    </div>
                    <a href="{{ route('journal.show', $journal->slug) }}">
                        <img src="{{ route('image.journal', ['filename' => $journal->journal_image]) }}" alt=""
                            class="card-img-top img-fluid">
                    </a>

                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">{{ $journal->description }}</p>
                        <div class="interactions">
                            @if ($journal->likes->where('user_id', Auth::id())->first())
                            @if ($journal->likes->where('user_id', Auth::id())->first()->like == 1)
                            <div class="like journal-like is-active"></div>
                            @else
                            <div class="like journal-like is-active"></div>
                            @endif
                            @else
                            <div class="like journal-like"></div>
                            @endif
                        </div>
                        <h6 class="like-amount card-subtitle text-muted">
                            {{ $journal->likes->where('like', 1)->count() . " Likes"}}
                        </h6>
                        <div class="s-comment-section">

                            <a href="{{ route('journal.show', $journal->slug) }}" class="total-cmnt">
                                {{ 'View all' }} {{$journal->comments->count()}}
                                {{ str_plural('comment', $journal->comments->count()) }}
                            </a>

                            <div class="all-comments">

                                @forelse ($journal->comments_limit as $comment)
                                <div class="comments">
                                    <a href="#" class="comment-user custom">{{ $comment->user->name }}</a>
                                    <span class="comment-body">{{ $comment->body }}</span>
                                </div>
                                @empty
                                <p>This journal has no comments</p>
                                @endforelse

                            </div>

                        </div>
                        <small>{{ $journal->created_at->diffForHumans() }} | Posted by: <a
                                href="{{ route('user.show', $journal->user->slug) }}">{{$journal->user->name}}</a></small>
                    </div>
                </div>
            </div>
        </div>
    </article>
    {{-- @if ($journal->user == $auth_user)
            <a href="{{ route('edit.journal', $journal->id) }}" class="btn btn-secondary">Edit journal</a>
    @endif--}}
</div>
@else
<div class="col-md-12 each-journal">
    <article class="journal-ac" data-journal="{{ $journal->id }}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text">{{ $journal->description }}</p>
                        <div class="interactions">
                            @if ($journal->likes->where('user_id', Auth::id())->first())
                            @if ($journal->likes->where('user_id', Auth::id())->first()->like == 1)
                            <div class="like journal-like is-active"></div>
                            @else
                            <div class="like journal-like is-active"></div>
                            @endif
                            @else
                            <div class="like journal-like"></div>
                            @endif
                        </div>
                        <h6 class="like-amount card-subtitle text-muted">
                            {{ $journal->likes->where('like', 1)->count() . " Likes"}}
                        </h6>
                        <div class="s-comment-section">

                            <a href="{{ route('journal.show', $journal->slug) }}" class="total-cmnt">
                                {{ 'View all' }} {{$journal->comments->count()}}
                                {{ str_plural('comment', $journal->comments->count()) }}
                            </a>

                            <div class="all-comments">

                                @forelse ($journal->comments_limit as $comment)
                                <div class="comments">
                                    <a href="#" class="comment-user custom">{{ $comment->user->name }}</a>
                                    <span class="comment-body">{{ $comment->body }}</span>
                                </div>
                                @empty
                                <p>This journal has no comments</p>
                                @endforelse

                            </div>

                        </div>
                        <small>{{ $journal->created_at->diffForHumans() }} | Posted by: <a
                                href="{{ $journal->user ? route('user.show', $journal->user->slug) : '' }}">{{$journal->user ? $journal->user->name : 'User not found'}}</a></small>
                    </div>
                </div>
            </div>
        </div>
    </article>
    {{-- @if ($journal->user == $auth_user)
            <a href="{{ route('edit.journal', $journal->id) }}" class="btn btn-secondary">Edit journal</a>
    @endif--}}
</div>
@endif
