<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * '/' に GET メソッドでHTTPリクエストが来ると、 view('welcome') が実行される。
 * 'welcome' とは、 resources/views/welcome.blade.php ファイル。
 * resources/views/ フォルダにある welcome という名前のついた拡張子 .blade.php のファイルが表示される。
 */

Route::get('/', 'PhotosController@index');

// ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

//authミドルウェアを指定することで認証を必要とするようになる
//['only' => ['index', 'show']]はControllerの７つのアクションのうちindex（ユーザー一覧）
//とshow(ユーザー詳細)だけに絞り込んでいる
//store登録　destroy削除
Route::group(['middleware' => ['auth']],function(){
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });
    
    Route::resource('users','UsersController',['only' => ['index','show']]);
    Route::resource('photos','PhotosController', ['only' => ['store', 'destroy']]);
    
});