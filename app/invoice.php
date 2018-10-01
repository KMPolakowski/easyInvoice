<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoice';

    public function Bank_detail()
    {
        return $this->belongsTo('App\Bank_detail');
    }

    public function Contact_info()
    {
        return $this->belongsTo('App\Contact_info');
    }

    public function Issuer()
    {
        return $this->belongsTo('App\Issuer');
    }

    public function Item()
    {
        return $this->hasMany('App\Item');
    }

    public function Payment_condition()
    {
        return $this->belongsTo('App\Payment_condition');
    }

    public function Receiver()
    {
        return $this->belongsTo('App\Receiver');
    }

    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
