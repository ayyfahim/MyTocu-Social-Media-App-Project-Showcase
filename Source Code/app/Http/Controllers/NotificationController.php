<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    public function unreadNotifications()
    {
        return auth()->user()->unreadNotifications->toJson();
    }

    public function allNotifications()
    {
        return auth()->user()->notifications->toJson();
    }

    public function markAsReadUnreadNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
    }
}
