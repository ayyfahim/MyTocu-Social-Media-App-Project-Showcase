@extends('layouts.dashboard')

@section('messages')
class="active"
@endsection

@section('content')
<div class="row" id="basic-table">
    @foreach ($messages as $message)
    <div class="col-xl-4 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <h4 class="card-title">{{ $message->name }}</h4>
                    <h6 class="">{{ $message->email }}</h6>
                    <p class="card-text mt-3">{{ $message->message }}</p>
                </div>
                <div class="card-body">
                    <a href="mailto:{{ $message->email }}?subject=Mytocu" class="card-link">Reply</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
