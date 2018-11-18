<?php

namespace App\Observers;

use App\Invoice;
use App\Payment_condition;

use Elasticsearch\ClientBuilder;

class InvoiceObserver
{
    public function __construct()
    {
    }
    /**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(Invoice $invoice)
    {
        $invoice = Invoice::find($invoice->id);

        $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $invoice->user_id . "." . $invoice->number,
            'body' => [
                "number" => $invoice->number
            ]
        ];

        app(ClientBuilder::class)->index($params);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(Invoice $invoice)
    {
        if ($invoice->Receiver) {
            $receiver = $invoice->Receiver;
            $doc["receiver"]["name"] = $receiver->name;
            $doc["receiver"]["street"] = $receiver->street;
            $doc["receiver"]["zip_code"] = $receiver->zip_code;
            $doc["receiver"]["house_number"] = $receiver->house_number;
            $doc["receiver"]["vat_number"] = $receiver->vat_number;
        }
        
        if ($invoice->Issuer) {
            $issuer = $invoice->Issuer;
            $doc["issuer"]["name"] = $issuer->name;
            $doc["issuer"]["street"] = $issuer->street;
            $doc["issuer"]["zip_code"] = $issuer->zip_code;
            $doc["issuer"]["house_number"] = $issuer->house_number;
            $doc["issuer"]["vat_number"] = $issuer->vat_number;
        }

        if ($invoice->Payment_condition) {
            $payment = $invoice->Payment_condition;
            $doc["payment"]["days"] = $payment->days;
            $doc["payment"]["has_skonto"] = $payment->has_skonto;
            $doc["payment"]["days_skonto"] = $payment->days_skonto;
            $doc["payment"]["percent_skonto"] = $payment->percent_skonto;
        }

        if ($invoice->Contact_info) {
            $contact = $invoice->Contact_info;
            $doc["contact"]["tel"] = $contact->tel;
            $doc["contact"]["email"] = $contact->email;
            $doc["contact"]["web"] = $contact->web;
        }
        
        $doc = array_merge($doc, ["date" => $invoice->date,
        "number" => $invoice->number,
        "topic" => $invoice->topic,
        "street" => $invoice->street,
        "house_number" => $invoice->house_number,
        "zip_code" => $invoice->zip_code,
        "netto_sum" => $invoice->netto_sum,
        "vat_percentage" => $invoice->vat_percentage,
        "vat_sum" => $invoice->vat_sum,
        "brutto_sum" => $invoice->brutto_sum]);
            
        $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $invoice->user_id . "." . $invoice->number,
            'body' => [
                'doc' => $doc
            ]
        ];

        app(ClientBuilder::class)->update($params);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */

    public function deleted(Invoice $invoice)
    {
        $params = [
            "index" => "invoice",
            "type" => "invoice",
            "id" => $invoice->user_id . "." . $invoice->number,
        ];

        app(ClientBuilder::class)->delete($params);
    }
}
