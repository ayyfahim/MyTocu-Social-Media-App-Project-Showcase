<?php

namespace App\Http\Controllers;

use App\User;
use App\Liste;
use App\Comment;
use App\Country;
use App\Journal;
use Carbon\Carbon;
use App\Jobs\SendUpdateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'image', 'activateAccount');
        $this->middleware('verified')->except('show', 'image', 'activateAccount');
    }

    public function show(User $user)
    {
        if (!$user) {
            abort(404);
        }

        //SEO
        $meta_title = $user->name;
        $meta_description = $user->name . ' is on ' . env('APP_NAME') . '. ' . env('APP_DESC');
        $meta_url = route('user.show', $user->slug);
        $image = route('image.account', $user->user_image);

        SEOMeta::setTitle($meta_title);
        SEOMeta::setDescription($meta_description);

        OpenGraph::setUrl($meta_url);
        OpenGraph::addImage($image);

        OpenGraph::setTitle($meta_title)
            ->setDescription($meta_description)
            ->setType('profile')
            ->setProfile([
                'name' => $user->name,
                'username' => $user->name,
                'gender' => $user->gender
            ]);

        // If the $user is auth user
        if (auth()->user() == $user) {
            // Check if the user has verified his email
            if (!$user->hasVerifiedEmail()) {
                return redirect()->route('verification.notice');
            }
            return $this->authUserProfile($user);
        } else {
            // If the user profile is private
            if ($user->isPrivate()) {
                // If he's not logged in
                if (!Auth::check()) {
                    return $this->userProfilePrivate($user);
                }
                // If he is friend with him
                if (auth()->user()->isFriendWith($user)) {
                    return $this->userProfile($user);
                } else {
                    return $this->userProfilePrivate($user);
                }
            } else {
                return $this->userProfile($user);
            }
        }
    }

    public function authUserProfile($user)
    {
        return view('user.show', [
            'user' => $user
        ]);
    }

    public function userProfile($user)
    {
        $lists = Liste::where('user_id', $user->id)->latest()->with(['likes', 'comments', 'posts', 'comments_limit', 'user'])->paginate(6);
        $lists->withPath($user->slug . '/render-lists');

        $journals = Journal::where('user_id', $user->id)->latest()->with(['likes', 'comments', 'comments_limit', 'user'])->paginate(3);
        $journals->withPath($user->slug . '/render-journal');

        return view('user.profile', [
            'lists' => $lists,
            'user' => $user,
            // 'comments' => Comment::latest()->get(),
            'journals' => $journals
        ]);
    }

    public function userProfilePrivate($user)
    {
        return view('user.profile_private', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        if (auth()->user() != $user) {
            abort(404);
        }

        SEOMeta::setTitle('Edit Account: ' . $user->name);

        return view('user.edit', [
            'user' => Auth::user(),
            'countries' => Country::all(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user() != $user) {
            abort(404);
        }
        // All request to a variable
        $name = $request->name;
        $gender = $request->gender;
        $status = $request->status;
        $email_notification = $request->email_notification;
        $country = $request->country;
        $state = $request->state;

        // Create Carbon date
        $year = $request['birth_year'];
        $month = $request['birth_month'];
        $day = $request['birth_day'];
        $date = Carbon::createFromFormat('d-m-Y', $day . '-' . $month . '-' . $year);
        $request['birthdate'] = $date->format('Y-m-d');

        $this->validate(
            $request,
            [
                'name' => ['required', 'string', 'max:255'],
                'birthdate' => ['required', 'date', 'before:-13 years'],
                'gender' => ['required', 'string'],
                'country' => ['required', 'string'],
                'state' => ['required', 'string'],
                'status' => ['required', 'string'],
                'email_notification' => ['required', 'string'],
            ],
            $messages = [
                'birthdate.before' => 'You must be 13 years old before using this site.',
                'name.regex' => 'Name may only contain letters.',
            ],
        );

        Auth::user()->name = $name;
        Auth::user()->birthdate = $date->format('Y-m-d H:i:s');
        Auth::user()->gender = $gender;
        Auth::user()->status = $status;
        Auth::user()->country_id = $country;
        Auth::user()->state_id = $state;
        Auth::user()->e_notif = $email_notification;
        Auth::user()->save();

        return redirect()->route('user.edit', Auth::user()->slug)->withSuccess('Account updated successfully!');
    }

    public function updatePassword(Request $request, User $user)
    {
        if (auth()->user() != $user) {
            abort(404);
        }
        $request->validate([
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->withToastError("Your old password dosen't match with you current password");
        }

        if (Hash::check($request->old_password, Auth::user()->password)) {
            if ($request->new_password == Auth::user()->password) {
                return back()->withToastError("Your new password can't be same as your previous one.");
            }
            Auth::user()->update([
                'password' => Hash::make($request->new_password),
            ]);
            return back()->withToastSuccess("Password changed successfully.");
        }
    }

    public function updateEmail(Request $request, User $user)
    {
        if (auth()->user() != $user) {
            abort(404);
        }

        $request->validate([
            'email' => 'email|unique:users',
            'new_email' => 'required|email'
        ]);

        if (Auth::user()->email != $request->new_email) {

            $route = URL::temporarySignedRoute('verify.email', 60 * 60, [
                'user' => Auth::user()->slug,
                'email' => $request->new_email
            ]);


            SendUpdateMail::dispatch($request->new_email, $route, Auth::user())->delay(Carbon::now()->addSeconds(30));
            return back()->withSuccess("We've successfully sent a confirmation email.");
        }
    }

    public function disableAccount(User $user)
    {
        if (auth()->user() != $user) {
            abort(404);
        }

        Auth::user()->delete();
        return redirect()->route('login');
    }

    public function verifyEmail(Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        $request->validate([
            'user' => 'required',
            'email' => 'email|unique:users',
        ]);

        if (Auth::user()->slug != $request->user) {
            abort(404);
        }


        Auth::user()->update([
            'email' => $request->email,
            'email_verified_at' => Carbon::now()
        ]);

        return redirect()->route('user.show', Auth::user()->slug)->withSuccess("We've successfully updated your email.");
    }

    public function cropImage(Request $request)
    {
        $extension = $_POST['extension'];
        $image = $_POST['image'];
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);

        $filename = Auth::id() . '.' . $extension;

        file_put_contents(storage_path('uploads/profile-pics/') . $filename, $image);

        Auth::user()->update([
            'user_image'  => $filename,
        ]);
    }

    public function image($filename)
    {
        $file = storage_path('uploads/profile-pics/' . $filename);
        return response()->file($file);
    }

    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }

    public function activateAccount(Request $request)
    {
        $email = $request->email;
        $user = User::onlyTrashed()->where('email', $email)->first();

        if (!$user) {
            return redirect()->route('register')->withError("User not found. Please try again.");
        }

        $user->restore();

        return redirect()->route('register')->withSuccess("Your account is activated.");
    }
}
