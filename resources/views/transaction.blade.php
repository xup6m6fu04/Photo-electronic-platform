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
        <div class="container">
            <h2 class="section-title mb-40 text-center">未完成訂單</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">訂單編號</th>
                    <th scope="col">商品編號</th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">商品價格 ($NT)</th>
                    <th scope="col">張數 (P)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    $i = 1;
                    $total_price = 0;
                ?>
                @foreach($transaction_n as $transaction)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->product_id }}</td>
                        <td>{{ $transaction->product_name }}</td>
                        <td>{{ $transaction->price }}</td>
                        <td>{{ $transaction->page }}</td>
                    </tr>
                    <?php
                        $i ++;
                        $total_price += $transaction->price;
                    ?>
                @endforeach
                </tbody>
            </table>
            @if ($total_price > 0)
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th scope="col">總計金額 (NT$)</th>
                        <th scope="col">取消訂單</th>
                        <th scope="col">確認匯款</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $total_price }}</td>
                        <td><a id="cancel_btn" href="javascript:;"><span class="badge badge-danger">取消訂單</span></a></td>
                        <td><a id="buy_btn" href="javascript:;"><span class="badge badge-primary">通知站長已匯款</span></a></td>
                    </tr>
                </tbody>
            </table>
            @endif
            <div class="space50"></div>
        </div>
        <!-- /.container -->
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container">
            <h2 class="section-title mb-40 text-center">確認中訂單</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">訂單編號</th>
                    <th scope="col">商品編號</th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">商品價格 ($NT)</th>
                    <th scope="col">張數 (P)</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $total_price = 0;
                ?>
                @foreach($transaction_p as $transaction)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->product_id }}</td>
                        <td>{{ $transaction->product_name }}</td>
                        <td>{{ $transaction->price }}</td>
                        <td>{{ $transaction->page }}</td>
                    </tr>
                    <?php
                    $i ++;
                    $total_price += $transaction->price;
                    ?>
                @endforeach
                </tbody>
            </table>
            <div class="space50"></div>
        </div>
        <!-- /.container -->
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container">
            <h2 class="section-title mb-40 text-center">已完成訂單</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">訂單編號</th>
                    <th scope="col">商品編號</th>
                    <th scope="col">商品名稱</th>
                    <th scope="col">商品價格 ($NT)</th>
                    <th scope="col">張數 (P)</th>
                    <th scope="col">下載</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                $total_price = 0;
                ?>
                @foreach($transaction_y as $transaction)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->product_id }}</td>
                        <td>{{ $transaction->product_name }}</td>
                        <td>{{ $transaction->price }}</td>
                        <td>{{ $transaction->page }}</td>
                        <td><a target="_blank" href="{{ $transaction->download_url }}"><span class="badge badge-primary">下載寫真</span></a></td>
                    </tr>
                    <?php
                    $i ++;
                    $total_price += $transaction->price;
                    ?>
                @endforeach
                </tbody>
            </table>
            <div class="space50"></div>
        </div>
        <!-- /.container -->
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container">
            <h2 class="section-title mb-40 text-center">已取消訂單</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">訂單編號</th>
                    <th scope="col">取消日期</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction_c as $transaction)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->updated_at }}</td>
                    </tr>
                @endforeach
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
    const toast = swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    });

    $(document).on('click', '#cancel_btn', function(){

        $.ajax({
            type: "post",
            url: "{{ route('cancelTransaction') }}",
            dataType: "json",
            success: function (result) {
                if (result.type) {
                    location.reload();
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

    $(document).on('click', '#buy_btn', function () {

        (async function getAccount() {
            const {value: account} = await swal({
                title: "<span style='font-size: 24px'>請輸入匯款帳號末五碼</span>",
                input: 'text',
                inputPlaceholder: '',
                confirmButtonText: '確認送出',
                confirmButtonColor: '#2b4448',
            });

            if (account) {
                $.ajax({
                    type: "post",
                    url: "{{ route('completeTransaction') }}",
                    dataType: "json",
                    data: {
                        account: account
                    },
                    success: function (result) {
                        if (result.type) {
                            location.reload();
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
                            title: '連線錯誤，請重試或回報客服'
                        })
                    }
                });
            }

        })()
    });

</script>