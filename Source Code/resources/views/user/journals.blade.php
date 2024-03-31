<div class="row mb-3">
    <div class="col-md-6">
        <a class="custom create-new" href="{{ route('journal.create') }}">
            <i class="far fa-file-image"></i> Create new journal entry.
        </a>
    </div>
</div>
<div class="row journal-row contents">
    @forelse ($journals as $journal)
    @include('journal.block')
    @empty
    <div class="col-md-12 align-self-center">
        <p class="empty"><i class="far fa-frown"></i> You have no journals.</p>
    </div>
    @endforelse
    <div class="col-md-12">
        {{ $journals->links() }}
    </div>
</div>
