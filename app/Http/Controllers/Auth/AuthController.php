<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\LoginRequest;
use App\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use Redirect;
use Session;
use Validator;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout', 'lock', 'locked', 'unlock']]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showLoginForm()
    {

        // Remember cache for 30 days
        $userCount = \Cache::remember('userCount', 1440 * 30, function() {
            return User::count();
        });

        if(!$userCount) {
            return Redirect::action('SetupController@index');
        }

        return view('auth.login');

    }

    public function login(LoginRequest $request)
    {

        // Validate credentials
        if(Auth::validate($request->only('email', 'password'))) {

            // Get user information
            $user = User::where('email', $request->email)->firstOrFail();

            // If user wants to use gAuthentication
            if($user->gauth_token) {
                Session::set('gAuthUser', $user->id);
                Session::set('gAuthRemember', $request->remember);
                return Redirect::action('Auth\AuthController@gAuthentication');
            }

            // Otherwise, log in the normal way
            else {
                Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember);
                Session::set('logged_in', true);
                Session::set('locked', false);
                return Redirect::intended('/');
            }

        } else {

            // Notify the user if credentials are wrong
            Session::flash('error', trans('dam.auth.invalid'));
            return redirect()->back()->withInput($request->all());

        }

    }

    public function gAuthentication()
    {
        return view('auth.gAuth');
    }

    public function gAuthenticate(Request $request)
    {

        // Initialize 2FA method
        $google2fa = new Google2FA();

        // Get user information
        $user = User::findOrFail(Session::get('gAuthUser'));

        // Verify Authentication keys
        if($google2fa->verifyKey($user->gauth_token, $request->gAuth)) {

            // Login the user
            Auth::loginUsingId($user->id, Session::get('gAuthRemember'));

            // Set the sessions
            Session::set('logged_in', true);
            Session::set('locked', false);

            // Destroy unnecessary session
            Session::forget('gAuthUser');

            return Redirect::intended('/');

        } else {

            // Notify the user
            Session::flash('error', trans('dam.auth.g2f_invalid'));
            return Redirect::action('Auth\AuthController@showLoginForm');

        }

    }

    public function lock()
    {
        Session::set('locked', true);
        return Redirect::action('Auth\AuthController@locked');
    }

    public function locked()
    {

        if(Session::get('locked')) {
            return view('auth.locked');
        } else {
            return Redirect::action('DashboardController@index');
        }

    }

    public function unlock(Request $request)
    {

        // Never trust user input.
        $credentials = ['email' => Auth::User()->email,
                        'password' => $request->password];

        // Validate credentials
        if(Auth::validate($credentials)) {
            Session::set('logged_in', true);
            Session::set('locked', false);
            return redirect()->intended('/');
        }

        // Credentials are not valid, notify and send back
        else {
            Session::flash('error', trans('dam.auth.invalid'));
            return Redirect::action('Auth\AuthController@locked');
        }

    }

}
