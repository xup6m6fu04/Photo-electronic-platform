<?php

namespace App\Services;

use App\Product;
use App\Repositories\TransactionRepository;
use App\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    protected $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function createTransaction($args)
    {
        return $this->transactionRepository->insert($args);
    }

    public function cancelTransaction($args = [])
    {
        if (empty($args)) {
            $args['user_email'] = Auth::user()->email;
            $args['status'] = Transaction::STATUS_CREATE;
        }

        $transactions = $this->transactionRepository->getTransactions($args);

        foreach ($transactions as $transaction) {
            $transaction->status = Transaction::STATUS_CANCEL;
            $transaction->save();
        }
    }

    public function getTransactionsByStatus($status, $all = true)
    {
        $transactions = $this->transactionRepository->getTransactions([
            'status'     => $status
        ], $all);

        return $transactions;
    }

    public function getTransactions($status = '', $all = true)
    {
        $transactions = $this->transactionRepository->getTransactions([
            'user_email' => Auth::user()->email,
            'status'     => $status
        ], $all);

        return $transactions;
    }

    public function getTransactionsByParams($args, $all = true)
    {
        $transactions = $this->transactionRepository->getTransactions($args, $all);

        return $transactions;
    }

    public function getTransactionByTransactionId($transaction_id, $all = true)
    {
        $transactions = $this->transactionRepository->getTransactions([
            'transaction_id' => $transaction_id,
        ], $all);

        return $transactions;
    }

    public function getTransactionsDetail($args = [], $status = '')
    {
        return $this->transactionRepository->getTransactionsDetail($args, $status);
    }
}