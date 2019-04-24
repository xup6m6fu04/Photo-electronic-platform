<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function createOrder($transaction_id, $products)
    {
        foreach ($products as $product) {
            $this->orderRepository->insert([
                'transaction_id' => $transaction_id,
                'user_email'     => Auth::user()->email,
                'product_id'     => $product->product_id,
                'price'          => $product->price,
                'count'          => 1 // 目前無法指定數量，畢竟寫真
            ]);
        }
    }

    public function getOrders($args = [], $all = true)
    {
        return $this->orderRepository->getOrders($args, $all);
    }
}