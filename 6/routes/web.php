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

Auth::routes();
Route::get('/', 'HomeController@index')->name('index');//(b)
Route::group(['prefix'=>'tweets'],function(){
    Route::get('/','Tweets\TweetController@index')->name('tweets.index')->middleware('auth');
    Route::post('/create','Tweets\TweetController@create')->name('tweets.create')->middleware('auth');
    Route::get('/delete/{post}','Tweets\TweetController@delete')->name('tweets.delete')->middleware('auth');
});

Route::get('/home','HomeController@home')->name('home');
// Route::get('/', 'HomeController@index')->name('index');//(a)

//1)個人メモ:RedirectIfAuthenticated>if (Auth::guard($guard)->check()) {return redirect('/XXXXX');}→ログインしてない状態で
//メインページにアクセスするとXXXに飛ばされるのでXXXを任意のページ名に変更する。
//2)個人メモ:ログインした後、「logged in!」と表示されるのは、
//以下の記述があるため。なので、これを削除すればOK
// Route::get('/home', 'HomeController@index')->name('home');
//3)個人メモ：HomeController>indexにAuth::check()===falseの
//場合のリダイレクト先(ログインページ)を追加
//4)個人メモ：Logoutすると/homeにリダイレクトされ、404となるので、HomeControllerに/homeにアクセスしたらツイート画面にリダイレクトするよう追記（他にいいほうほうがありそう）
//- Route::get('/', 'HomeController@index')->name('index')を(a)でなく(b)に移動したら、logoutした後loginページにリダイレクトされるようになった。なぜか不明
