<?php

namespace App\Http\Controllers;

use Image;
use App\User;
use App\Message;
use Carbon\Carbon;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use App\Events\PrivateMessageSent;
use App\SendUserUnreadMessageMail;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
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

    public function fetchMessages()
    {
        return Message::with('user')->get();
    }

    public function sendMessages(Request $request)
    {
        $auth_user = Auth::user();

        $create_message = $auth_user->messages()->create([
            'message' => $message,
        ]);

        broadcast(new MessageSent($auth_user, $create_message->load('user')))->toOthers();

        return response([
            'status' => $request->receiver_id,
        ]);
    }

    public function fetchPrivateMessages($id)
    {
        $privateCommunication = Message::with('user')
            ->where(['user_id' => Auth::id(), 'receiver_id' => $id])
            ->orWhere(function ($query) use ($id) {
                $query->where(['user_id' => $id, 'receiver_id' => Auth::id()]);
            })
            ->get();

        return $privateCommunication;
    }

    public function sendPrivateMessages(Request $request, $id)
    {
        $auth_user = Auth::user();
        $input = $request->all();
        $input['receiver_id'] = $id;

        if ($request->file('file')) {
            $image = $request->file('file');
            $filename = time() . '.' . $image->extension();
            Image::make($image)->save(storage_path('uploads\chats\\' . $filename));

            $message = $auth_user->messages()->create([
                'user_id' => $request->user()->id,
                'image' => $filename,
                'receiver_id' => $id,
            ]);
        } else {
            $message = $auth_user->messages()->create($input);
        }

        broadcast(new PrivateMessageSent($message->load('user')))->toOthers();

        return response([
            'status' => 'Message Sent Successfully',
        ]);
    }

    public function setSeen(Request $request, $id)
    {
        if ($id != Auth::id()) {
            $input = $request->all();
            $input['receiver_id'] = $id;
            Message::where([
                'receiver_id' => Auth::id(),
                'user_id' => $id
            ])->update([
                'seen_at' => Carbon::now()
            ]);
        }

        SendUserUnreadMessageMail::where([
            'user_id' => $id,
            'receiver_id' => Auth::id(),
        ])
            ->delete();

        return response([
            'status' => 'Message Seen Successfully',
        ]);
    }
}
