<?php

namespace App\Http\Controllers;

use App\Product;
use App\Services\ProductService;
use App\Services\TransactionService;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $userService;
    protected $productService;
    protected $transactionService;

    public function __construct(UserService $userService, ProductService $productService, TransactionService $transactionService)
    {
        $this->userService = $userService;
        $this->productService = $productService;
        $this->transactionService = $transactionService;
    }

    public function pageAdmin()
    {
        return view('admin');
    }

    public function pageAdminAdd()
    {
        return view('admin.add');
    }

    public function addPhoto(Request $request)
    {
        try {

            // TODO : 加上 Validate 驗證

            DB::beginTransaction();

            $args = [
                'product_id'   => 'P' . $this->userService->randString(30, true), // ID
                'product_name' => $request->input('product_name'),                // 寫真名稱
                'actor_name'   => $request->input('actor_name'),                  // 演員名稱
                'page'         => $request->input('page'),                        // 寫真頁數
                'price'        => $request->input('price'),                       // 販售價格
                'type'          => $request->input('type'),                       // 寫真類型
                'main_info'    => $request->input('main_info'),                   // 主介紹
                'sub_info'     => $request->input('sub_info'),                    // 副介紹
                'download_url' => $request->input('download_url'),                // 下載地址 (購買後才能取得)
                'preview_1'    => $this->userService->randString(15) . '.jpg',    // 預覽圖 1
                'preview_2'    => $this->userService->randString(15) . '.jpg',    // 預覽圖 2
                'preview_3'    => $this->userService->randString(15) . '.jpg',    // 預覽圖 3
            ];

            $this->productService->createProduct($args);

            // 上傳 S3
            $this->uploadPreviewPhoto($request->input('preview1', false), $args['preview_1']);
            $this->uploadPreviewPhoto($request->input('preview2', false), $args['preview_2']);
            $this->uploadPreviewPhoto($request->input('preview3', false), $args['preview_3']);

            DB::commit();

            return response()->json(['type' => true]);

        } catch (\Exception $ex) {

            DB::rollback();
            Log::error($ex);

            return response()->json(['type' => false]);
        }

    }

    public function uploadPreviewPhoto($base64_src, $pic_name)
    {
        if ($base64_src && preg_match('/^data:image\/(\w+);base64,/', $base64_src)) {
            $data = substr($base64_src, strpos($base64_src, ',') + 1);
            $data = base64_decode($data);
            Storage::disk('s3')->put($pic_name, $data, 'public');
        }
    }

    public function pageAdminEdit(Request $request)
    {
        $product_id = $request->input('product_id', false);

        $product = ($product_id)
            ? $this->productService->getProductByProductId($product_id)
            : '';

        return ($product)
            ? view('admin.edit')->with('product', $product)
            : redirect()->route('index');
    }

    public function editPhoto(Request $request)
    {
        try {
            // TODO : 加上 Validate 驗證

            DB::beginTransaction();

            if (!$product_id = $request->input('product_id', false)) {
                throw new \Exception('Product ID Not Found !');
            }

            $product = $this->productService->getProductByProductId($product_id);

            $args = [
                'product_name'  => $request->input('product_name'),  // 寫真名稱
                'actor_name'    => $request->input('actor_name'),    // 演員名稱
                'page'          => $request->input('page'),          // 寫真頁數
                'price'         => $request->input('price'),         // 販售價格
                'type'          => $request->input('type'),          // 寫真類型
                'main_info'     => $request->input('main_info'),     // 主介紹
                'sub_info'      => $request->input('sub_info'),      // 副介紹
                'download_url'  => $request->input('download_url'),  // 下載地址 (購買後才能取得)
            ];

            if (!$request->input('preview_check', false)) {

                $this->productService->editProduct($product_id, $args);

            } else {

                $args = array_add($args, 'preview_1', $product->preview_1);
                $args = array_add($args, 'preview_2', $product->preview_2);
                $args = array_add($args, 'preview_3', $product->preview_3);

                $this->productService->editProduct($product_id, $args);

                // 上傳 S3
                $this->uploadPreviewPhoto($request->input('preview1', false), $args['preview_1']);
                $this->uploadPreviewPhoto($request->input('preview2', false), $args['preview_2']);
                $this->uploadPreviewPhoto($request->input('preview3', false), $args['preview_3']);
            }

            DB::commit();

            return response()->json(['type' => true]);

        } catch (\Exception $ex) {

            DB::rollback();
            Log::error($ex);

            return response()->json([
                'type' => false,
                'error' => $ex->getMessage()
            ]);

        }
    }

    public function pageAdminManage()
    {
        // 取得商品資料
        $products = $this->productService->getAllProducts();
        return view('admin.manage')->with('products', $products);
    }

    public function openPhoto(Request $request)
    {
        $result = ['type' => true];

        // Ajax 上架 / 下架
        if ($product_id = $request->input('product_id', false)) {
            $product = $this->productService->getProductByProductId($product_id);
            $product->open = ($product->open === Product::OPEN) ? Product::CLOSE : Product::OPEN;
            $product->save();
        } else {
            $result = ['type' => false];
        }

        return $result;
    }

    public function deletePhoto(Request $request)
    {
        $result = ['type' => true];

        // Ajax 刪除
        if ($product_id = $request->input('product_id', false)) {
            $product = $this->productService->getProductByProductId($product_id);
            $product->del = Product::DEL_Y;
            $product->save();
        } else {
            $result = ['type' => false];
        }

        return $result;
    }

    public function pageAdminMember()
    {
        $users = $this->userService->getAllUsers();
        return view('admin.member')->with('users', $users);
    }

    public function pageAdminRecord()
    {
        // 未完成訂單
        $transaction_n = $this->transactionService->getTransactionsByStatus(Transaction::STATUS_CREATE);
        $transaction_n = ($transaction_n->isEmpty()) ? [] : $transaction_n;
        // 確認中訂單
        $transaction_p = $this->transactionService->getTransactionsByStatus(Transaction::STATUS_PAYED)->toArray();
        foreach ($transaction_p as $key => $transaction_pp) {
            $transaction_sp = $this->transactionService->getTransactionsDetail(['transaction_id' => $transaction_pp['transaction_id']], Transaction::STATUS_PAYED)->toArray();
            $transaction_p[$key]['key'] = $transaction_sp;
        }
        $transaction_p = (empty($transaction_p)) ? [] : $transaction_p;
        // 已確認付款訂單
        $transaction_y = $this->transactionService->getTransactionsByStatus(Transaction::STATUS_SUCCESS);
        $transaction_y = ($transaction_y->isEmpty()) ? [] : $transaction_y;
        // 取消訂單
        $transaction_c = $this->transactionService->getTransactionsByStatus(Transaction::STATUS_CANCEL);
        $transaction_c = ($transaction_c->isEmpty()) ? [] : $transaction_c;

        return view('admin.record')->with([
            'transaction_n' => $transaction_n, // 未完成訂單
            'transaction_p' => $transaction_p, // 確認中訂單
            'transaction_y' => $transaction_y, // 已確認付款訂單
            'transaction_c' => $transaction_c, // 取消訂單
        ]);
    }
}
