<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Socialite;

use App\User;
use App\Notifications\WelcomeNotification;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $social = Socialite::driver($provider)->user();
        $user = User::where('email', $social->email)->first();
        if (!is_null($user)) {
            $user->provider = $provider;
            $user->provider_id = $social->id;
            $user->save();
            \auth()->login($user, true);
        } else {
            $user = User::create([
                'name' => $social->name,
                'email' => $social->email,
                'provider' => $provider,
                'provider_id' => $social->id,
            ]);
            \auth()->login($user, true);
            $user->notify(new WelcomeNotification($user));
        }
        return redirect('/');
    }
}
