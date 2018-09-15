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

    public function Contact_info()
    {
        return $this->hasOne('App\Contact_info');
    }

    public function Issuer()
    {
        return $this->hasOne('App\Issuer');
    }

    public function Items()
    {
        return $this->hasMany('App\Item');
    }

    public function Payment_condition()
    {
        return $this->hasOne('App\Payment_condition');
    }

    public function Receiver()
    {
        return $this->hasOne('App\Receiver');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
