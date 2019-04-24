@include('layouts.header')
<div class="content-wrapper">
    @include('layouts.header_title')
    <!-- /.navbar -->
        <div class="wrapper dark-wrapper inverse-text">
            <div class="container inner">
                <div class="row gutter-60 gutter-md-30">
                    <div class="col-md-6">
                        <h2 class="sub-heading text-center text-md-right">inredis</h2>
                    </div>
                    <!-- /column -->
                    <div class="col-md-6">
                        <p class="lead text-center text-md-left">歡迎來我的寫真區 <br> 有任何問題歡迎私信我的 IG</p>
                    </div>
                    <!-- /column -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.wrapper -->
        <div class="wrapper light-wrapper">
            <div class="container inner text-center">
                <h2 class="section-title mb-40 text-center">分類選擇</h2>
                <a data-type="ALL" href="?type=ALL" class="type-select btn btn-forest">全部</a>
                <a data-type="A" href="?type=A" class="type-select btn btn btn-brown">時裝</a>
                <a data-type="B" href="?type=B" class="type-select btn btn-blue">內衣</a>
                <a data-type="C" href="?type=C" class="type-select btn btn-red">大尺度</a>
            <!-- /.container -->
            </div>
        </div>
        <div class="wrapper light-wrapper">
            <div class="container inner">
                <div class="blog grid grid-view">
                    <div class="row isotope">
                        @foreach($products as $product)
                        <div class="item post grid-sizer col-md-6 col-lg-4">
                            <figure class="overlay overlay2 mb-25"><a href="/product?product_id={{ $product->product_id }}"> <img src="{{ env('AWS_S3_URL') . $product->preview_1 }}" alt="" /></a></figure>
                            <div class="meta">
                                <span class="date">{{ $product->created_at }}</span>
                            </div>
                            <h2 class="post-title">
                                <a href="/product?product_id={{ $product->product_id }}">{!! nl2br($product->main_info) !!}</a>
                            </h2>
                            <div class="post-content">
                                <p>{!! nl2br($product->sub_info) !!}</p>
                                <a href="/product?product_id={{ $product->product_id }}" class="more">Read more</a>
                            </div>
                        </div>
                        @endforeach
                        <!-- /.post -->
                        {{--<div class="item post grid-sizer col-md-6 col-lg-4">--}}
                            {{--<figure class="overlay overlay2 mb-25"><a href="#"> <img src="image/index2.jpg" alt="" /></a></figure>--}}
                            {{--<div class="meta"><span class="date">12 Nov 2017</span><span class="comments"><a href="#">4</a></span><span class="category"><a href="#">Decorations</a></span></div>--}}
                            {{--<h2 class="post-title"><a href="blog-post.html">Nullam id dolor elit id nibh pharetra augue venenatis faucibus</a></h2>--}}
                            {{--<div class="post-content">--}}
                                {{--<p>Aenean lacinia bibendum nulla sed consectetur. Integer posuere erat a ante porttitor mollis sagittis lacus ultricies vehicula ut id elit.</p>--}}
                                {{--<a href="#" class="more">Read more</a> </div>--}}
                            {{--<!-- /.post-content -->--}}
                        {{--</div>--}}
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.blog -->
                {{--<div class="pagination bordered text-center">--}}
                    {{--<ul>--}}
                        {{--<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>--}}
                    {{--</ul>--}}
                {{--</div>--}}
                <!-- /.pagination -->
            </div>
            <!-- /.container -->
        </div>
    @include('layouts.footer')
</div>
@include('layouts.footer_js')
<script>

</script>
