<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Input;
use Redirect;
use App\User;
use Validator;
use Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function login()
    {
        if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password')], Input::get('remember_me'))){

            return Redirect::to("http://google.com");

        }else{
            
            return Auth::user();
            
        }
    }

    public function logout()
    {
        if (Auth::user()){

            //Logout user
           // Session::flush();
            Auth::logout();
            
            
            //Return to main page with communication
            return Redirect::to('/')->with('communication_success', ["Wylogowano pomyślnie"]);

        }else{

            return Redirect::route('login')->with('communication_info', ["Nie zalogowano"]);

        }
    }

    public function register()
    {

        $validator = Validator::make(Input::all(), [
        'name' => 'required|unique:users',
        'email' => 'required|E-Mail|unique:users',
        'password' => 'required|confirmed|min:8|case_diff|numbers|letters|symbols'
        ]);

        if (!$validator->fails()){

            $user = new User;

            $user->name = Input::get('name');

            $user->email = Input::get('email');

            $user->password = bcrypt(Input::get('password'));

            $user->save();

        }else{
            return Redirect::back()->withErrors($validator)->withInput();
        }
    }
}
