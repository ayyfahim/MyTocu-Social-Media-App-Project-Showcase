@extends('layouts.app')

@section('title')
Search: {{ $searchText }}
@endsection

@section('content')


<section class="py-100">
    <h2>There are {{ $searchResults->count() }} results for "{{$searchText}}"</h2>

    <div id="search_tabs" class="my-4">
        <ul class="list-group col-md-7" role="tablist">
            <li class="active">
                <a href="#posts" class="list-group-item list-group-item-action active" data-toggle="list"
                    role="tab">Posts</a>
            </li>
            <li>
                <a href="#journals" class="list-group-item list-group-item-action" data-toggle="list"
                    role="tab">Journals</a>
            </li>
            <li>
                <a href="#users" class="list-group-item list-group-item-action" data-toggle="list" role="tab">Users</a>
            </li>
        </ul>
    </div>
    <div class="tab-content ">
        <div id="users" class="tab-pane" role="tabpanel">
            @if (is_array($users) || is_object($users))
            @forelse( $users as $user)
            @include('user.partials.block', [
            'user' => $user->searchable
            ])
            @empty
            <div class="col-md-12">
                <p>No user found.</p>
            </div>
            @endforelse
            @else
            <div class="col-md-12">
                <p>No user found.</p>
            </div>
            @endif
        </div>

        <div id="posts" class="tab-pane active" role="tabpanel">
            <div class="row contents" data-next-page="">
                @if (is_array($posts) || is_object($posts))
                @forelse( $posts as $post)
                @if ($post->searchable->user->status == 0)
                @include('post.block', [
                'post' => $post->searchable
                ])
                @endif
                @empty
                <div class="col-md-12">
                    <p>No posts found.</p>
                </div>
                @endforelse
                <div class="col-md-12">
                    {{ $posts->links() }}
                </div>
                @else
                <div class="col-md-12">
                    <p>No posts found.</p>
                </div>
                @endif
            </div>
        </div>

        <div id="journals" class="tab-pane row journal-row contents" role="tabpanel">
            @if (is_array($journals) || is_object($journals))
            @forelse( $journals as $journal)
            @if ($journal->searchable->user->status == 0)
            @include('journal.block', [
            'journal' => $journal->searchable
            ])
            @endif
            @empty
            <div class="col-md-12">
                <p>No journals found.</p>
            </div>
            @endforelse
            <div class="col-md-12">
                {{ $journals->links() }}
            </div>
            @else
            <div class="col-md-12">
                <p>No journals found.</p>
            </div>
            @endif
        </div>

    </div>

    </div>

</section>


@endsection

@section('scripts')
<script>
    $('body').on('click', '.pagination a', function (e) {

        var element = this;
        var contents = $(element).closest(".contents");

        e.preventDefault();
        var url = $(this).attr('href');

        $.get(url, function (data) {
            contents.html(data);
        });

    });

</script>
@endsection
