<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=1;$i<40;$i++){
            Post::create([
            'user_id'=>mt_rand(1,30),
            'body'=>$i.'ひふみよいまわりてめくる',
            'created_at'=>now(),
            'updated_at'=>now(),
            ]);
        }
    }
}
