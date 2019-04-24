<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\TransactionService;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    protected $cartService;
    protected $transactionService;
    protected $orderService;

    public function __construct(CartService $cartService, TransactionService $transactionService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->transactionService = $transactionService;
        $this->orderService = $orderService;
    }

    public function pageCart()
    {
        $products = $this->cartService->getProductsInCart();
        $products = ($products) ? $products : [];
        $total_price = ($products) ? $products->sum('price') : 0;

        return view('cart')->with([
            'products' => $products,
            'total_price' => $total_price
        ]);
    }

    public function addCart(Request $request)
    {
        try {

            $result = ['type' => true];

            $args = [
                'user_email' => Auth::user()->email,
                'product_id' => $request->input('product_id', '')
            ];

            // 先判斷使用者是否買過這個商品
            $transactions = $this->transactionService->getTransactions(Transaction::STATUS_SUCCESS);
            foreach ($transactions as $transaction) {
                $orders = $this->orderService->getOrders(['transaction_id' => $transaction->transaction_id]);
                foreach ($orders as $order) {
                    if ($order->product_id == $args['product_id']) {
                        throw new \Exception('您已經購買過此商品，請前往訂單頁面下載');
                    }
                }
            }
            $transactions = $this->transactionService->getTransactions(Transaction::STATUS_PAYED);
            foreach ($transactions as $transaction) {
                $orders = $this->orderService->getOrders(['transaction_id' => $transaction->transaction_id]);
                foreach ($orders as $order) {
                    if ($order->product_id == $args['product_id']) {
                        throw new \Exception('您的商品正在等待付款審核中');
                    }
                }
            }
            $transactions = $this->transactionService->getTransactions(Transaction::STATUS_CREATE);
            foreach ($transactions as $transaction) {
                $orders = $this->orderService->getOrders(['transaction_id' => $transaction->transaction_id]);
                foreach ($orders as $order) {
                    if ($order->product_id == $args['product_id']) {
                        throw new \Exception('您尚有未結帳之訂單');
                    }
                }
            }

            if (!$this->cartService->getCartByEmailAndId($args['user_email'], $args['product_id'])) {
                $this->cartService->addCart($args);
            }

            return $result;

        } catch (\Exception $ex) {

            Log::error($ex);

            return ['type' => false , 'message' => $ex->getMessage()];

        }

    }

    public function deleteCart(Request $request)
    {
        $result = ['type' => true];

        $args = [
            'user_email' => Auth::user()->email,
            'product_id' => $request->input('product_id', '')
        ];

        $this->cartService->deleteCart($args);

        return $result;
    }
}
