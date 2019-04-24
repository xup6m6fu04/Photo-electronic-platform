@include('layouts.header')
<div class="content-wrapper">
    @include('layouts.header_title')
    <div class="wrapper image-wrapper bg-image inverse-text" data-image-src="image/up01.jpg">
        <div class="container inner pt-120 pb-120 text-center">
            <h1 class="heading mb-0">inredis</h1>
        </div>
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container inner">
            <h2 class="section-title mb-40 text-center">我的購物車</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">寫真名稱</th>
                    <th scope="col">演員名稱</th>
                    <th scope="col">價格 ($NT)</th>
                    <th scope="col">張數 (P)</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->actor_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->page }}</td>
                        <td><a id="delete_btn" data-product_id="{{ $product->product_id }}" href="javascript:;"><span class="badge badge-danger">刪除</span></a></td>
                    </tr>
                    <?php $i ++ ?>
                @endforeach
                </tbody>
            </table>
            <div class="wrapper bg-light-gray mb-40">
                <div class="container inner">
                    <h2 class="section-title mb-40 text-center">購買步驟及注意事項</h2>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="tabs-wrapper bordered">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="tab2-1">
                                        <p>購買步驟如下：</p>
                                        <ul class="unordered-list list-default">
                                            <li>1. 選擇喜歡的商品加入購物車</li>
                                            <li>2. 前往購物車按下結帳按鈕</li>
                                            <li>3. 前往我的訂單確認商品內容及金額</li>
                                            <li>4. 將正確款項轉至以下帳號 ： <br><br><b>8XX XXXX商業銀行 (XXX分行)<br>帳號：12345677899</b><br></li><br>
                                            <li>5. 匯款完成後請按通知匯款按鈕告知站長，並請稍等</li>
                                            <li>6. 一天內審核完畢後，會用 Email 通知，即可前往訂單頁面下載商品</li>
                                        </ul>
                                        <p>注意事項如下：</p>
                                        <ul class="unordered-list list-default">
                                            <li>購買後尚未完成訂單前可取消訂單</li>
                                            <li>未付款訂單只允許存在一筆，如下單後發現內容錯誤可直接取消重新下單</li>
                                            <li>付款後即無法退款，請務必再次確認訂單內容正確</li>
                                            <li>有任何問題可私信 Instgram，或利用網站聯繫功能</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">總計金額 (NT$)</th>
                        <th scope="col">結帳</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $total_price }}</td>
                        <td><a id="buy_btn" href="javascript:;"><span class="badge badge-primary">確認購買</span></a></td>
                    </tr>
                </tbody>
            </table>
            <div class="space50"></div>
        </div>
        <!-- /.container -->
    </div>
    @include('layouts.footer')
</div>
@include('layouts.footer_js')
<script>
    $(document).on('click', '#delete_btn', function(){

        let product_id = $(this).data('product_id');

        const toast = swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $.ajax({
            type: "post",
            url: "{{ route('deleteCart') }}",
            dataType: "json",
            data: {
                product_id: product_id,
            },
            success: function (result) {
                if (result.type) {
                    location.reload();
                } else {
                    toast({
                        type: 'error',
                        title: '失敗'
                    })
                }
            },
            error: function () {
                toast({
                    type: 'error',
                    title: '錯誤'
                })
            }
        });
    });

    $(document).on('click', '#buy_btn', function(){

        const toast = swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $.ajax({
            type: "post",
            url: "{{ route('createTransaction') }}",
            dataType: "json",
            success: function (result) {
                if (result.type) {
                    location.assign('/transaction');
                } else {
                    toast({
                        type: 'error',
                        title: result.message
                    })
                }
            },
            error: function () {
                toast({
                    type: 'error',
                    title: '錯誤'
                })
            }
        });
    });
</script>