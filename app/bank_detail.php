<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank_detail extends Model
{
    protected $table = 'bank_detail';

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
