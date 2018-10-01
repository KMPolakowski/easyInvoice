<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact_info extends Model
{
    protected $table = 'contact_info';

    public $timestamps = true;

    public function Invoice()
    {
        return $this->hasMany('App\Invoice');
    }

    public function User()
    {
        return $this->belongsTo('App\Invoice');
    }
}
