@extends('layouts.app')

@section('title')
Profile: {{ $user->name }}
@endsection

@section('content-fluid')

<div class="container-md">
    <section id="user_profile" class="py-100">
        <div class="row upper-part align-items-center">
            @include('user.partials.info')
        </div>
        <div class="lower-part">
            <div class="tab-content ">
                <div class="tab-pane active" id="lists" role="tabpanel">
                    <div class="row contents">
                        @forelse ($lists as $list)
                        @include('list.block')
                        @empty
                        <div class="col-md-12 align-self-center">
                            <p class="empty"><i class="far fa-frown"></i> {{ $user->name }} has no posts.</p>
                        </div>
                        @endforelse
                        <div class="col-md-12">
                            {{ $lists->links() }}
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="journals" role="tabpanel">
                    <div class="row journal-row contents">
                        @forelse ($journals as $journal)
                        @include('journal.block')
                        @empty
                        <div class="col-md-12 align-self-center">
                            <p class="empty"><i class="far fa-frown"></i> {{ $user->name }} has no journals.</p>
                        </div>
                        @endforelse
                        <div class="col-md-12">
                            {{ $journals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('scripts')

@auth
<script src="/js/account.js"></script>
<script>
    var urlLike = "{{ route('like.store') }}";
    var token = "{{ Session::token() }}";

</script>
@endauth
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
<script>
    $(document).ready(function () {
        var frd_btn = null;
        $("#accept_request").on('click', function () {
            $('#friendship').append('<input type="hidden" name="action" value="accept">');
        });
        $("#cancel_request").on('click', function () {
            $('#friendship').append('<input type="hidden" name="action" value="cancel">');
        });
    });
    $(function () {
        $('a[data-target="#lists"]').tab('show')
    })
</script>
@endsection
