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
                                    <li>確認商品金額及內容無誤後按下確認購買按鈕</li>
                                    <li>前往我的訂單取得匯款資訊</li>
                                    <li>匯款完成後前往我的訂單，點擊付款完成按鈕，並輸入相關資料</li>
                                    <li>訂單將在一天內確認完畢，將會收到信件通知，即可前往此訂單頁面下載商品</li>
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
                    <th scope="col">訂單編號</th>
                    <th scope="col">購買帳號</th>
                    <th scope="col">完成日期</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction_n as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->user_email }}</td>
                        <td>{{ $transaction->updated_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="space50"></div>
        </div>
        <!-- /.container -->
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container">
            <h2 class="section-title mb-40 text-center">確認中訂單</h2>
            <?php
            $total_price = 0;
            ?>
            @foreach($transaction_p as $transaction)
                <table class="table table-striped table-dark">
                    <thead>
                    <tr>
                        <th scope="col">訂單編號</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $transaction['transaction_id'] }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                        <thead>
                        <tr>
                            <th scope="col">商品編號</th>
                            <th scope="col">商品名稱</th>
                            <th scope="col">商品價格</th>
                            <th scope="col">完成日期</th>
                        </tr>
                        </thead>
                    <tbody>
                 @foreach($transaction['key'] as $transaction_value)
                     <tr>
                         <td>{{ $transaction_value->product_id }}</td>
                         <td>{{ $transaction_value->product_name }}</td>
                         <td>{{ $transaction_value->price }}</td>
                         <td>{{ $transaction['updated_at'] }}</td>
                     </tr>
                     <?php $total_price += $transaction_value->price; ?>
                 @endforeach
                    </tbody>
                    <table class="table table-striped table-dark"  style=" margin-bottom: 100px;">
                        <thead>
                        <tr>
                            <th scope="col">總計金額 (NT$)</th>
                            <th scope="col">買家信箱</th>
                            <th scope="col">匯款帳號</th>
                            <th scope="col">取消訂單</th>
                            <th scope="col">確認匯款</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $total_price }}</td>
                            <td>{{ $transaction['user_email'] }}</td>
                            <td>{{ $transaction['account'] }}</td>
                            <td><a id="cancel_btn" data-id="{{ $transaction['transaction_id'] }}" href="javascript:;"><span
                                            class="badge badge-danger">取消訂單</span></a></td>
                            <td><a id="buy_btn" data-id="{{ $transaction['transaction_id'] }}" href="javascript:;"><span
                                            class="badge badge-primary">已收到買家匯款</span></a></td>
                        </tr>
                        </tbody>
                    </table>
                    <?php $total_price = 0; ?>
            @endforeach

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
                    <th scope="col">訂單編號</th>
                    <th scope="col">購買帳號</th>
                    <th scope="col">匯款帳號</th>
                    <th scope="col">完成日期</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction_y as $transaction)
                    <tr>
                        <td>{{ $transaction->transaction_id }}</td>
                        <td>{{ $transaction->user_email }}</td>
                        <td>{{ $transaction->account }}</td>
                        <td>{{ $transaction->updated_at }}</td>
                    </tr>
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
                    <th scope="col">訂單編號</th>
                    <th scope="col">取消日期</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transaction_c as $transaction)
                    <tr>
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
        let id = $(this).data('id');
        Swal.fire({
            title: '取消訂單',
            text: "你確定要取消此筆訂單嗎",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '確定取消',
            cancelButtonText: '我按錯了',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "{{ route('cancelTransaction') }}",
                    dataType: "json",
                    data : {
                        transaction_id: id
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
                            title: '錯誤'
                        })
                    }
                });
            }
        })

    });

    $(document).on('click', '#buy_btn', function () {

        let id = $(this).data('id');
        Swal.fire({
            title: '完成訂單',
            text: "你確定要完成此筆訂單嗎",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '確定，我收到匯款了',
            cancelButtonText: '我按錯了',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "{{ route('successTransaction') }}",
                    dataType: "json",
                    data: {
                        transaction_id: id
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
                            title: '錯誤'
                        })
                    }
                });
            }
        })
    })
</script>