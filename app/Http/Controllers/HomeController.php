<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Foundation\Auth;
use Illuminate\Support\Facades\Mail;
use App\User;


class HomeController extends Controller
{
    //
    public function home(){
        
//        Mail::send('emails.auth.test', array('name'=> 'George'), function($message){
//            $message->to('udoyen@gmail.com', 'George Udosen')->subject('Test email');
//        });
        
        return View('home');
    }
}
