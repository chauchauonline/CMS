<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middlewareGroups' => 'web', 'domain' => env('DOMAIN')],function(){
    Route::get('/', [
            'as' => 'site.index',
            'uses'  => 'SiteController@index'
    ]);
    Route::get('/contact', [
            'as' => 'site.contact',
            'uses'  => 'SiteController@contact'
    ]);
    Route::post('/contact', [
            'as'  => 'site.save_contact',
            'uses'   => 'SiteController@save_contact'
    ]);
    Route::get('/members', [
            'as' => 'site.members',
            'uses'  => 'SiteController@get_all_members'
    ]);
    Route::get('/gioi-thieu/{slug}', [
            'as' => 'site.show_page',
            'uses'  => 'SiteController@show_page'
    ]);
    Route::get('/gioi-thieu', [
            'as' => 'site.about',
            'uses' => 'SiteController@about'
    ]);
    Route::get('/members/details/{id}', [
            'as' => 'site.members.details',
            'uses'  => 'SiteController@member_details'
    ]);
    Route::get('/tim-kiem', [
            'as' => 'site.search',
            'uses'  => 'SiteController@search'
    ]);
    Route::get('/hoat-dong', [
            'as' => 'site.articles',
            'uses'  => 'SiteController@show_all_articles'
    ]);
    Route::get('/hoat-dong/chi-tiet/{article_id}', [
            'as' => 'site.articles.details',
            'uses'  => 'SiteController@show_article_details'
    ]);
    // Login, Register
    Route::get('login', [
            'as' => 'login',
            'uses' => 'AuthController@login'
    ]);
    Route::post('login', [
            'as' => 'login',
            'uses' => 'AuthController@processLogin'
    ]);
    Route::get('register', [
            'as' => 'register',
            'uses' => 'AuthController@register'
    ]);
    Route::post('register', [
            'as' => 'register',
            'uses' => 'AuthController@processRegistration'
    ]);
    Route::get('logout', function() {
        Sentinel::logout();
        return Redirect::to('/');
    });

    Route::get('activate/{id}/{code}', function($id, $code)
    {
        $user = Sentinel::findById($id);
        if ( ! Activation::complete($user, $code))
        {
            return Redirect::to("login")->withErrors('Mã kích hoạt không hợp lệ.');
        }
        return Redirect::to('login')->withSuccess('Tài khoản đã được kích hoạt.');
    })->where('id', '\d+');

    Route::get('reset', [
            'as' => 'reset',
            'uses' => 'AuthController@resetPassword'
    ]);

    Route::post('reset', [
            'as' => 'reset.send.code',
            'uses' => 'AuthController@sendCodeResetPassword'
    ]);

    Route::get('reset/{id}/{code}', [
            'as' => 'reset.process',
            'uses' => 'AuthController@processResetPassword'
    ])->where('id', '\d+');

    Route::post('reset/{id}/{code}', [
            'as' => 'reset.confirm.new.password',
            'uses' => 'AuthController@confirmNewPassword'
    ])->where('id', '\d+');

    Route::get('account', function() {
        $user = Sentinel::getUser();
        $persistence = Sentinel::getPersistenceRepository();
        return View::make('cms::sentinel.account', compact('user', 'persistence'));
    });
});

