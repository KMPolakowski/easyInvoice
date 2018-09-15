<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    protected $table = 'user';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];


    public function Invoices()
    {
        return $this->hasMany('App\Invoice');
    }

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

    public function Payment_conditions()
    {
        return $this->hasMany('App\Payment_condition');
    }

    public function Receivers()
    {
        return $this->hasMany('App\Receiver');
    }
}
