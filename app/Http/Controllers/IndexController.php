<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Services\ProductService;

class IndexController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function pageIndex(Request $request)
    {
        // 取得商品資料
        $type = $request->input('type', 'ALL');

        switch ($type) {
            case Product::PRODUCT_TYPE_A :
                $products = $this->productService->getProductsByParams(['open' => Product::OPEN, 'type' => Product::PRODUCT_TYPE_A]);
                break;
            case Product::PRODUCT_TYPE_B :
                $products = $this->productService->getProductsByParams(['open' => Product::OPEN, 'type' => Product::PRODUCT_TYPE_B]);
                break;
            case Product::PRODUCT_TYPE_C :
                $products = $this->productService->getProductsByParams(['open' => Product::OPEN, 'type' => Product::PRODUCT_TYPE_C]);
                break;
            default :
                $products = $this->productService->getAllOpenProducts();
                break;
        }

        return view('index')->with('products', $products);
    }
}
