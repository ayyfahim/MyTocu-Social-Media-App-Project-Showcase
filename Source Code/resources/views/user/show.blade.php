@extends('layouts.app')

@section('content-fluid')

<section id="user_profile" class="py-100">
    <div class="container-md">
        <div class="row upper-part align-items-center">
            @include('user.partials.info')
        </div>

        <div class="lower-part">
            <div class="tab-content ">
                <div id="wait">
                    <img src="{{ asset('images/loader.gif') }}" alt="">
                </div>
                {{-- Auth User Lists --}}
                <div class="tab-pane animated pulse" id="lists" role="tabpanel">
                </div>
                {{-- Auth Journals --}}
                <div class="tab-pane animated pulse" id="journals" role="tabpanel">
                </div>
                @auth
                {{-- Friend Tabs --}}
                <div class="tab-pane animated pulse" id="friends" role="tabpanel">
                </div>
                {{-- Explor Tabs --}}
                <div class="tab-pane animated pulse active" id="explore" role="tabpanel">
                </div>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="friend_invite_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('invite.friend') }}" method="post" class="custom">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Invite Friend</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input id="email" type="email" name="email" class="form-control">
                        <label for="email"><span>Enter an email</span></label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send <i class="far fa-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('js/account.js') }}"></script>
<script>
    var urlLike = "{{route('like.store')}}";
    var token = "{{Session::token()}}";
</script>
<script>
    $(document).ready(function () {
        $('body').on('click', '.pagination a', function (e) {

            var element = this;
            var contents = $(element).closest(".contents");

            e.preventDefault();
            var url = $(this).attr('href');

            {{--
            $.get(url, function (data) {
                contents.html(data);
            });
            --}}

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{Session::token()}}"
                },
                url: url,
                beforeSend: function() {
                    $('#wait').show()
                },
                complete: function() {
                    $('#wait').hide()
                },
                method: "get",
                success: function (data) {
                    contents.html(data);
                }
            });

        });
    });

</script>
<script>
    function checkForInput(element) {
        // element is passed to the function ^

        const $label = $(element);

        if ($(element).val().length > 0) {
            $label.addClass('input-has-value');
        } else {
            $label.removeClass('input-has-value');
        }
    }

    function checkForInputLabel(element) {
        // element is passed to the function ^

        const $label = $(element).siblings('label');

        if ($(element).val().length > 0) {
            $label.addClass('input-has-value');
        } else {
            $label.removeClass('input-has-value');
        }
    }

    // The lines below are executed on page load
    $('.form-control').each(function () {
        checkForInputLabel(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.form-control').on('change keyup', function () {
        checkForInputLabel(this);
    });

    // The lines below are executed on page load
    $('.form-control').each(function () {
        checkForInput(this);
    });

    // The lines below (inside) are executed on change & keyup
    $('.form-control').on('change keyup', function () {
        checkForInput(this);
    });

    // $('.upper-part .user-tabs .list-group li:nth-child(4) a').tab('show')

</script>
<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

            var $this = $(e.target),
                loadurl = $this.attr('href'),
                targ = $this.attr('data-target');

            if (!$this.hasClass("already_opened")) {
                // Ajax
                {{--
                    $.get(loadurl, function(data) {
                        $(targ).html(data);
                    });
                --}}

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{Session::token()}}"
                    },
                    url: loadurl,
                    beforeSend: function() {
                        $('#wait').show()
                    },
                    complete: function() {
                        $('#wait').hide()
                    },
                    method: "get",
                    success: function (data) {
                        $(targ).html(data);
                    }
                });
            };

            $this.addClass("already_opened");

            return false;
        });
    })

    $(function () {
        $('a[data-target="#explore"]').tab('show')
    })
</script>
@endsection
