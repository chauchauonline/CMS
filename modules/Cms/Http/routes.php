<?php

// Route cần phải đăng nhập

Route::group(['middleware' => ['web', 'sentinel.login'], 'domain' => 'cms.' . env('DOMAIN'), 'namespace' => 'Modules\Cms\Http\Controllers'], function()
{
    View::composer('cms::partial.sidebar', function($view) {
        $user = Sentinel::getUser();
        $unreply_contact = Modules\Cms\Entities\ContactForm::Where('status', '=', Config::get('constants.UNREPLY'))->count();
        $unread_sent = Modules\Cms\Entities\Message::where('status', '=', 'Sent')
                                                    ->Where('from', '=', $user->id)
                                                    ->Where('read', '=', Config::get('constants.UNREAD'))
                                                    ->count();
        $view->with('user', $user);
        $view->with('unreply_contact', $unreply_contact);
        $view->with('unread_sent', $unread_sent);
    });

    View::composer('cms::partial.header', function($view) {
        $view->with('user', Sentinel::getUser());
    });

    Route::get('/', 'CmsController@index');

    Route::get('account', function() {
        $user = Sentinel::getUser();
        $persistence = Sentinel::getPersistenceRepository();
        return View::make('cms::sentinel.account', compact('user', 'persistence'));
    });

    Route::get('logout', function() {
        Sentinel::logout();
        return Redirect::to('/');
    });

    Route::group(['prefix' => 'members'], function () {
        Route::get('/', [
                'as' => 'users.index',
                'uses' =>  'UserController@index'
        ]);
        Route::get('{id}/show', [
                'as' => 'users.show',
                'uses' =>  'UserController@show'
        ]);
        Route::get('/{id}/edit', [
                'as' => 'users.edit',
                'uses' => 'UserController@edit'
        ]);
        Route::patch('/{id}/edit', [
                'as' => 'users.update',
                'uses' => 'UserController@update'
        ]);
        Route::post('/upload', [
                'as' => 'users.upload',
                'uses' => 'UserController@upload'
        ]);
    });

    Route::group(['prefix' => 'funds'], function () {
        Route::get('/', [
                'as' => 'funds.index',
                'uses' => 'FundController@index'
        ]);
        Route::get('/{id}/show',[
                'as' =>'funds.show',
                'uses' =>'FundController@show'
        ]);
    });

    Route::group(['prefix' => 'fund_members'], function () {
        Route::get('/history', [
                'as' => 'fund_members.history',
                'uses' => 'FundMemberController@history'
        ]);
    });
});

