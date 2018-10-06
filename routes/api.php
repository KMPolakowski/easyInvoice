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

use App\Service\Invoice\PrintInvoiceService;

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

//feature: send per email

$router->get('/', function () use ($router) {
    return $router->app->version();
});


//CRUDS for each model

//invoice
//GET PDF


// $router->post('/invoice/print', function () {
//     $print = new PrintInvoiceService();
// });

$router->post('/invoice/print', 'InvoiceController@printNew');
$router->get('/invoice/print/{number}', 'InvoiceController@printExisting');

$router->get('/invoice/draft/{number}', 'InvoiceController@makeDraft');
$router->get('/invoice/finalize/{number}', 'InvoiceController@makeInvoice');

$router->get('/invoices', 'InvoiceController@index');

//receiver
//search

//issuer
//search

//item
//search
