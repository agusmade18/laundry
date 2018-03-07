<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
  public function admin()
  {
      return $this->belongsTo('App\User', 'id_admin');
  }

  public function addby()
  {
      return $this->belongsTo('App\User', 'add_by');
  }
}
