<?php

namespace App\Services;

use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;

class RegisterService
{

    protected $userRepository;

    /**
     * 依賴注入
     *
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createAccount($account, $password, $code)
    {
        return $this->userRepository->createAccount($account, $password, $code);
    }

    public function verifyAccount($account, $code)
    {
        $user = $this->userRepository->getUserByEmail($account);

        if ($user && $user->code == $code) {
            $user = $this->userRepository->setUserVerify($account);
            return $user;
        }

        return false;
    }
}
