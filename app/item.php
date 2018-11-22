<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';

    public $timestamps = true;

    public function Invoice()
    {
        return $this->hasOne('App\Invoice');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
