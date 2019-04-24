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
            <h2 class="section-title mb-40 text-center">會員管理</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">會員帳號</th>
                    <th scope="col">會員是否驗證信箱</th>
                    <th scope="col">會員驗證信箱日期</th>
                    <th scope="col">會員註冊日期</th>
                    <th scope="col">會員資料更新日期</th>
                    <th scope="col">手動驗證信箱</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ($user->verify === 'Y') ? '已驗證' : '未驗證' }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->verify_date)->toDateString() }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->created_at)->toDateString() }}</td>
                        <td>{{ \Carbon\Carbon::parse($user->updated_at)->toDateString() }}</td>
                        <td>@if ($user->verify !== 'Y') <a id="verify_btn" data-email="{{ $user->email }}" href="javascript:;"><span class="badge badge-warning">手動驗證信箱</span></a> @else 已驗證 @endif</td>
                    </tr>
                    <?php $i ++ ?>
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
    $(document).on('click', '#verify_btn', function(){

        let email = $(this).data('email');

        const toast = swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        Swal.fire({
            title: '協助會員驗證信箱',
            text: "你確定要幫此會員驗證信箱嗎",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '確定，他收不到信件',
            cancelButtonText: '我按錯了',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "post",
                    url: "{{ route('adminVerify') }}",
                    dataType: "json",
                    data: {
                        email: email,
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
</script>