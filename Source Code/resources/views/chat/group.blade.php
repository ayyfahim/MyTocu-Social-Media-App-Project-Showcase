@extends('layouts.app')

@section('content')
<div class="row justify-content-center" id="chat">
    <div class="col-md-10">
        <group-chat :user="{{ Auth::user() }}"></group-chat>
    </div>
</div>
@endsection