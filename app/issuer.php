<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class issuer extends Model
{
    protected $table = 'issuer';

    public $timestamps = false;

    public function Invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
