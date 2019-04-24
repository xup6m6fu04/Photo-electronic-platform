<?php

namespace App\Services;

use App\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    protected $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function createProduct($args)
    {
        $this->productRepository->insert($args);
    }

    public function editProduct($product_id, $args)
    {
        $this->productRepository->edit($product_id, $args);
    }

    public function getAllProducts()
    {
        return $this->productRepository->getProducts();
    }

    public function getAllOpenProducts()
    {
        return $this->productRepository->getProducts(['open' => Product::OPEN]);
    }

    public function getProductsByParams($args)
    {
        return $this->productRepository->getProducts($args);
    }

    public function getProductByProductId($product_id = '')
    {
        return ($product_id)
            ? $this->productRepository->getProducts(['product_id' => $product_id], false)->first()
            : '';
    }
}