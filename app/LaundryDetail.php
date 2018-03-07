<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaundryDetail extends Model
{
    //
	public function barang()
  {
  	return $this->belongsTo('App\BarangMaster', 'id_barang');
  }
}
