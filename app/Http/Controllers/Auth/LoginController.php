<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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
    protected function redirectTo(){
    //    return  \App\Http\Middleware\LocaleMiddleware::getLocale().'/';
       return  '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {
        return view('welcome');
    }

//    public function github() {
//        return Socialite::driver('github')->redirect();
//    }
//
//    public function githubRedirect() {
//        $user = Socialite::driver('github')->user();
//        $user = User::firstOrCreate([
//            'email' => $user->email
//        ],[
//            'name' => $user->name,
//            'password' => Hash::make(Str::random(24)),
//        ]);
//
//        Auth::login($user, true);
//
//        return redirect('/');
//    }
//
//    public function pinterest() {
//        return Socialite::driver('pinterest')->redirect();
//    }
//
//    public function pinterestRedirect() {
//        $user = Socialite::driver('pinterest')->user();
//        dd($user);
//        $user = User::firstOrCreate([
//            'email' => $user->email
//        ],[
//            'name' => $user->name,
//            'password' => Hash::make(Str::random(24)),
//        ]);
//
//        Auth::login($user, true);
//
//        return redirect('/test');
//    }
}
