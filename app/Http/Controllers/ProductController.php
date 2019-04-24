<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function pageProduct(Request $request)
    {
        $product_id = $request->input('product_id', false);

        $product = ($product_id)
            ? $this->productService->getProductByProductId($product_id)
            : '';

        // 分類翻中文
        if ($product->type == Product::PRODUCT_TYPE_A) {
            $product->type = '時裝';
        } else if ($product->type == Product::PRODUCT_TYPE_B) {
            $product->type = '內衣';
        } else if ($product->type == Product::PRODUCT_TYPE_C) {
            $product->type = '大尺度';
        }

        return ($product)
            ? view('product')->with('product', $product)
            : redirect()->route('index');
    }
}
