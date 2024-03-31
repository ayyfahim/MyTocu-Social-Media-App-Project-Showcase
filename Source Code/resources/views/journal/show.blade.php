@extends('layouts.app')

@section('title')
Journal
@endsection

@section('content')

<section class="py-100">
    <div class="row">
        <div class="col-md-3">
            @include('partials.content.top', [
            'content' => $journal,
            'user' => Auth::user()
            ])
        </div>
    </div>

    <div class="row py-3" id="single-content">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Journal</h5>
                </div>
                @if ($journal->journal_image)
                <div class="post-image">
                    <img class="img-fluid card-img"
                        src="{{ route('image.journal', ['filename' => $journal->journal_image]) }}" alt=""
                        class="img-fluid">
                </div>
                @endif
                <div class="card-body" data-journal="{{ $journal->id }}">
                    <p class="content-description card-text">{{ $journal->description }}</p>
                    @include('partials.content.interactions', [
                    'content' => $journal
                    ])
                    @if ($journal->user)
                    @if (auth()->id() == $journal->user->id)
                    <div class="dropdown" id="content-dropdown">
                        <button type="button" class="btn no-focus btn-sm" id="post_button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="post_button">

                            <a href="{{ route('journal.edit', $journal->slug) }}"
                                class="edit-post no-focus btn dropdown-item">Edit Journal</a>

                            <form action="{{ route('journal.destroy', $journal->slug) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-post no-focus btn dropdown-item">Delete
                                    Journal</button>
                            </form>
                        </div>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="all-comments">
                <div class="card">
                    <div class="card-header">
                        <h6 class="m-0">
                            Comments
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse ($comments as $comment)
                        @include('partials.content.comment', [
                        'content' => $journal
                        ])
                        @empty
                        <p class="m-0">This Journal has no comments</p>
                        @endforelse
                    </div>
                    <div class="post-comment">
                        @if (Auth::check())

                        <form action="{{ route('comments.store') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="journal_id" value="{{ $journal->id }}">
                            <div class="form-group m-0">
                                <textarea class="form-control comment-area no-focus" name="body"
                                    placeholder="Write a comment..."></textarea>
                                <button class="submit_comment no-focus btn f-roboto" type="submit">Submit</button>
                            </div>
                        </form>

                        @endif
                    </div>
                </div>



            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade comment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <textarea id="comment-body" class="form-control" name="" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="comment-save" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script src="{{asset('js/journal.js')}}"></script>
<script>
    var urlComment = "{{ route('comments.update', '') }}";
    var urlLike = "{{ route('like.store') }}";
    var token = "{{ Session::token() }}";

    $('textarea').on('keydown', function (e) {
        if (e.which == 13) {
            // e.preventDefault();
            e.stopPropagation();
        }
    }).on('input', function () {
        $(this).height(1);
        var totalHeight = $(this).prop('scrollHeight') - parseInt($(this).css('padding-top')) -
            parseInt($(this).css('padding-bottom'));
        $(this).height(totalHeight);
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

</script>
@endsection
