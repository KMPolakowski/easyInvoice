<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class contact_info extends Model
{
    protected $table = 'contact_info';

    public $timestamps = false;

    public function Invoice()
    {
        return $this->belongsTo('App\Invoice');
    }
}
