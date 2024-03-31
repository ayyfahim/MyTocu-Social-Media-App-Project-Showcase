@extends('layouts.app')

@section('title')
Profile: {{ $user->name }}
@endsection

@section('content')

<section id="user_profile" class="section">
    <div class="row upper-part align-items-center">
        @include('user.partials.info')
    </div>

    <div class="lower-part">
        <div class="alert alert-danger" role="alert">
            This profile is set to private.
        </div>
    </div>

</section>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('button[data-action="accept"]').on('click', function (e) {
            $('#friendship').append('<input type="hidden" name="action" value="accept">');
        });

        $('button[data-action="cancel"]').on('click', function (e) {
            $('#friendship').append('<input type="hidden" name="action" value="cancel">');
        });
    });
</script>
@endsection
