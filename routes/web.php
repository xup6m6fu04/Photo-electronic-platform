<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 僅非登入狀態可使用
Route::group(['middleware' => 'guest'], function () {

    // 登入頁面
    Route::match(['get', 'post'], '/login', 'LoginController@pageLogin')->name('login');
    // 登入驗證
    Route::match(['get', 'post'], '/login-action', 'LoginController@loginAction')->name('loginAction');
    // 忘記密碼寄送新密碼修改連結
    Route::match(['get', 'post'], '/send-reset-password-code', 'UserController@sendResetPasswordMail')->name('sendResetPasswordMail');
    // 忘記密碼寄送新密碼 Not Use
    Route::match(['get', 'post'], '/send-new-password', 'UserController@sendNewPassword')->name('sendNewPassword');
    // 註冊頁面
    Route::match(['get', 'post'], '/register', 'RegisterController@pageRegister')->name('register');
    // 註冊驗證
    Route::match(['get', 'post'], '/register-action', 'RegisterController@registerAction')->name('registerAction');
    // 註冊驗證碼寄送 or 補寄認證信
    Route::match(['get', 'post'], '/send-code', 'RegisterController@sendCode')->name('sendCode');
    // 驗證信箱
    Route::match(['get', 'post'], '/verify-email', 'RegisterController@verifyEmail')->name('verifyEmail');
    // 修改密碼頁面
    Route::match(['get', 'post'], '/n-password-reset', 'UserController@pageNPasswordReset')->name('pageNPasswordReset');
    // 修改密碼
    Route::match(['get', 'post'], '/n-password-reset-action', 'UserController@passwordNResetAction')->name('passwordNResetAction');

});

// 僅登入狀態時可使用
Route::group(['middleware' => 'auth'], function () {

    // 單一商品頁面
    Route::match(['get', 'post'], '/product', 'ProductController@pageProduct')->name('pageProduct');
    // 修改密碼頁面
    Route::match(['get', 'post'], '/password-reset', 'UserController@pagePasswordReset')->name('pagePasswordReset');
    // 修改密碼
    Route::match(['get', 'post'], '/password-reset-action', 'UserController@passwordResetAction')->name('passwordResetAction');
    // 加入購物車
    Route::match(['get', 'post'], '/add-cart', 'CartController@addCart')->name('addCart');
    // 刪除購物車
    Route::match(['get', 'post'], '/delete-cart', 'CartController@deleteCart')->name('deleteCart');
    // 購物車頁面
    Route::match(['get', 'post'], '/cart', 'CartController@pageCart')->name('pageCart');
    // 創建訂單
    Route::match(['get', 'post'], '/create-transaction', 'TransactionController@createTransaction')->name('createTransaction');
    // 訂單頁面
    Route::match(['get', 'post'], '/transaction', 'TransactionController@pageTransaction')->name('pageTransaction');
    // 取消訂單
    Route::match(['get', 'post'], '/cancel-transaction', 'TransactionController@cancelTransaction')->name('cancelTransaction');
    // 確認匯款末五碼
    Route::match(['get', 'post'], '/complete-transaction', 'TransactionController@completeTransaction')->name('completeTransaction');

    // 登出
    Route::get('logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return redirect()->route('login');
    })->name('logout');



});

Route::group(['middleware' => 'check_admin'], function () {

    // 管理員首頁
    Route::match(['get', 'post'], '/admin', 'AdminController@pageAdmin')->name('admin');
    // 新增寫真
    Route::match(['get', 'post'], '/admin_add', 'AdminController@pageAdminAdd')->name('admin_add');
    Route::match(['get', 'post'], '/admin_add_photo', 'AdminController@addPhoto')->name('admin_add_photo');
    // 編輯寫真
    Route::match(['get', 'post'], '/admin_edit', 'AdminController@pageAdminEdit')->name('admin_edit');
    Route::match(['get', 'post'], '/admin_edit_photo', 'AdminController@editPhoto')->name('admin_edit_photo');
    // 直接 上架 / 下架
    Route::match(['get', 'post'], '/admin_open', 'AdminController@openPhoto')->name('admin_open');
    // 直接刪除 (軟刪除)
    Route::match(['get', 'post'], '/admin_delete', 'AdminController@deletePhoto')->name('admin_delete');
    // 寫真管理
    Route::match(['get', 'post'], '/admin_manage', 'AdminController@pageAdminManage')->name('admin_manage');
    // 會員管理
    Route::match(['get', 'post'], '/admin_member', 'AdminController@pageAdminMember')->name('admin_member');
    // 購買紀錄
    Route::match(['get', 'post'], '/admin_record', 'AdminController@pageAdminRecord')->name('admin_record');
    // 收到匯款，完成訂單
    Route::match(['get', 'post'], '/success-transaction', 'TransactionController@successTransaction')->name('successTransaction');
    // 替會員驗證信箱
    Route::match(['get', 'post'], '/admin_verify', 'UserController@adminVerify')->name('adminVerify');

});

// 首頁
Route::match(['get', 'post'], '/', 'IndexController@pageIndex')->name('index');