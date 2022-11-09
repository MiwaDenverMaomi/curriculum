<?php

namespace App\Http\Controllers\Tweets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Http\Controllers\Controller;
use App\Exception;
use App\Post;
use Carbon\Carbon;
use Auth;
class TweetController extends Controller
{
    public function index(){
        \Log::info('index');

        try{
        $posts=Post::with('user')->orderby('updated_at','desc')->orderby('id','desc')->get();

        foreach($posts as $post){
            $post->updated_at=Carbon::createFromFormat('Y-m-d H:i:s',$post->updated_at);
        }

        }catch(Exception $e){
            \Log::debug('DB Error:'.$e);
            report($e);//詳細エラー表示
            session()->flash('flash_message_error', Lang::get('messages.DB error'));
        }

        \Log::debug($posts);
        return view('tweets.index',compact('posts'));
    }

    public function create(Request $request){
        \Log::info('create');
        \Log::debug($request->post);
        $this->validate($request,Post::$rules);

        try{
        Post::create(['user_id'=>Auth::id(),
                'body'=>$request->post
                ]);
        }catch(Exception $e){
          \Log::debug('DB Error:'.$e);
            report($e);//詳細エラー表示
            session()->flash('flash_message_error', Lang::get('messages.DB error'));
        }

        \Log::info('redierct...');
        return redirect()->route('tweets.index');
    }

    public function delete(Post $post){
        \Log::info('delete');
        \Log::debug($post);
         try{
              $post->delete();
        }catch(Exception $e){
          \Log::debug('DB Error:'.$e);
            report($e);//詳細エラー表示
            session()->flash('flash_message_delete_failed', Lang::get('messages.Delete Failed'));
        }

         return redirect()->route('tweets.index');
    }
}
