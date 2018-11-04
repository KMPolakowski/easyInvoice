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
        $item = Item::find($item->id);

        $params = [
            'index' => 'item',
            'type' => "item",
            'id' => $item->user_id . "." . $item->external_id,
            'body' => [
                "descr" => $item->descr
            ]
        ];

        // dump("c");
        // dump($params);
        app(ClientBuilder::class)->index($params);
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
            'index' => 'item',
            'type' => "item",
            'id' => $item->user_id . "." . $item->external_id,
            'body' => [
                'doc' => [
                    'descr' => $item->descr
                ]
            ]
        ];

        // dump("u");
        // dump($params);
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
            'index' => 'item',
            'type' => "item",
            'id' => $item->user_id . "." . $item->external_id,
        ];

        $response = $client->delete($params);
    }
}
