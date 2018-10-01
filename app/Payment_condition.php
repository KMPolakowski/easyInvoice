<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_condition extends Model
{
    protected $table = 'payment_condition';

    public $timestamps = true;

    public function Invoice()
    {
        return $this->hasMany('App\Invoice');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
