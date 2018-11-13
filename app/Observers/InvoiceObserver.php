<?php

namespace App\Observers;

use App\Invoice;

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
        if (!$invoice->draft) {
            $items = $invoice->Item();
            $receiver = $invoice->Receiver()->get();
            $payment = $invoice->Payment_condition()->get();
            

            dd($items);

            $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $invoice->user_id . "." . $invoice->number,
            'body' => [
                'doc' => [
                    "date" => $invoice->date,
                    "number" => $invoice->number,
                    "topic" => $invoice->topic,
                    "street" => $invoice->street,
                    "house_number" => $invoice->house_number,
                    "zip_code" => $invoice->zip_code,
                    "netto_sum" => $invoice->netto_sum,
                    "vat_percentage" => $invoice->vat_percentage,
                    "vat_sum" => $invoice->vat_sum,
                    "brutto_sum" => $invoice->brutto_sum,
                    "info" => $invoice->info,
                    "item" => [
                        "pos_num" => $items->pos_num,
                        "descr" => $items->descr,
                        "quantity" => $items->quantity,
                        "price" => $items->price,
                        "amount" => $items->amount,
                        "me" => $items->me
                    ],
                    "receiver" => [
                        "name" => $reciver->name,
                        "street" => $receiver->street,
                        "zip_code" => $receiver->zip_code,
                        "house_number" => $receiver->house_number,
                        "vat_number" => $receiver->vat_number
                    ],
                    "payment_condition" => [
                        "days" => $payment->days,
                        "has_skonto" => $payment->has_skonto
                    ]
                ]
            ]
        ];

            app(ClientBuilder::class)->update($params);
        }
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
