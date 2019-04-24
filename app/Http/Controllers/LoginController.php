<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use ReCaptcha\ReCaptcha;

class LoginController extends Controller
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * 登入頁面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function pageLogin(Request $request)
    {
        if ($request->input('verify') == 'Y') {
            return view('login')->with('verify', 'Y');
        }
        return view('login');
    }

    /**
     * 登入驗證 for login blade ajax
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginAction(Request $request)
    {
        $result = ['type' => false];

        $email = $request->input('email');
        $password = $request->input('password');
        $gRecaptchaResponse = $request->input('recaptcha');

        $recaptcha = new ReCaptcha(env('RECAPTCHA_KEY'));
        $resp = $recaptcha->verify($gRecaptchaResponse, $_SERVER['REMOTE_ADDR']);

        $user = $this->userService->getUserByEmail($email);

        if ($user && $user->verify != 'Y') {
            $result = ['type' => 'verify'];
            return response()->json($result);
        }

        if ($resp->isSuccess()) {
            if (Auth::attempt(['email' => $email, 'password' => $password])) {
                $result = ['type' => true];
            }
        } else {
            $result = ['type' => 'captcha'];
            Log::info($resp->getErrorCodes());
        }

        return response()->json($result);
    }
}
