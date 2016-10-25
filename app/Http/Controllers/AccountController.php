<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 9/18/16
 * Time: 7:04 AM
 */
namespace App\Http\Controllers;

use App\Http\Requests;

//use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;

use Validator;
use App\User;

class AccountController extends Controller
{

    public function getSignIn()
    {
        return View('account.signin');
    }

    public function postSignIn(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required'

        ]);

        if ($validator->fails()) {
            return Redirect::route('account-sign-in')
                ->withErrors($validator)
                ->withInput();
        } else {

            $remember = (Input::has('remember')) ? true : false;

            $auth = Auth::attempt([
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'active' => 1
            ], $remember);

            if ($auth) {
                // Redirect to the intended page
                return Redirect::intended('/');
            } else {
                return Redirect::route('account-sign-in')
                    ->with('global', 'Email/password wrong, or account not activated.');
            }

        }

        return Redirect::route('account-sign-in')
            ->with('global', 'There was a problem signing you in. Have you activated?');
    }

    public function getSignOut()
    {
        Auth::logout();
        return Redirect::route('home');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate()
    {

        return View('account.create');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postCreate(Request $request)
    {

        $validator = Validator::make($request->all(),

            [
                'email' => 'required|max:50|email|unique:users',
                'username' => 'required|max:20|min:3|unique:users',
                'password' => 'required|min:6',
                'password_again' => 'required|min:6|same:password'
            ]
        );

        if ($validator->fails()) {

            return Redirect::route('account-create')
                ->withErrors($validator)
                ->withInput(); // access input fields from view page

        } else {
            // create account
            $email = Input::get('email');
            $username = Input::get('username');
            $password = Input::get('password');

            // Activation Code
            $code = str_random(60);


            $user = User::create(array(
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'code' => $code,
                'active' => 0,
            ));

            if ($user) {

                Mail::send('emails.auth.activate', ['link' => URL::route('account-activate', $code), 'username' => $username], function ($message) use ($user) {

                    $message->to($user->email, $user->username)->subject('Activate your account');


                });
                // Send email
                return Redirect::route('home')
                    ->with('global', 'Your acoount has been created! We have sent you an email');
            }

        }
    }

    /**
     * @param $code
     * @return mixed
     */
    public function getActivate($code)
    {

        $user = User::where('code', '=', $code)->where('active', '=', 0);

        if ($user->count()) {
            $user = $user->first();


            // Update user to activate state
            $user->active = 1;
            $user->code = '';

            if ($user->save()) {
                return Redirect::route('home')
                    ->with('global', 'Activated, you can now sign in!');
            }
        }

        return Redirect::route('home')
            ->with('global', 'We could not activate your account. Try again later.');


    }

    public function getChangePassword()
    {

        return View('account.password');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postChangePassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'new_password_again' => 'required|min:6|same:new_password'
        ]);

        if ($validator->fails()) {
            // redirect
            return Redirect::route('account-change-password')
                ->withErrors($validator);
        } else {
            // change password
            $user = User::find(Auth::user()->id);

            $old_password = Input::get('old_password');
            $new_password = Input::get('new_password');

            if (Hash::check($old_password, $user->getAuthPassword())) {
                // password user provided matches
                $user->password = Hash::make($new_password);

                if ($user->save()) {
                    return Redirect::route('home')
                        ->with('global', 'Your password has been changed');
                }
            } else {
                return Redirect::route('account-change-password')
                    ->with('global', 'Your old password is incorrect.');
            }
        }

        return Redirect::route('account-change-password')
            ->with('global', 'Your password could not be changed.');
    }


    public function getForgotPassword()
    {

        return View('account.forgot');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postForgotPassword(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return Redirect::route('account-forgot-password')
                ->withErrors($validator)
                ->withInput();
        } else {
            // change password
            $user = User::where('email', '=', $request->get('email'));

            if ($user->count()) {
                $user = $user->first();

                // Generate a new code and password
                $code = str_random(60);
                $password = str_random(10);

                $user->code = $code;
                $user->password_temp = Hash::make($password);

                if ($user->save()) {
                    Mail::send('emails.auth.forgot', [
                        'link' => URL::route('account-recover', $code), 'username' => $user->username, 'password' => $password],
                        function ($message) use ($user) {
                            $message->to($user->email, $user->username)->subject('Your new password');
                        }
                    );

                    return Redirect::route('home')
                        ->with('global', 'We have sent you a new password by email');
                }
            }
        }

        return Redirect::route('account-forgot-password')
            ->with('global', 'Could not request new password');

    }

    public function getRecover($code)
    {
        $user = User::where('code', '=', $code)
            ->where('password_temp', '!=', '');

        if ($user->count()) {
            $user = $user->first();

            $user->password = $user->password_temp;
            $user->code = '';
            $user->password_temp = '';

            if ($user->save()) {
                return Redirect::route('home')
                    ->with('global', 'Your account has been recovered and you can sign in with your new password');
            }
        }

        return Redirect::route('home')
            ->with('global', 'Could not recover your account.');
    }


}