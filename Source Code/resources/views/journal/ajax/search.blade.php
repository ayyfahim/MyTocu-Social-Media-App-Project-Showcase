@foreach( $journals as $journal)
@include('journal.block', [
'journal' => $journal->searchable
])
@endforeach
<div class="col-md-12">
    {{ $journals->links() }}
</div>
