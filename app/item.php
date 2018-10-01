<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item extends Model
{
    protected $table = 'item';

    public $timestamps = true;

    public function Invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
