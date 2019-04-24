<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected $cartRepository;
    protected $userRepository;

    /**
     * 依賴注入
     *
     * UserService constructor.
     * @param UserRepository $userRepository
     * @param CartRepository $cartRepository
     */
    public function __construct(UserRepository $userRepository, CartRepository $cartRepository)
    {
        $this->userRepository = $userRepository;
        $this->cartRepository = $cartRepository;
    }

    public function addCart($args)
    {
        $this->cartRepository->insert($args);
    }

    public function deleteCart($args)
    {
        $this->cartRepository->delete($args);
    }

    public function getProductsInCart()
    {
        return $this->cartRepository->getCartsJoinProducts(Auth::user()->email);
    }

    public function getCartsByEmail()
    {
        return $this->cartRepository->getCarts([
            'user_email' => Auth::user()->email,
        ]);
    }

    public function getCartByEmailAndId($email, $product_id)
    {
        return ($email && $product_id)
            ? $this->cartRepository->getCarts([
                'user_email' => $email,
                'product_id' => $product_id
            ], false)->first()
            : '';
    }

}
