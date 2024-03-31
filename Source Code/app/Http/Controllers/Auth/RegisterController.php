<?php

namespace App\Http\Controllers\Auth;

use App\Role;
use App\User;
use App\Invite;
use App\Country;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Artesaos\SEOTools\Facades\SEOMeta;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Demency\Friendships\Models\Friendship;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm(Request $request)
    {
        SEOMeta::setTitle('Regsiter');
        $countries = Country::all();
        if ($request->email || $request->user) {
            $invite = [
                'email' => $request->email,
                'user' => $request->user,
            ];
            return view('auth.register', compact('countries', 'invite'));
        }
        return view('auth.register', compact('countries'));
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $year = $data['birth_year'];
        $month = $data['birth_month'];
        $day = $data['birth_day'];

        // Create Carbon date
        $date = Carbon::createFromFormat('d-m-Y', $day . '-' . $month . '-' . $year);

        $data['birthdate'] = $date->format('Y-m-d');

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'birthdate' => ['required', 'date', 'before:-13 years'],
            'gender' => ['required', 'string'],
            'country' => ['required'],
            'state' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $year = $data['birth_year'];
        $month = $data['birth_month'];
        $day = $data['birth_day'];

        // Create Carbon date
        $date = Carbon::createFromFormat('d-m-Y', $day . '-' . $month . '-' . $year);

        if (isset($data['invited_friend'])) {

            $invited_friend = User::where('slug', $data['invited_friend'])->get()->first();

            $invite = Invite::where([
                'sender_id' => $invited_friend->id,
                'recevier_email' => $data['email']
            ])->get()->first();

            if (!$invite) {
                abort(404);
            }

            $invite->update(['status' => '1']);

            $user = User::forceCreate([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'birthdate' => $date->format('Y-m-d H:i:s'),
                'gender' => $data['gender'],
                'country_id' => $data['country'],
                'state_id' => $data['state'],
                'invited_by' => $invited_friend->id,
                'email_verified_at' => now()
            ]);

            Friendship::create([
                'sender_type' => $invited_friend->getMorphClass(),
                'sender_id' => $invited_friend->getKey(),
                'recipient_type' => $user->getMorphClass(),
                'recipient_id' => $user->getKey(),
                'status' => '1',
            ]);

            $role = Role::select('id')->where('name', 'user')->first();

            $user->roles()->attach($role);

            return $user;
        } else {

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'birthdate' => $date->format('Y-m-d H:i:s'),
                'gender' => $data['gender'],
                'country_id' => $data['country'],
                'state_id' => $data['state'],
            ]);

            $role = Role::select('id')->where('name', 'user')->first();

            $user->roles()->attach($role);

            return $user;
        }
    }
}
