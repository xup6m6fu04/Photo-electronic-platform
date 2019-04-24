<?php

namespace App\Repositories;

use App\Cart;
use Illuminate\Support\Facades\DB;

class CartRepository
{
    public function insert($args)
    {
        return Cart::create($args);
    }

    public function delete($args)
    {
        $carts = $this->getCarts($args);
        foreach ($carts as $cart) {
            $cart->delete();
        }

        return ['type' => true];
    }

    public function getCarts($args = [], $all = true)
    {
        $defaults = [
            'start_index' => 0,
            'order_by'    => 'created_at',
            'sort'        => 'desc',
            'count'       => array_get($args, 'count', 100000),
        ];

        $args = $args + $defaults;
        $query = Cart::query();

        if ($id           = array_get($args, 'id',           false)) $query->Id($id);
        if ($user_email   = array_get($args, 'user_email',   false)) $query->UserEmail($user_email);
        if ($product_id   = array_get($args, 'product_id',   false)) $query->ProductId($product_id);


        $query->orderBy($args['order_by'], $args['sort'])
              ->skip($args['start_index'])
              ->take($args['count']);

        return ($all) ? $query->get() : $query;
    }

    public function getCartsJoinProducts($email)
    {
        return DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.product_id')
            ->select('products.*')
            ->where('user_email', $email)
            ->get();
    }
}