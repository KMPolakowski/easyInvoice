<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\User;

class Controller extends BaseController
{
    public function getUser()
    {
        return app(User::class);
    }
}
