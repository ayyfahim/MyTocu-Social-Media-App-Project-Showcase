@extends('layouts.app')

@section('content')

<section id="all_notifications" class="py-100 vue">
    @forelse (Auth::user()->notifications as $notification)
    <notification-item :unread="{{ $notification }}"></notification-item>
    @empty
    <a class="dropdown-item notification-item clearfix">
        <p class="d-inline-block m-0">
            <b>You have no unread notifications.</b>
        </p>
    </a>
    @endforelse
    {{-- <notification :user="{{ Auth::user() }}" :unreads="{{ Auth::user()->notifications }}"></notification> --}}
</section>

@endsection
