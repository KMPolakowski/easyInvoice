<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class issuer extends Model
{
    protected $table = 'issuer';

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
