@foreach ($posts as $post)
@include('post.block')
@endforeach
<div class="col-md-6">
    {{ $posts->links() }}
</div>
