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

$router->get('/invoices', 'InvoiceController@index');

$router->post('/invoice/print', 'InvoiceController@printNew');
$router->get('/invoice/print/{number}', 'InvoiceController@printExisting');

$router->patch('/invoice/draft/{number}', 'InvoiceController@makeDraft');
$router->patch('/invoice/finalize/{number}', 'InvoiceController@makeInvoice');

$router->post('/invoice/create', 'InvoiceController@create');

$router->put('/invoice/receiver', 'InvoiceController@setReceiverById');
$router->post('/invoice/receiver', 'InvoiceController@setNewReceiver');

$router->put('/invoice/item', 'InvoiceController@setItemById');
$router->post('/invoice/item', 'InvoiceController@setNewItem');


$router->put('/invoice/payment', 'InvoiceController@setPaymentConditionById');
$router->post('/invoice/payment', 'InvoiceController@setNewPayment');


// $router->put('/invoice/bank', 'InvoiceController@setBankDetailbyId');
// $router->put('/invoice/contact', 'InvoiceController@setContactInfoById');
