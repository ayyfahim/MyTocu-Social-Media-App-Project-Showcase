<div class="row mb-3">
    <div class="col-md-6">
        <a class="custom create-new" href="{{ route('list.create') }}">
            <i class="far fa-file-image"></i> Create a new list.
        </a>
    </div>
</div>
<div class="row contents">
    @forelse ($lists as $list)
    @include('list.block')
    @empty
    <div class="col-md-12 align-self-center">
        <p class="empty"><i class="far fa-frown"></i> You have no posts.</p>
    </div>
    @endforelse
    <div class="col-md-12">
        {{ $lists->links() }}
    </div>
</div>
