<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\User;
use Elasticsearch\ClientBuilder;

class Controller extends BaseController
{
    public function getUser()
    {
        return app(User::class);
    }

    public function getESClient()
    {
        return app(ClientBuilder::class);
    }
}
