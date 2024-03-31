<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\SEOMeta;

class ChatController extends Controller
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

    public function groupChat()
    {
        return view('chat.group');
    }

    public function privateChat($user = null)
    {
        if ($user) {
            $user = User::where('slug', $user)->first()->id;
        }
        SEOMeta::setTitle('Chat');
        return view('chat.private', compact('user'));
    }

    public function usersList()
    {
        return Auth::user()->getFriends();
    }

    public function chatImage($filename)
    {
        $file = storage_path('uploads/chats/' . $filename);
        return response()->file($file);
    }
}
