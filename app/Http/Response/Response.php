<?php


namespace App\Http\Response;

class Response
{
    public function __construct()
    {
         return new JsonResponse(["data"], 200);
    }
}
