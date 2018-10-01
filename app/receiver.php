<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receiver extends Model
{
    protected $table = 'receiver';

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
