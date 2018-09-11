<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank_detail extends Model
{
    protected $table = 'bank_detail';

    public $timestamps = false;

    public function Invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
