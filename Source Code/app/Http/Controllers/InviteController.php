<?php

namespace App\Http\Controllers;

use App\Invite;
use Carbon\Carbon;
use App\Mail\InviteMail;
use App\Jobs\SendInviteMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
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

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'email|unique:users'
        ]);

        if (Auth::user()->email != $request->email) {

            if (Invite::where('recevier_email', $request->email)->first()) {
                return back()->withError("Someone already sent an invite to this user.");
            }

            $route = URL::signedRoute('register', [
                'email' => $request->email,
                'user' => Auth::user()->slug
            ]);

            Invite::create([
                'sender_id' => Auth::id(),
                'recevier_email' => $request->email,
                'status' => '0',
            ]);

            SendInviteMail::dispatch($request->email, $route, Auth::user())->delay(Carbon::now()->addSeconds(30));

            return back()->withSuccess("You've successfully invited your friend.");
        }
    }

    public function error()
    {
        return view('auth.register');
    }
}
