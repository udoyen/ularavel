<?php
/**
 * Created by PhpStorm.
 * User: george
 * Date: 9/18/16
 * Time: 7:04 AM
 */
namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Foundation\Auth;
use App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use Validator;

class AccountController extends Controller {

    public function getCreate(){

        return View('account.create');
    }

    public function postCreate(Request $request){

        $validator = Validator::make($request->all(),

                [
                'email'             => 'required|max:50|email|unique:users',
                'username'          => 'required|max:20|min:3|unique:users',
                'password'          => 'required|max:6',
                'password_again'    => 'required|same:password'
            ]
        );

        if($validator->fails()){

            die('Failed');

        }else{

            die('Success');

        }
    }

}