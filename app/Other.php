<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    public function admin()
    {
    	return $this->belongsTo('App\User', 'add_by');
    }
}
