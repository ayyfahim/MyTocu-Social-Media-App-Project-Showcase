@foreach ($lists as $list)
@include('list.block')
@endforeach
<div class="col-md-12">
    {{ $lists->links() }}
</div>
