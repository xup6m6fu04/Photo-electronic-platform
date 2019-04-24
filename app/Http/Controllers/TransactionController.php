<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\LineService;
use App\Services\MailService;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    protected $transactionService;
    protected $userService;
    protected $orderService;
    protected $cartService;
    protected $lineService;
    protected $mailService;

    public function __construct(
        TransactionService $transactionService,
        UserService $userService,
        OrderService $orderService,
        CartService $cartService,
        LineService $lineService,
        MailService $mailService
    ){
        $this->transactionService = $transactionService;
        $this->userService = $userService;
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->lineService = $lineService;
        $this->mailService = $mailService;
    }

    public function pageTransaction()
    {
        // 未完成訂單
        $transaction_n = $this->transactionService->getTransactionsDetail(['user_email' => Auth::user()->email], Transaction::STATUS_CREATE);
        $transaction_n = ($transaction_n->isEmpty()) ? [] : $transaction_n;
        // 確認中訂單
        $transaction_p = $this->transactionService->getTransactionsDetail(['user_email' => Auth::user()->email],Transaction::STATUS_PAYED);
        $transaction_p = ($transaction_p->isEmpty()) ? [] : $transaction_p;
        // 已確認付款訂單
        $transaction_y = $this->transactionService->getTransactionsDetail(['user_email' => Auth::user()->email],Transaction::STATUS_SUCCESS);
        $transaction_y = ($transaction_y->isEmpty()) ? [] : $transaction_y;
        // 取消訂單
        $transaction_c = $this->transactionService->getTransactions(Transaction::STATUS_CANCEL);
        $transaction_c = ($transaction_c->isEmpty()) ? [] : $transaction_c;

        return view('transaction')->with([
           'transaction_n' => $transaction_n, // 未完成訂單
           'transaction_p' => $transaction_p, // 確認中訂單
           'transaction_y' => $transaction_y, // 已確認付款訂單
           'transaction_c' => $transaction_c, // 取消訂單
        ]);
    }

    public function cancelTransaction(Request $request)
    {
        try {

            $transaction_id = $request->input('transaction_id');
            $args = ($transaction_id) ? ['transaction_id' => $transaction_id] : [];

            DB::beginTransaction();

            $this->transactionService->cancelTransaction($args);

            DB::commit();

            return ['type' => true];

        } catch (\Exception $ex) {

            Log::error($ex);
            DB::rollback();

            return ['type' => false, 'message' => $ex->getMessage()];

        }
    }

    public function completeTransaction(Request $request)
    {
        try {

            $account = $request->input('account');

            if (!preg_match("/^[0-9]{5}$/", $account)) {
                 throw new \Exception('末五碼格式錯誤');
            }

            DB::beginTransaction();

            $transaction = $this->transactionService->getTransactions(Transaction::STATUS_CREATE, false)->first();
            $transaction->account = $account;
            $transaction->status = Transaction::STATUS_PAYED;
            $transaction->save();

            $order_detail = $this->transactionService->getTransactionsDetail(['transaction_id' => $transaction->transaction_id]);
            $total_price = 0;
            foreach ($order_detail as $value) {
                $total_price += $value->price;
            }

//            $this->lineService->sendMsg(env('LINE_ID'), '------' . Carbon::now()->toDateTimeString() . '------');
//            $this->lineService->sendMsg(env('LINE_ID'), '哈囉 ! 買家通知匯款囉 !');
//            $this->lineService->sendMsg(env('LINE_ID'),
//                '信箱 : ' . Auth::user()->email . PHP_EOL .
//                '訂單金額 : ' . $total_price . PHP_EOL .
//                '匯款帳號 : ' .  $account . PHP_EOL .
//                '訂單編號 : ' . $transaction->transaction_id
//            );
//            $this->lineService->sendMsg(env('LINE_ID'), '收到匯款後請複製下方信箱直接輸入即可開通 !');
//            $this->lineService->sendMsg(env('LINE_ID'), Auth::user()->email);
//            $this->lineService->sendMsg(env('LINE_ID'), '------' . Carbon::now()->toDateTimeString() . '------');

            DB::commit();

            return ['type' => true];

        } catch (\Exception $ex) {

            Log::error($ex);
            DB::rollback();

            return ['type' => false, 'message' => $ex->getMessage()];

        }
    }

    public function successTransaction(Request $request)
    {
        try {

            $transaction_id = $request->input('transaction_id');

            if (!$transaction_id) {
                throw new \Exception('未輸入訂單編號');
            }

            DB::beginTransaction();

            $transaction = $this->transactionService->getTransactionByTransactionId($transaction_id, false)->first();
            $transaction->status = Transaction::STATUS_SUCCESS;
            $transaction->save();

            DB::commit();

            $mail_args = [
                'msg' => "親愛的會員您好，您的訂單已經審核完畢，可前往我的訂單下載商品：https://dev.inredis.com/transaction",
                'subject' => '訂單完成確認信！您的訂單已經確認匯款！',
                'email' => $transaction->user_email
            ];

            $this->mailService->single_mail($mail_args);

            return ['type' => true];

        } catch (\Exception $ex) {

            Log::error($ex);
            DB::rollback();

            return ['type' => false, 'message' => $ex->getMessage()];

        }
    }

    public function createTransaction()
    {
        try {

            DB::beginTransaction();

            // 先檢查是否有未完成訂單
            if (!$this->transactionService->getTransactions(Transaction::STATUS_CREATE)->isEmpty()) {
                throw new \Exception('尚有未結帳訂單');
            }

            // 先檢查是否有確認中訂單
            if (!$this->transactionService->getTransactions(Transaction::STATUS_PAYED)->isEmpty()) {
                throw new \Exception('尚有確認中訂單');
            }

            // 取得購物車內容
            $products = $this->cartService->getProductsInCart();
            if ($products->isEmpty()) {
                throw new \Exception('購物車沒有內容');
            }

            // 先判斷使用者是否買過這個商品
            $transactions = $this->transactionService->getTransactions(Transaction::STATUS_SUCCESS);
            foreach ($transactions as $transaction) {
                $orders = $this->orderService->getOrders(['transaction_id' => $transaction->transaction_id]);
                foreach ($orders as $order) {
                    foreach($products as $product) {
                        if ($order->product_id == $product->product_id) {
                            throw new \Exception('購物車中有您已經購買的商品');
                        }
                    }
                }
            }
            $transactions = $this->transactionService->getTransactions(Transaction::STATUS_PAYED);
            foreach ($transactions as $transaction) {
                $orders = $this->orderService->getOrders(['transaction_id' => $transaction->transaction_id]);
                foreach ($orders as $order) {
                    foreach($products as $product) {
                        if ($order->product_id == $product->product_id) {
                            throw new \Exception('您的商品正在等待付款審核中');
                        }
                    }
                }
            }
            $transactions = $this->transactionService->getTransactions(Transaction::STATUS_CREATE);
            foreach ($transactions as $transaction) {
                $orders = $this->orderService->getOrders(['transaction_id' => $transaction->transaction_id]);
                foreach ($orders as $order) {
                    foreach($products as $product) {
                        if ($order->product_id == $product->product_id) {
                            throw new \Exception('您尚有未結帳之訂單');
                        }
                    }
                }
            }

            $args = [
                'transaction_id' => 'T' . $this->userService->randString(30, true),
                'user_email'     => Auth::user()->email,
            ];

            // 訂單建立
            $this->transactionService->createTransaction($args);

            // 訂單內容建立
            $this->orderService->createOrder($args['transaction_id'], $products);

            // 清空購物車
            $this->cartService->deleteCart(['user_email', Auth::user()->email]);

            DB::commit();

            return ['type' => true];

        } catch (\Exception $ex) {

            Log::error($ex);
            DB::rollback();

            $this->cartService->deleteCart(['user_email', Auth::user()->email]);

            return ['type' => false, 'message' => $ex->getMessage()];

        }

    }
}
