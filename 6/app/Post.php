<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{

    protected $fillable=['user_id','body','created_at','updated_at','deleted_at'];

    public static $rules=array(
        'post'=>['required','max:255']
    );

    public function user(){

        return $this->belongsTo('App\User');
    }

}
