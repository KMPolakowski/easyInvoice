<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class receiver extends Model
{
    protected $table = 'receiver';

    public $timestamps = false;

    public function Invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
