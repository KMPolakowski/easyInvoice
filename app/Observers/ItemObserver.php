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
        if (isset($item->user_id, $item->invoice_id)) {
            $invoice = Invoice::find($item->invoice_id)->first();
            $items = Item::where(["invoice_id" => $invoice->id])->get()->toArray();
            $params = [
            'index' => 'invoice',
            'type' => "invoice",
            "id" => $item->user_id . "." . $invoice->number,
            'body' => [
                    "doc" => [
                        "items" => $items
                    ]
            ]
        ];

            dump($params);
            app(ClientBuilder::class)->update($params);
        }
    }

    /**
     * Handle the User "updated" event
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(Item $item)
    {
        if (isset($item->user_id, $item->invoice_id)) {
            $invoice = Invoice::find($item->invoice_id)->first();
            $items = Item::where(["invoice_id" => $invoice->id])->get()->toArray();
            $params = [
            'index' => 'invoice',
            'type' => "invoice",
            "id" => $item->user_id . "." . $invoice->number,
            'body' => [
                    "doc" => [
                        "items" => $items
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

    public function deleted(Item $item)
    {
        if (isset($item->user_id, $item->invoice_id)) {
            $invoice = Invoice::find($item->invoice_id)->first();
            $items = Item::where(["invoice_id" => $invoice->id])->get()->toArray();
            $params = [
            'index' => 'invoice',
            'type' => "invoice",
            "id" => $item->user_id . "." . $invoice->number,
            'body' => [
                    "doc" => [
                        "items" => $items
                    ]
            ]
        ];
            app(ClientBuilder::class)->update($params);
        }
    }
}
