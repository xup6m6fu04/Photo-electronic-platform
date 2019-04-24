<?php

namespace App\Services;

use App\Repositories\PasswordResetRepository;
use App\Repositories\UserRepository;

class UserService
{

    protected $userRepository;
    protected $passwordResetRepository;

    /**
     * 依賴注入
     *
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(UserRepository $userRepository, PasswordResetRepository $passwordResetRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * 產生亂數字串
     *
     * @param int $length
     * @param bool $only_number
     * @return string
     */
    public function randString($length = 10, $only_number = false)
    {
        $pattern = ($only_number) ? '0123456789' : '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        while (strlen($string) < $length) {
            $string .= substr($pattern, rand(0, strlen($pattern) - 1), 1);
        }

        return $string;
    }

    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function getPasswordReset($args)
    {
        return $this->passwordResetRepository->insert($args);
    }

    public function getPasswordResetByToken($token, $email)
    {
        return $this->passwordResetRepository->getByToken($token, $email);
    }

    public function resetRandPassword($email)
    {
        $password = $this->randString(12);

        return $this->userRepository->resetPassword($email, $password);
    }

    public function resetPassword($email, $password)
    {
        return $this->userRepository->resetPassword($email, $password);
    }

    public function resetNPassword($email, $code, $password)
    {
        return $this->userRepository->resetNPassword($email, $code, $password);
    }

    public function deletePasswordResetByEmail($email)
    {
        return $this->passwordResetRepository->deleteByEmail($email);
    }

    public function setUserVerify($email)
    {
        return $this->userRepository->setUserVerify($email);
    }

}
