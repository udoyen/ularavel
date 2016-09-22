<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', array(
    'as' => 'home',
    'uses' => 'HomeController@home',
));

Route::get('/user/{username}', [
    'as' => 'profile-user',
    'uses' => 'ProfileController@user'
]);

/*
 * Authenticated group
 * */
Route::group(array('before' => 'auth'), function () {


    /*
        *
        * CSRF Protection
        *
        * */
    Route::group(array('before' => 'csrf'), function () {

        /*
        * Change Password (POST)
        * */
        Route::post('/account/change-password', array(
            'as' => 'account-change-password-post',
            'uses' => 'AccountController@postChangePassword'
        ));

    });

    /*
     * Change Password (GET)
     * */
    Route::get('/account/change-password', array(
        'as' => 'account-change-password',
        'uses' => 'AccountController@getChangePassword'
    ));

//    /*
//     * Change Password (GET)
//     * */
//    Route::get('/account/change-password', array(
//        'as' => 'account-change-password',
//        'uses' => 'AccountController@getChangePassword'
//    ));

    /*
     * Sign out (GET)
     * */
    Route::get('/account/sign-out', array(
        'as' => 'account-sign-out',
        'uses' => 'AccountController@getSignOut'
    ));
});

/*
 * Unauthenticated group
 * */
Route::group(array('before' => 'guest'), function () {

    /*
    *
    * CSRF Protection
    *
    * */
    Route::group(array('before' => 'csrf'), function () {

        /*
        * Create account (POST)
        *
        * */
        Route::post('/account/create', array(
            'as' => 'account-create-post',
            'uses' => 'AccountController@postCreate'
        ));


        /*
        * Sign in (POST)
        *
        * */
        Route::post('/account/sign-in', [
            'as' => 'account-sign-in-post',
            'uses' => 'AccountController@postSignIn'
        ]);

        /*
        * Forgot Password (POST)
        *
        * */
        Route::post('/account/forgot-password', [
            'as' => 'account-forgot-password-post',
            'uses' => 'AccountController@postForgotPassword'
        ]);


    });


    /*
    * Forgot password (GET)
    *
    * */
    Route::get('/account/forgot-password', [
       'as' => 'account-forgot-password',
        'uses' => 'AccountController@getForgotPassword'
    ]);


    /*
     *  Recover password (GET)
     *
     * */
    Route::get('/account/recover/{code}', [
        'as' => 'account-recover',
        'uses' => 'AccountController@getRecover'
    ]);

    /*
    * Sign in (GET)
    *
    * */
    Route::get('/account/sign-in', [
        'as' => 'account-sign-in',
        'uses' => 'AccountController@getSignIn'
    ]);

    /*
     * Create account (GET)
     *
     * */
    Route::get('/account/create', array(
        'as' => 'account-create',
        'uses' => 'AccountController@getCreate'
    ));

    Route::get('/account/activate/{code}', [
        'as' => 'account-activate',
        'uses' => 'AccountController@getActivate'
    ]);
});
