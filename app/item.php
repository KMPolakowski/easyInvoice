<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'item';

    public $timestamps = true;

    public function Invoice()
    {
        return $this->belongsToMany('App\Invoice')->withTimestamps();
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
