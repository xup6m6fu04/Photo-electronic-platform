<?php

namespace App\Repositories;

use App\Product;

class ProductRepository
{
    public function insert($args)
    {
        return Product::create($args);
    }

    public function edit($product_id, $args)
    {
        return Product::where('product_id', $product_id)->update($args);
    }

    public function getProducts($args = [], $all = true)
    {
        $defaults = [
            'start_index' => 0,
            'order_by'    => 'created_at',
            'sort'        => 'desc',
            'count'       => array_get($args, 'count', 100000),
        ];

        $args = $args + $defaults;
        $query = Product::query();

        if ($id           = array_get($args, 'id',           false)) $query->Id($id);
        if ($product_id   = array_get($args, 'product_id',   false)) $query->ProductId($product_id);
        if ($product_name = array_get($args, 'product_name', false)) $query->ProductName($product_name);
        if ($price        = array_get($args, 'price',        false)) $query->Price($price);
        if ($download_url = array_get($args, 'download_url', false)) $query->DownloadUrl($download_url);
        if ($buy_count    = array_get($args, 'buy_count',    false)) $query->BuyCount($buy_count);
        if ($page         = array_get($args, 'page',         false)) $query->Page($page);
        if ($actor_name   = array_get($args, 'actor_name',   false)) $query->ActorName($actor_name);
        if ($type         = array_get($args, 'type',         false)) $query->Type($type);
        if ($main_info    = array_get($args, 'main_info',    false)) $query->MainInfo($main_info);
        if ($sub_info     = array_get($args, 'sub_info',     false)) $query->SubInfo($sub_info);
        if ($preview1     = array_get($args, 'preview_1',    false)) $query->Preview1($preview1);
        if ($preview2     = array_get($args, 'preview_2',    false)) $query->Preview2($preview2);
        if ($preview3     = array_get($args, 'preview_3',    false)) $query->Preview3($preview3);
        if ($open         = array_get($args, 'open',         false)) $query->Open($open);

        $query->where('del', Product::DEL_N)
              ->orderBy($args['order_by'], $args['sort'])
              ->skip($args['start_index'])
              ->take($args['count']);

        return ($all) ? $query->get() : $query;
    }
}