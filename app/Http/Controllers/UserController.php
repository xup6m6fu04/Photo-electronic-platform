<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailService;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $mailService;
    protected $userService;

    /**
     * 依賴注入
     *
     * UserController constructor.
     * @param UserService $userService
     * @param MailService $mailService
     */
    public function __construct(UserService $userService, MailService $mailService)
    {
        $this->userService = $userService;
        $this->mailService = $mailService;
    }

    /**
     * 寄發驗證碼信件 for login blade ajax
     *
     * @param Request $request
     * @return array
     */
    public function sendResetPasswordMail(Request $request)
    {
        $result = ['type' => false];

        $email = $request->input('email');

        // 判斷用戶是否存在
        $user = $this->userService->getUserByEmail($email);

        if (!$user) {
            return response()->json($result);
        } else {
            $result = ['type' => true];
        }

        // 先產生亂數驗證碼
        $rand_code = $this->userService->randString(10);

        // 建立驗證碼或取得已存在的驗證碼
        $this->userService->getPasswordReset(
            [
                'email' => $email,
                'token' => $rand_code
            ]
        );

        $mail_args = [
            'msg' => "親愛的會員您好，請前往此處修改新密碼： " . route('pageNPasswordReset') . '?email=' . $email . '&code=' . $rand_code,
            'subject' => '密碼重置連結',
            'email' => $email
        ];

        $this->mailService->single_mail($mail_args);

        return response()->json($result);
    }

    /**
     * 寄發新密碼信件 for login blade ajax not use
     *
     * @param Request $request
     * @return array
     */
    public function sendNewPassword(Request $request)
    {
        $result = ['type' => false];

        $code = $request->input('code');
        $email = $request->input('email');

        // 用驗證碼抓出使用者
        $user_reset = $this->userService->getPasswordResetByToken($code, $email);

        if (!$user_reset) {
            return response()->json($result);
        } else {
            $result = ['type' => true];
        }

        /* 原本密碼用寄信的 改用網站直接讓使用者改

        // 更改密碼並取出
        $password = $this->userService->resetRandPassword($user_reset->email);

        // 寄信
        $mail_args = [
            'msg' => "親愛的 11111photo會員您好，您的新密碼為：" . $password . "\n請回到網頁重新登入",
            'subject' => '11111photo 密碼重置專用驗證碼',
            'email' => $user_reset->email
        ];

        $this->mailService->single_mail($mail_args);

        */

        // 刪除驗證碼資料
        // $this->userService->deletePasswordResetByEmail($user_reset->email);

        return response()->json($result);
    }

    public function pagePasswordReset()
    {
        return view('password-reset');
    }

    public function passwordResetAction(Request $request)
    {
        $result = ['type' => false];

        $v = Validator::make($request->all(), [
            'pwd1' => 'required|alpha_num|min:6|max:12',
            'pwd2' => 'required|alpha_num|min:6|max:12'
        ]);

        if ($v->fails()) {
            return response()->json($result);
        } else {
            $result = ['type' => true];
        }

        $this->userService->resetPassword(Auth::user()->email, $request->input('pwd1'));

        return response()->json($result);
    }

    public function checkGoldUser()
    {
        $result = ['type' => false];

        if (Auth::user()->gold == 'Y') {
            $result = ['type' => true];
        }

        return response()->json($result);
    }

    public function passwordNResetAction(Request $request)
    {
        $result = ['type' => false];

        $email = $request->input('email');
        $code = $request->input('code');

        $v = Validator::make($request->all(), [
            'pwd1' => 'required|alpha_num|min:6|max:12',
            'pwd2' => 'required|alpha_num|min:6|max:12'
        ]);

        if ($v->fails()) {
            return response()->json($result);
        } else {
            $result = ['type' => true];
        }

        $this->userService->resetNPassword($email, $code, $request->input('pwd1'));

        // 刪除驗證碼資料
        $this->userService->deletePasswordResetByEmail($email);

        return response()->json($result);
    }

    public function pageNPasswordReset(Request $request)
    {

        $email = $request->get('email');
        $code = $request->get('code');

        return view('n-password-reset')->with([
            'email' => $email,
            'code' => $code
        ]);
    }

    public function pageDonate()
    {
        return view('donate');
    }

    public function adminVerify(Request $request)
    {
        try {
            $result = ['type' => true];
            $email = $request->input('email');
            if (!$email) {
                throw new \Exception('無此會員信箱');
            }
            $this->userService->setUserVerify($email);
            return $result;
        } catch (\Exception $ex) {
            return ['type' => false, 'message'=> $ex->getMessage()];
        }
    }
}
