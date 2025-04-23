<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdeaFeedBack extends Model
{
    protected $fillable=['comment','user_id','link','type','idea_id'];



    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }


  

}
