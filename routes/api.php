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

$router->get('/invoices', 'InvoiceController@getInvoices');
$router->get('/invoice/{id}', 'InvoiceController@getInvoice');

$router->post('/invoice/print', 'InvoiceController@printNew');
$router->get('/invoice/print/{number}', 'InvoiceController@printExisting');

$router->patch('/invoice/draft/{number}', 'InvoiceController@makeDraft');
$router->patch('/invoice/finalize/{number}', 'InvoiceController@makeInvoice');

$router->put('/invoice/edit', 'InvoiceController@editDetails');

$router->post('/invoice/create', 'InvoiceController@create');

$router->patch('/invoice/receiver', 'InvoiceController@setReceiverById');
$router->post('/invoice/receiver', 'InvoiceController@setNewReceiver');

$router->patch('/invoice/{invoiceId}/item/{itemId}', 'InvoiceController@addItemById');
$router->post('/invoice/{invoiceId}/item', 'InvoiceController@addNewItem');
$router->post('/invoice/{invoiceId}/item/{itemId}/edit', 'InvoiceController@editItem');
$router->patch('/invoice/{invoiceId}/item', 'InvoiceController@seatItem');


$router->patch('/invoice/payment', 'InvoiceController@setPaymentConditionById');
$router->post('/invoice/payment', 'InvoiceController@setNewPayment');


// $router->put('/invoice/bank', 'InvoiceController@setBankDetailbyId');
// $router->put('/invoice/contact', 'InvoiceController@setContactInfoById');
