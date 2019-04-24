@include('layouts.header')
<div class="content-wrapper">
    @include('layouts.header_title')
    <!-- /.navbar -->
        {{--<div class="wrapper dark-wrapper inverse-text">--}}
            {{--<div class="container inner">--}}
                {{--<div class="row gutter-60 gutter-md-30">--}}
                    {{--<div class="col-md-6">--}}
                        {{--<h2 class="sub-heading text-center text-md-right">11111.photo</h2>--}}
                    {{--</div>--}}
                    {{--<!-- /column -->--}}
                    {{--<div class="col-md-6">--}}
                        {{--<p class="lead text-center text-md-left">歡迎來我的寫真區 <br> 有任何問題歡迎私信我的 IG</p>--}}
                    {{--</div>--}}
                    {{--<!-- /column -->--}}
                {{--</div>--}}
                {{--<!-- /.row -->--}}
            {{--</div>--}}
            {{--<!-- /.container -->--}}
        {{--</div>--}}
        <!-- /.wrapper -->
        <div class="wrapper light-wrapper">
            <div class="container inner pb-0">
                <h2 class="section-title mb-40 text-center">{{ $product->product_name }}</h2>
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <div id="accordion1" class="accordion-wrapper bordered">
                            <div class="card">
                                <div class="card-header">
                                    <h3> <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-1" aria-expanded="true">商品介紹</a> </h3>
                                </div>
                                <div id="collapse1-1" class="collapse show">
                                    <div class="card-block">
                                        <p>{!! nl2br($product->main_info) !!}</p>
                                        <p>{!! nl2br($product->sub_info) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 offset-lg-2">
                        <div id="accordion1" class="accordion-wrapper bordered">
                            <div class="card">
                                <div class="card-header">
                                    <h3> <a data-toggle="collapse" data-parent="#accordion2" href="#collapse1-2" aria-expanded="true">商品資訊</a> </h3>
                                </div>
                                <div id="collapse1-2" class="collapse show">
                                    <div class="card-block">
                                        演員名稱：{{ $product->actor_name }}<br>
                                        商品名稱：{{ $product->product_name }}<br>
                                        價格：NT$ {{ $product->price }}<br>
                                        張數：{{ $product->page }} P<br>
                                        分類：{{ $product->type }}<br>
                                        {{--購買人數：{{ $product->buy_count }}<br>--}}
                                        首次上架時間：{{ $product->created_at }}<br>
                                        最後更新時間：{{ $product->updated_at }}<br>
                                    </div>
                                </div>
                            </div>
                            <a id="add_cart" data-product_id="{{ $product->product_id }}" href="javascript:;" class="btn btn-blue">加入購物車 ( 價格 NT$ {{ $product->price }} )</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="wrapper light-wrapper">
            <div class="container inner pb-60">
                <div id="cube-grid-large" class="cbp light-gallery">
                    <!--/.cbp-item -->
                    <div class="cbp-item cat2">
                        <figure class="overlay overlay2"><a href="{{ env('AWS_S3_URL') . $product->preview_1 }}"><img src="{{ env('AWS_S3_URL') . $product->preview_1 }}" alt="" /></a></figure>
                    </div>
                    <!--/.cbp-item -->
                    <div class="cbp-item cat1 cat5">
                        <figure class="overlay overlay2"><a href="{{ env('AWS_S3_URL') . $product->preview_2 }}"><img src="{{ env('AWS_S3_URL') . $product->preview_2 }}" alt="" /></a></figure>
                    </div>
                    <!--/.cbp-item -->
                    <div class="cbp-item cat5 cat4">
                        <figure class="overlay overlay2"><a href="{{ env('AWS_S3_URL') . $product->preview_3 }}"><img src="{{ env('AWS_S3_URL') . $product->preview_3 }}" alt="" /></a></figure>
                    </div>
                    {{--<div class="cbp-item cat2 cat3">--}}
                    {{--<figure class="overlay overlay2"><a href="style/images/art/p18-full.jpg" data-sub-html="#caption2"><img src="style/images/art/p18.jpg" alt="" />--}}
                    {{--<div id="caption2" class="d-none">--}}
                    {{--<p>Nulla vitae elit libero, a pharetra augue.</p>--}}
                    {{--</div>--}}
                    {{--</a></figure>--}}
                    {{--</div>--}}
                </div>
                <!--/.cbp -->
            </div>
            <!-- /.container -->
        </div>
    @include('layouts.footer')
</div>
@include('layouts.footer_js')
<script>
    $(document).on('click', '#add_cart', function(){

        let product_id = $(this).data('product_id');

        const toast = swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        $.ajax({
            type: "post",
            url: "{{ route('addCart') }}",
            dataType: "json",
            data: {
                product_id: product_id,
            },
            success: function (result) {
                if (result.type) {
                    toast({
                        type: 'success',
                        title: '加入購物車成功'
                    })
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
