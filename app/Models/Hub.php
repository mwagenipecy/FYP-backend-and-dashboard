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



  public function supervisor()
  {
      return $this->belongsTo(User::class, 'supervisor_id');
  }

  
 

  /**
   * Get the user who last updated the hub.
   */
  public function updater()
  {
      return $this->belongsTo(User::class, 'updated_by');
  }

  /**
   * Get the projects associated with this hub.
   */
  public function projects()
  {
      return $this->hasMany(Project::class);
  }

  /**
   * Get the project count for this hub.
   */
  public function getProjectCountAttribute()
  {
      return $this->projects()->count();
  }



  public function users()
  {
      return $this->hasMany(User::class);
  }


  public function activities()
  {
      return $this->hasMany(Activity::class);
  }


}
