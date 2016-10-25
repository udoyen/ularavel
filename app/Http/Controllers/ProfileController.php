<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 9/22/16
 * Time: 9:20 AM
 */

namespace App\Http\Controllers;

use App\Http\Requests;

//use Illuminate\Foundation\Auth;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\App;
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


class ProfileController extends Controller {

    public function user($username){

        $user = User::where('username', '=', $username);

        if($user->count()){
            $user = $user->first();

            return View('profile.user')
                ->with('user', $user);
        }

        return App::abort(404);

    }

}