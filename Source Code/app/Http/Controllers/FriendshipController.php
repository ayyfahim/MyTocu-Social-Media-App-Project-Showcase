<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Jobs\SendFriendRequestMail;
use Illuminate\Support\Facades\Auth;
use App\Notifications\SentFriendRequest;
use App\Notifications\AcceptFriendRequest;

class FriendshipController extends Controller
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

    public function friendship(Request $request)
    {
        $user = User::where('slug', $request->user)->first();

        if (Auth::user() == $user) {
            return back();
        }

        $message = "Action completed Successfully";

        if (Auth::user()->isFriendWith($user)) {

            // Remove Friend
            Auth::user()->unfriend($user);
            $message = $user->name . " has been unfriended.";
        } elseif (Auth::user()->hasSentFriendRequestTo($user)) {

            // Remove Friend Request
            $user->denyFriendRequest(Auth::user());
            $message = "You have successfully cancelled " . $user->name . "'s friend request.";
        } elseif (Auth::user()->hasFriendRequestFrom($user)) {
            if ($request->action == "accept") {

                // Accept Friend Request
                Auth::user()->acceptFriendRequest($user);
                $message = "You have successfully accepted " . $user->name . "'s friend request.";
            } else if ($request->action == "cancel") {
                // Cancel Friend Request
                Auth::user()->denyFriendRequest($user);
                $message = "You have successfully cancelled " . $user->name . "'s friend request.";
            }
        } else {
            // Send Friend Request
            Auth::user()->befriend($user);
            $message = "You have successfully sent a friend request to " . $user->name;
        }

        return redirect()->route('user.show', $user->slug)->withToastSuccess($message);
    }
}
