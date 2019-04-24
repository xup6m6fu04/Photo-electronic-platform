<?php

namespace App\Repositories;

use App\PasswordReset;

class PasswordResetRepository
{
    /**
     * 如無驗證碼就新增，並回傳
     *
     * @param $args
     * @return PasswordReset
     */
    public function insert($args)
    {
        $email = array_get($args, 'email', '');
        $token = array_get($args, 'token', '');

        $password_data = PasswordReset::where('email', $email)->first();

        if ($password_data && $password_data->token) {
            return $password_data;
        }

        $record = new PasswordReset();
        $record->email = $email;
        $record->token = $token;
        $record->save();

        return $record;
    }

    public function getByToken($token, $email)
    {
        return PasswordReset::where('token', $token)->where('email', $email)->first();
    }

    public function deleteByEmail($email)
    {
        $record = PasswordReset::where('email', $email)->first();

        if ($record) {
            $record->delete();
        }

        return $record;
    }
}
