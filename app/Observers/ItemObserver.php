<?php

namespace App\Observers;

use App\Item;

use Elasticsearch\ClientBuilder;
use App\Invoice;

class ItemObserver
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
    public function created(Item $item)
    {
        dump("c");
        if (isset($item->user_id, $item->invoice_id)) {
            $invoiceNumber = Invoice::find($item->invoice_id)->number;
            $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $item->user_id . "." . $invoiceNumber,
            'body' => [
                    "script" => "ctx._source.items.add(params)",
                    "params" => "asd"
            ]
        ];

            app(ClientBuilder::class)->update($params);
        }
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(Item $item)
    {
        dump("u");
        $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $item->user_id . "." . $item->invoice_id,
            'body' => [
                'doc' => [
                    // "item" => [
                    //     "pos_num" => $item->pos_num,
                    //     "descr" => $item->descr,
                    //     "quantity" => $item->quantity,
                    //     "price" => $item->price,
                    //     "amount" => $item->amount,
                    //     "me" => $item->me
                    // ]
                ]
            ]
        ];

        dd(app(ClientBuilder::class)->update($params));
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */

    public function deleted(Item $item)
    {
        $params = [
            "index" => "invoice",
            "type" => "invoice",
            "id" => $invoice->user_id . "." . $invoice->number,
        ];

        app(ClientBuilder::class)->delete($params);
    }
}
