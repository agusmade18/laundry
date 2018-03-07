<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LaundryHeader extends Model
{
    //
    public function myCustomer()
    {
    	return $this->belongsTo('App\Customer', 'id_customer');
    }

    public function usr()
    {
    	return $this->belongsTo('App\User', 'admin');
    }
}
