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
            <h2 class="section-title text-center">管理員區</h2>
            <p class="lead2 text-center">請謹慎操作以免資料遺失或毀損</p>
            <div class="space30"></div>
            <div id="cube-grid" class="cbp text-center">
                <div class="cbp-item cat2 cat3">
                    <figure class="overlay-info hovered bevel"><a href="/admin_manage"> <img src="image/index1.jpg" alt="" /></a>
                        <figcaption class="d-flex">
                            <div class="align-self-center mx-auto">
                                <h3 class="mb-0">寫真管理</h3>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!--/.cbp-item -->
                <div class="cbp-item cat1">
                    <figure class="overlay-info hovered bevel"><a href="/admin_add"> <img src="image/index2.jpg" alt="" /></a>
                        <figcaption class="d-flex">
                            <div class="align-self-center mx-auto">
                                <h3 class="mb-0">新增寫真</h3>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!--/.cbp-item -->
                <div class="cbp-item cat1">
                    <figure class="overlay-info hovered bevel"><a href="/admin_record"> <img src="image/index3.jpg" alt="" /></a>
                        <figcaption class="d-flex">
                            <div class="align-self-center mx-auto">
                                <h3 class="mb-0">購買紀錄</h3>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!--/.cbp-item -->
                <div class="cbp-item cat2 cat3">
                    <figure class="overlay-info hovered bevel"><a href="/admin_member"> <img src="image/index4.jpg" alt="" /></a>
                        <figcaption class="d-flex">
                            <div class="align-self-center mx-auto">
                                <h3 class="mb-0">會員管理</h3>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!--/.cbp-item -->
                <div class="cbp-item cat3">
                    <figure class="overlay-info hovered bevel"><a href="/"> <img src="image/index5.jpg" alt="" /></a>
                        <figcaption class="d-flex">
                            <div class="align-self-center mx-auto">
                                <h3 class="mb-0">備用空間</h3>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!--/.cbp-item -->
                <div class="cbp-item cat1">
                    <figure class="overlay-info hovered bevel"><a href="/"> <img src="image/index6.jpg" alt="" /></a>
                        <figcaption class="d-flex">
                            <div class="align-self-center mx-auto">
                                <h3 class="mb-0">備用空間</h3>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                <!--/.cbp-item -->
            </div>
            <!--/.cbp -->
        </div>
        <!-- /.container -->
    </div>
    @include('layouts.footer')
</div>
@include('layouts.footer_js')
