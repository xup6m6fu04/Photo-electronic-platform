<?php

namespace App\Services;

class LineService
{
    protected $access_token;

    public function __construct()
    {
        $this->access_token = env('LINE_ACCESS_TOKEN');
    }

    public function sendMsg($userId, $text){
        $access_token = $this->access_token;
        $post_data = [
            "to" => $userId,
            "messages" => [
                [
                    "type" => "text",
                    "text" => $text
                ]
            ]
        ];
        $ch = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token
            //'Authorization: Bearer '. TOKEN
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function sendTemplate_list($userId)
    {
        $access_token = $this->access_token;
        $post_data = [
            "to" => $userId,
            "messages" => [
                array (
                    'type' => 'template',
                    'altText' => '小白寫真助手傳新訊息來囉 !',
                    'template' =>
                        array (
                            'type' => 'buttons',
                            'thumbnailImageUrl' => 'https://dev.inredis.com/image/index3.jpg',
                            'title' => '小白寫真管理助手',
                            'text' => '歡迎使用，請選擇需要的服務',
                            'actions' =>
                                array (
                                    0 =>
                                        array (
                                            'type' => 'postback',
                                            'label' => '查詢等待確認訂單',
                                            'data' => '查詢',
                                        ),
                                    1 =>
                                        array (
                                            'type' => 'uri',
                                            'label' => '關於開發者',
                                            'uri' => 'https://github.com/xup6m6fu04',
                                        ),

                                ),
                        ),
                )
            ]
        ];
        $ch = curl_init("https://api.line.me/v2/bot/message/push");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$access_token
            //'Authorization: Bearer '. TOKEN
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}