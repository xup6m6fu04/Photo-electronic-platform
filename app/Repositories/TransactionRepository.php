<?php

namespace App\Repositories;

use App\Transaction;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    public function insert($args)
    {
        return Transaction::create($args);
    }

    public function getTransactions($args = [], $all = true)
    {
        $defaults = [
            'start_index' => 0,
            'order_by'    => 'created_at',
            'sort'        => 'desc',
            'count'       => array_get($args, 'count', 100000),
        ];

        $args = $args + $defaults;
        $query = Transaction::query();

        if ($id             = array_get($args, 'id',             false)) $query->Id($id);
        if ($transaction_id = array_get($args, 'transaction_id', false)) $query->TransactionId($transaction_id);
        if ($user_email     = array_get($args, 'user_email',     false)) $query->UserEmail($user_email);
        if ($status         = array_get($args, 'status',         false)) $query->Status($status);
        if ($account        = array_get($args, 'account',        false)) $query->Account($account);

        $query->orderBy($args['order_by'], $args['sort'])
              ->skip($args['start_index'])
              ->take($args['count']);

        return ($all) ? $query->get() : $query;
    }

    public function getTransactionsDetail($args, $status = '')
    {
        $query = DB::table('transactions')
            ->join('orders', 'transactions.transaction_id', '=', 'orders.transaction_id')
            ->join('products', 'orders.product_id', '=', 'products.product_id')
            ->select(
                'transactions.transaction_id',
                'transactions.user_email',
                'transactions.status',
                'transactions.account',
                'transactions.created_at',
                'orders.product_id',
                'orders.price',
                'orders.count',
                'products.product_name',
                'products.download_url',
                'products.page',
                'products.actor_name'
            );
            if ($user_email = array_get($args, 'user_email', false)) {
                $query = $query->where('transactions.user_email', $user_email);
            }
            if ($transaction_id = array_get($args, 'transaction_id', false)) {
                $query = $query->where('transactions.transaction_id', $transaction_id);
            }


        if ($status) {
            $query = $query->where('transactions.status', $status);
        }

        return $query->orderBy('transactions.created_at', 'desc')->get();
    }
}