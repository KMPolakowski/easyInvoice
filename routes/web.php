<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


// Models:

// invoice
// receiver
// issuer
// item
// payment
// bank_detail
// contact_info

// app (OAUTH 2.0)
// user (IDConnect | Laravel Auth)


$router->get('/', function () use ($router) {
    return $router->app->version();
});


//CRUDS for each model

//invoice
//GET PDF

$router->post('/generate_invoice_pdf', 'InvoiceController@generate_invoice_pdf');

//receiver
//search

//issuer
//search

//item
//search
















