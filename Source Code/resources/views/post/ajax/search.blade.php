@foreach( $posts as $post)
@include('post.block', [
'post' => $post->searchable
])
@endforeach
<div class="col-md-12">
    {{ $posts->links() }}
</div>
