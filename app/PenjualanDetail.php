<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    //
	public function barang()
  {
  	return $this->belongsTo('App\BrgJualMaster', 'id_brgjual');
  }
}
