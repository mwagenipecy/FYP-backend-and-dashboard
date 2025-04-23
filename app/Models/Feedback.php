<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{

    protected $fillable=['user_id','comment','table','identifier','idea_id'];


    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }

    
}
