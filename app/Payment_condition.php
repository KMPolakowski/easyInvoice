<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_condition extends Model
{
    protected $table = 'payment';

    public $timestamps = false;

    public function Invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
