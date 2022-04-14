<?php

namespace OhMyCod3\PeopleManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
  use HasFactory;

  
  public function planet(){
      return $this->belongsTo(Planet::class);
  }
  
}
