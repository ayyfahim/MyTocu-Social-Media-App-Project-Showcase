@if ($user->id == Auth::id())
<div class="row mb-3">
    <div class="col-md-6">
        <a class="custom create-new" href="{{ route('post.create') }}">
            <i class="far fa-file-image"></i> Create new post.
        </a>
    </div>
</div>
@endif
<div class="row contents">
    @forelse ($posts as $post)
    @include('posts.block')
    @empty
    <div class="col-md-12 align-self-center">
        @if ($user->id == Auth::id())
        <p class="empty"><i class="far fa-frown"></i> You have no posts.</p>
        @else
        <p class="empty"><i class="far fa-frown"></i> This user have no posts.</p>
        @endif
    </div>
    @endforelse
    <div class="col-md-12">
        {{ $posts->links() }}
    </div>
</div>
