@extends('layouts.app')

@section('content')

<section class="py-100">
    <div class="row">
        <div class="col-lg-3 col-md-5">
            @include('partials.content-user', [
            'content' => $post
            ])
        </div>
    </div>

    <div class="row" id="single-content">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">{{ $post->title }}</h5>
                </div>
                <div class="post-image">
                    <img class="img-fluid card-img" src="{{ route('image.post', ['filename' => $post->post_image]) }}"
                        alt="" class="img-fluid">
                </div>
                <div class="card-body" data-post="{{ $post->id }}">
                    <p class="content-description card-text">{{ $post->description }}</p>

                    @include('partials.interactions', [
                    'content' => $post
                    ])

                    @if ($post->user != null)
                    @if ($user->id == $post->user->id)
                    <div class="dropdown" id="content-dropdown">
                        <button type="button" class="btn no-focus btn-sm" id="post_button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="post_button">

                            <a href="{{ route('post.edit', $post->id) }}"
                                class="edit-post no-focus btn dropdown-item">Edit
                                Post</a>

                            <form action="{{ route('post.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-post no-focus btn dropdown-item">Delete
                                    Post</button>
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
                        @include('partials.commentblock', [
                        'content' => $post
                        ])
                        @empty
                        <p class="m-0">This post has no comments</p>
                        @endforelse
                    </div>
                    <div class="post-comment">
                        @if (Auth::check())

                        <form action="{{ route('comments.store') }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="form-group m-0">
                                <textarea class="form-control no-focus comment-area" name="body"
                                    placeholder="Write a comment..."></textarea>
                                <button class="submit_comment no-focus btn f-roboto" type="submit"
                                    style="color: #000;">Submit</button>
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
                    <i class="fas fa-times"></i>
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
<script src="{{asset('js/post.js')}}"></script>
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

</script>
@endsection
