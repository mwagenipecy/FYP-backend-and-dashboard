<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hub extends Model
{
    protected $fillable=
    [
    'name','address',
    'phone_number','email',
    'supervisor_id','status',
    'about','mission',
    'vision','description',
    'image',
    'created_by',
    'updated_by',


  ];
    


  public function creator()
  {
      return $this->belongsTo(User::class, 'created_by');
  }


}
