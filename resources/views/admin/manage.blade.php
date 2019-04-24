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
            <h2 class="section-title mb-40 text-center">寫真管理</h2>
            <table class="table table-striped table-dark">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">主題</th>
                    <th scope="col">編輯</th>
                    <th scope="col">上架 / 下架</th>
                    <th scope="col">刪除</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 0; ?>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td><a href="/admin_edit?product_id={{ $product->product_id }}"><span class="badge badge-info">編輯</span></a></td>
                        <td>
                            <a id="open_btn" data-product_id="{{ $product->product_id }}" href="javascript:;">
                                @if ($product->open === \App\Product::OPEN)
                                    <span class="badge badge-warning">下架</span>
                                @else
                                    <span class="badge badge-primary">上架</span>
                                @endif
                            </a>
                        </td>
                        <td><a id="delete_btn" data-product_id="{{ $product->product_id }}" href="javascript:;"><span class="badge badge-danger">刪除</span></a></td>
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
    $(document).on('click', '#open_btn', function(){

        let product_id = $(this).data('product_id');

        const toast = swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $.ajax({
            type: "post",
            url: "{{ route('admin_open') }}",
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
            url: "{{ route('admin_delete') }}",
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
</script>