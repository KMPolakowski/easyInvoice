<?php

namespace App\Observers;

use App\Item;

use Elasticsearch\ClientBuilder;

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
        $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $item->user_id . "." . $item->Invoice->number,
            'body' => [
                    "script" => "ctx_source.items.add(params.item)",
                    "params" => [
                        "item" => [
                        "pos_num" => $item->pos_num,
                        "descr" => $item->descr,
                        "quantity" => $item->quantity,
                        "price" => $item->price,
                        "amount" => $item->amount,
                        "me" => $item->me
                        ]
                    ]
            ]
        ];

        app(ClientBuilder::class)->update($params);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(Item $item)
    {
        $params = [
            'index' => 'invoice',
            'type' => "invoice",
            'id' => $item->user_id . "." . $item->invoice_id,
            'body' => [
                'doc' => [
                    "item" => [
                        "pos_num" => $item->pos_num,
                        "descr" => $item->descr,
                        "quantity" => $item->quantity,
                        "price" => $item->price,
                        "amount" => $item->amount,
                        "me" => $item->me
                    ]
                ]
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
