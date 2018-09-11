<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public function Bank_detail()
    {
        return $this->hasOne('App\Bank_detail');
    }
}
