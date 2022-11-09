<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i=1;$i<50;$i++){
            User::create([
            'id'=>$i,
            'name'=>$i.'太郎',
            'email'=>$i.'example@com',
            'password'=>Hash::make('abcdefghi'),
        ]);

        }
    }
}
