<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use App\Services\TransactionService;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\LineService;
use Validator;


class LineController extends Controller
{
    protected $lineService;
    protected $transactionService;
    protected $mailService;

    public function __construct(LineService $lineService, TransactionService $transactionService, MailService $mailService)
    {
        $this->lineService = $lineService;
        $this->transactionService = $transactionService;
        $this->mailService = $mailService;
    }

    public function index()
    {
        $json_string = file_get_contents('php://input');
        $array = json_decode($json_string,true);
        if(!is_array($array)) exit;

        try {
            foreach($array as $one){
                if($one[0]['type'] == 'message'){
                    $userId = $one[0]['source']['userId'];
                    $reply_token = $one[0]['replyToken'];
                    if(isset($one[0]['message']['text'])){
                        $text = $one[0]['message']['text'];
                    }else{
                        Send::sendMsg($reply_token,'請勿傳送文字以外的訊息唷!');
                        exit();
                    }
                }elseif($one[0]['type'] == 'postback'){
                    $userId = $one[0]['source']['userId'];
                    $reply_token = $one[0]['replyToken'];
                    $text = $one[0]['postback']['data'];
                }
            }
        }catch(\Exception $ex) {

        }

        if ($userId != env('LINE_ID')) {
            $this->lineService->sendMsg($userId, '你不是小白不能控制我唷 !');
            exit;
        }

        $args['verify'] = trim($text);

        $email_verify = Validator::make($args, [
            'verify' => 'email'
        ]);

        if ($email_verify->fails()) {
            if ($text == '查詢') {
                $transactions = $this->transactionService->getTransactionsByStatus(Transaction::STATUS_PAYED);
                if ($transactions->isEmpty()) {
                    $this->lineService->sendMsg($userId, '目前沒有等待確認中訂單 !');
                    $this->lineService->sendTemplate_list($userId);
                    exit;
                }
                $this->lineService->sendMsg($userId, '目前等待確認中訂單如下 :');
                foreach ($transactions as $transaction) {
                    $order_detail = $this->transactionService->getTransactionsDetail(['transaction_id' => $transaction->transaction_id]);
                    $total_price = 0;
                    foreach ($order_detail as $value) {
                        $total_price += $value->price;
                    }

                    $this->lineService->sendMsg(env('LINE_ID'), '------' . Carbon::now()->toDateTimeString() . '------');
                    $this->lineService->sendMsg(env('LINE_ID'),
                        '信箱 : ' . $transaction->user_email . PHP_EOL .
                        '訂單金額 : ' . $total_price . PHP_EOL .
                        '匯款帳號 : ' .  $transaction->account . PHP_EOL .
                        '訂單編號 : ' . $transaction->transaction_id
                    );
                    $this->lineService->sendMsg(env('LINE_ID'), '收到匯款後請複製下方信箱直接輸入即可開通 !');
                    $this->lineService->sendMsg(env('LINE_ID'), $transaction->user_email);
                    $this->lineService->sendMsg(env('LINE_ID'), '------' . Carbon::now()->toDateTimeString() . '------');
                }
                $this->lineService->sendTemplate_list($userId);
                exit;
            } else {
                $this->lineService->sendTemplate_list($userId);
                exit;
            }
        }

        $transaction = $this->transactionService->getTransactionsByParams([
            'user_email' => $args['verify'],
            'status'     => Transaction::STATUS_PAYED
        ], false)->first();

        if (!$transaction) {
            $this->lineService->sendMsg($userId, '此會員沒有等待開通的訂單唷 !');
            exit;
        }

        $transaction->status = Transaction::STATUS_SUCCESS;
        $transaction->save();

        $this->lineService->sendMsg($userId, $transaction->transaction_id . PHP_EOL . ' 此筆訂單已經開通囉 !');

        $mail_args = [
            'msg' => "親愛的會員您好，您的訂單已經審核完畢，可前往我的訂單下載商品：https://dev.inredis.com/transaction",
            'subject' => '訂單完成確認信！您的訂單已經確認匯款！',
            'email' => $transaction->user_email
        ];

        $this->mailService->single_mail($mail_args);
    }
}
