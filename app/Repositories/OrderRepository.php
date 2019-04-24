<?php

namespace App\Repositories;

use App\Order;
use Log;

class OrderRepository
{
    public function insert($args)
    {
        return Order::create($args);
    }

    public function getOrders($args = [], $all = true)
    {
        $defaults = [
            'start_index' => 0,
            'order_by'    => 'created_at',
            'sort'        => 'desc',
            'count'       => array_get($args, 'count', 100000),
        ];

        $args = $args + $defaults;
        $query = Order::query();

        if ($id             = array_get($args, 'id',             false)) $query->Id($id);
        if ($transaction_id = array_get($args, 'transaction_id', false)) $query->TransactionId($transaction_id);
        if ($product_id     = array_get($args, 'product_id',     false)) $query->ProductId($product_id);
        if ($price          = array_get($args, 'price',          false)) $query->Price($price);

        $query->orderBy($args['order_by'], $args['sort'])
              ->skip($args['start_index'])
              ->take($args['count']);

        return ($all) ? $query->get() : $query;
    }
}