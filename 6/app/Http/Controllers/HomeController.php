<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::check()){
            return redirect()->route('tweets.index');
        }
        return redirect('/login');
    }

    public function home()
    {

        //会員登録・ログアウトすると/homeにリダイレクトされ404となるのでここで
        //強制的にツイート画面にリダイレクト
        if(Auth::check()){
            return redirect()->route('tweets.index');
        }
        return redirect('/login');
    }
}
