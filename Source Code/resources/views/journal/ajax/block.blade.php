@foreach ($journals as $journal)
@include('journal.block')
@endforeach
<div class="col-md-6">
    {{ $journals->links() }}
</div>