// Route cần đăng nhập và có quyền admin
Route::group(['middleware' => ['web', 'sentinel.login', 'inRole', 'hasAccess'], 'inRole'  => ['admin'], 'hasAccess' =>['admin'],
        'domain' => 'cms.' . env('DOMAIN'), 'namespace' => 'Modules\Cms\Http\Controllers'], function() {

    Route::group(['prefix' => 'articles'], function () {
        Route::get('/', [
            'as' => 'articles.index',
            'uses' => 'ArticleController@index'
        ]);
        Route::get('create',[
            'as' => 'articles.create',
            'uses' => 'ArticleController@create'
        ]);
        Route::post('create',[
            'as' => 'articles.store',
            'uses' => 'ArticleController@store'
        ]);
        Route::get('/{id}/show',[
            'as' =>'articles.show',
            'uses' =>'ArticleController@show'
        ]);
        Route::get('/{id}/edit', [
            'as' => 'articles.edit',
            'uses' => 'ArticleController@edit'
        ]);
        Route::patch('/{id}/edit', [
            'as' => 'articles.update',
            'uses' => 'ArticleController@update'
        ]);
        Route::delete('/delete', [
                'as' => 'articles.delete',
                'uses' => 'ArticleController@destroy'
        ]);
    });

    Route::group(['prefix' => 'roles'], function () {
        Route::get('create', [
            'as' => 'roles.create',
            'uses' => 'RoleController@create'
        ]);
        Route::post('create', [
            'as' => 'roles.store',
            'uses' => 'RoleController@store'
        ]);
        Route::get('/', [
                'as' => 'roles.index',
                'uses' =>  'RoleController@index'
        ]);
        Route::get('{id}/show', [
                'as' => 'roles.show',
                'uses' =>  'RoleController@show'
        ]);
        Route::get('/{id}/edit', [
                'as' => 'roles.edit',
                'uses' => 'RoleController@edit'
        ]);
        Route::post('/{id}/edit', [
                'as' => 'roles.update',
                'uses' => 'RoleController@update'
        ]);
        Route::delete('/delete', [
                'as' => 'roles.delete',
                'uses' => 'RoleController@delete'
        ]);
    });

    Route::group(['prefix' => 'pages'], function () {
        Route::get('create', [
                'as' => 'pages.create',
                'uses' => 'PageController@create'
        ]);
        Route::post('create', [
                'as' => 'pages.store',
                'uses' => 'PageController@store'
        ]);
        Route::get('/', [
                'as' => 'pages.index',
                'uses' =>  'PageController@index'
        ]);
        Route::get('/{id}/show', [
                'as' => 'pages.show',
                'uses' => 'PageController@show'
        ]);
        Route::get('/{id}/edit', [
                'as' => 'pages.edit',
                'uses' => 'PageController@edit'
        ]);
        Route::patch('/{id}/edit', [
                'as' => 'pages.update',
                'uses' => 'PageController@update'
        ]);
        Route::delete('/delete', [
                'as' => 'pages.delete',
                'uses' => 'PageController@delete'
        ]);
        Route::post('/upload', [
                'as' => 'pages.upload',
                'uses' => 'PageController@upload'
        ]);
        Route::get('/change_image/{id}', [
                'as'  => 'pages.change_image',
                'uses' => 'PageController@change_image'
        ]);
    });

    Route::group(['prefix' => 'members'], function () {
        Route::delete('/delete', [
                'as' => 'users.delete',
                'uses' => 'UserController@delete',
        ]);
        Route::get('create', [
                'as' => 'users.create',
                'uses' => 'UserController@create',
        ]);
        Route::post('create', [
                'as' => 'users.store',
                'uses' => 'UserController@store',
        ]);
        Route::post('save-permission', [
                'as' => 'users.save_permission',
                'uses' => 'UserController@save_permission'
        ]);
        Route::get('/not-activated-members', [
                'as' => 'users.not_activated_members',
                'uses' =>  'UserController@get_not_activated_members'
        ]);
    });

    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', [
                'as' => 'messages.index',
                'uses' =>  'MessageController@index'
        ]);
        Route::get('/{id}/read', [
                'as' => 'messages.read',
                'uses' =>  'MessageController@read'
        ]);
        Route::get('compose', [
                'as' => 'messages.compose',
                'uses' => 'MessageController@compose'
        ]);
        Route::post('send', [
                'as' => 'messages.send',
                'uses' => 'MessageController@send'
        ]);
        Route::get('addStar', [
                'as' => 'messages.addStar',
                'uses' => 'MessageController@addStar'
        ]);
        Route::get('removeStar', [
                'as' => 'messages.removeStar',
                'uses' => 'MessageController@removeStar'
        ]);
        Route::get('delete', [
                'as' => 'messages.delete',
                'uses' => 'MessageController@delete'
        ]);
        Route::get('saveToDraft', [
                'as'  => 'messages.saveToDraft',
                'uses' => 'MessageController@saveToDraft'
        ]);
        Route::get('{id}/edit', [
                'as'  => 'messages.edit',
                'uses' => 'MessageController@edit'
        ]);
        Route::get('update', [
                'as'  => 'messages.updateDraft',
                'uses' => 'MessageController@updateDraft'
        ]);
    });

    Route::group(['prefix' => 'categories'], function () {
        Route::get('create', [
                'as' => 'categories.create',
                'uses' => 'CategoryController@create'
        ]);
        Route::post('create', [
                'as' => 'categories.store',
                'uses' => 'CategoryController@store'
        ]);
        Route::get('/', [
                'as' => 'categories.index',
                'uses' =>  'CategoryController@index'
        ]);
        Route::get('{id}/show', [
                'as' => 'categories.show',
                'uses' =>  'CategoryController@show'
        ]);
        Route::get('/{id}/edit', [
                'as' => 'categories.edit',
                'uses' => 'CategoryController@edit'
        ]);
        Route::patch('/{id}/edit', [
                'as' => 'categories.update',
                'uses' => 'CategoryController@update'
        ]);
        Route::delete('/delete', [
                'as' => 'categories.delete',
                'uses' => 'CategoryController@delete'
        ]);
        Route::get('generate_slug', [
                'as' => 'categories.generate_slug',
                'uses' => 'CategoryController@generate_slug'
        ]);
    });

    Route::group(['prefix' => 'contacts'], function () {
        Route::get('/', [
                'as' => 'contacts.index',
                'uses' =>  'ContactController@index'
        ]);
    });
    Route::group(['prefix' => 'companies'], function () {
        Route::get('create', [
                'as' => 'companies.create',
                'uses' => 'CompanyController@create'
        ]);
        Route::post('create', [
                'as' => 'companies.store',
                'uses' => 'CompanyController@store'
        ]);
        Route::get('', [
                'as' => 'companies.index',
                'uses' =>  'CompanyController@index'
        ]);
        Route::get('{id}/show', [
                'as' => 'companies.show',
                'uses' =>  'CompanyController@show'
        ]);
        Route::get('/{id}/edit', [
                'as' => 'companies.edit',
                'uses' => 'CompanyController@edit'
        ]);
        Route::patch('/{id}/edit', [
                'as' => 'companies.update',
                'uses' => 'CompanyController@update'
        ]);
        Route::delete('/delete', [
            'as' => 'companies.delete',
            'uses' => 'CompanyController@destroy'
        ]);
    });

    Route::group(['prefix' => 'funds'], function () {
        Route::get('create',[
                'as' => 'funds.create',
                'uses' => 'FundController@create'
        ]);
        Route::post('create',[
                'as' => 'funds.store',
                'uses' => 'FundController@store'
        ]);
        Route::get('/{id}/edit', [
                'as' => 'funds.edit',
                'uses' => 'FundController@edit'
        ]);
        Route::patch('/{id}/edit', [
                'as' => 'funds.update',
                'uses' => 'FundController@update'
        ]);
        Route::delete('/delete', [
                'as' => 'funds.delete',
                'uses' => 'FundController@delete'
        ]);
    });

    Route::group(['prefix' => 'fund_members'], function () {
        Route::post('update',[
                'as' => 'fund_members.update',
                'uses' => 'FundMemberController@update'
        ]);
        Route::get('/find', [
                'as' => 'fund_members.find',
                'uses' => 'FundMemberController@find'
        ]);
    });

    Route::group(['prefix' => 'total_fund'], function () {
        Route::get('/edit',[
                'as' => 'total_fund.edit',
                'uses' => 'TotalFundController@edit'
        ]);
        Route::patch('/{id}/edit',[
                'as' => 'total_fund.update',
                'uses' => 'TotalFundController@update'
        ]);
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', [
                'as' => 'settings.index',
                'uses' =>  'SettingController@index'
        ]);
        Route::get('{key}/edit', [
                'as' => 'settings.edit',
                'uses' => 'SettingController@edit'
        ]);
        Route::patch('{key}/edit', [
                'as' => 'settings.update',
                'uses' => 'SettingController@update'
        ]);
    });

    // route activate/lock member
    Route::get('activate/{id}', [
            'as' => 'activate',
            'uses' => 'AuthController@activate',
    ])->where('id', '\d+');

    Route::get('lock/{id}', [
            'as' => 'lock',
            'uses' => 'AuthController@lock'
    ])->where('id', '\d+');
});
// Route không cần đăng nhập
Route::group(['middleware' => 'web', 'domain' => 'cms.' . env('DOMAIN'), 'namespace' => 'Modules\Cms\Http\Controllers'], function()
{
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
});

