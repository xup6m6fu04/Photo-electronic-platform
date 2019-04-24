<?php

namespace App\Repositories;

use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UserRepository
{
    /**
     * 將使用者密碼修改為亂數密碼並回傳
     *
     * @param $email
     * @param $password
     * @return string
     */
    public function resetPassword($email, $password)
    {
        if ($user = User::where('email', $email)->first()) {
            $user->password = bcrypt($password);
            $user->save();
        }

        return $password;
    }

    public function resetNPassword($email, $code, $password)
    {
        if ($user = PasswordReset::where('email', $email)->where('token', $code)->first()) {
            $user = User::where('email', $email)->first();
            $user->password = bcrypt($password);
            $user->save();
        }

        return $user;
    }

    public function createAccount($email, $password, $code)
    {
        if ($user = User::where('email', $email)->first()) {
            return false;
        }

        $user = new User();
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->code = $code; // 驗證碼
        $user->save();

        return $user;

    }

    public function getAllUsers()
    {
        return User::all();
    }

    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();

        // return User::where('email', $email)->where('gold', 'Y')->first(); // 網站封閉時使用
    }

    public function setUserVerify($email)
    {
        $user = User::where('email', $email)->first();
        $user->verify = 'Y';
        $user->verify_date = Carbon::now()->toDateTimeString();
        $user->save();

        return $user;
    }
}
