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

/*
 * Unauthenticated group
 * */
Route::group(array('before' => 'guest'), function(){

    /*
     *
     * CSRF Protection
     *
     * */
    Route::group(array('before' => 'csrf'), function(){

        /*
     * Create account (POST)
     *
     * */
        Route::post('/account/create', array(
            'as' => 'account-create-post',
            'uses' => 'AccountController@postCreate'
        ));

    });

    /*
     * Create account (GET)
     *
     * */
    Route::get('/account/create', array(
        'as' => 'account-create',
        'uses' => 'AccountController@getCreate'
    ));
});
