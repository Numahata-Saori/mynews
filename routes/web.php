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

Route::get('/', function () {
    return view('welcome');
});

//[‘prefix’ => ‘admin’] の設定をその次の無名関数function(){}の中のすべてのRoutingの設定に適用させる
//無名関数function(){} の中の設定のURLを http://XXXXXX.jp/admin/ から始まるURL にしている

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    
    //http://XXXXXX.jp/admin/news/create にアクセスが来たら、Controller Admin\NewsController のAction addに渡す
    //GETリクエストは指定した URLの内容を取り出すための要求で、最も基本的な HTTPメソッド、ブラウザから URLを入力して Webページを開くときには、GETメソッドの HTTPリクエストを送っている
    //POSTは URLに対して情報を要求するだけでなく、クライアントからさまざまなデータを送信することができる、主にデータを更新するような処理に使われる
    //GETの場合は add Actionを、 POSTの場合は create Action を呼び出す
    
    Route::get('news/create', 'Admin\NewsController@add');
    Route::post('news/create', 'Admin\NewsController@create');
    Route::get('news', 'Admin\NewsController@index');
    Route::get('news/edit', 'Admin\NewsController@edit');
    Route::post('news/edit', 'Admin\NewsController@update');
    Route::get('news/delete', 'Admin\NewsController@delete');
     
    Route::get('profile/create', 'Admin\ProfileController@add');
    Route::post('profile/create', 'Admin\ProfileController@create');
    Route::get('profile', 'Admin\ProfileController@index');
    Route::get('profile/edit', 'Admin\ProfileController@edit');
    Route::post('profile/edit', 'Admin\ProfileController@update');
    Route::get('profile/delete', 'Admin\ProfileController@delete');
});

//Route::get('XXX', 'AAAController@bbb');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'NewsController@index');

Route::get('/profile', 'ProfileController@index');

?>


