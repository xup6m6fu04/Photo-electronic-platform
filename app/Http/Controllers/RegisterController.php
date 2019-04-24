<?php

namespace App\Http\Controllers;

use App\Services\MailService;
use App\Services\RegisterService;
use App\Services\UserService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    protected $mailService;
    protected $registerService;
    protected $userService;

    public function __construct(MailService $mailService, RegisterService $registerService, UserService $userService)
    {
        $this->mailService = $mailService;
        $this->registerService = $registerService;
        $this->userService = $userService;
    }

    public function pageRegister()
    {
        return view('register');
    }

    public function registerAction(Request $request)
    {
        $email = $request->input('email');

        if (!$email) {

            $result = [
                'type' => false,
                'message' => '請輸入信箱'
            ];

            return response()->json($result);
        }

        $pwd1 = $request->input('pwd1');
        $pwd2 = $request->input('pwd2');

        if ($pwd1 != $pwd2) {

            $result = [
                'type' => false,
                'message' => '兩次密碼輸入不同'
            ];

            return response()->json($result);
        }

        $code = $this->userService->randString();

        $user = $this->registerService->createAccount($email, $pwd1, $code);

        if (!$user) {

            $result = [
                'type' => false,
                'message' => '帳號已註冊'
            ];

            return response()->json($result);
        }

        // 寄送驗證信

        $mail_args = [
            'msg' => "親愛的會員您好，您的驗證網址為：" .
                action('RegisterController@verifyEmail', ['email' => $user->email, 'code' => $code]) .
                "\n請點擊連結驗證",
            'subject' => '註冊驗證信件',
            'email' => $email
        ];

        $this->mailService->single_mail($mail_args);

        $result = ['type' => true];

        return response()->json($result);

    }

    public function sendCode(Request $request)
    {
        $result = ['type' => false];

        $email = $request->input('email');

        // 補發驗證碼時不會有 code 傳入
        if ($user = $this->userService->getUserByEmail($email)) {

            if ($user->verify == 'Y') {
                return response()->json($result);
            }

            $code = $user->code;

            // 寄送驗證信

            $mail_args = [
                'msg' => "親愛的會員您好，您的驗證網址為：" .
                    action('RegisterController@verifyEmail', ['email' => $user->email, 'code' => $code]) .
                    "\n請點擊連結驗證",
                'subject' => '註冊驗證信件',
                'email' => $email
            ];

            $this->mailService->single_mail($mail_args);

            $result = ['type' => true];

        } else {
            return response()->json($result);
        }

        return response()->json($result);
    }

    public function verifyEmail(Request $request)
    {
        // FOR AJAX
        // $result = ['type' => false];
        // FOR WEB
        $result = 'N';

        $email = $request->input('email');
        $code = $request->input('code');

        if ($this->registerService->verifyAccount($email, $code)) {
            // FOR AJAX
            // $result = ['type' => true];
            // FOR WEB
            $result = 'Y';
        }

        // FOR AJAX
        // return response()->json($result);
        // FOR WEB
        return redirect()->route('login', ['verify' => $result]);
    }

}
