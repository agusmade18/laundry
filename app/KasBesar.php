<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KasBesar extends Model
{
    //
	public function admin()
  {
  	return $this->belongsTo('App\User', 'add_by');
  }
}
