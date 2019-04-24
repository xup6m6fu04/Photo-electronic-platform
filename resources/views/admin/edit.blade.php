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
            <h2 class="section-title text-center">編輯寫真</h2>
            <form>
                <div class="form-group">
                    <label>寫真名稱</label>
                    <input type="text" id="product_name" class="form-control" value="{{ $product->product_name }}" placeholder="寫真名稱">
                </div>
                <div class="form-group">
                    <label>演員名稱</label>
                    <input type="text" id="actor_name" class="form-control" value="{{ $product->actor_name }}" placeholder="演員名稱">
                </div>
                <div class="form-group">
                    <label>寫真張數</label>
                    <input type="number" id="page" class="form-control" value="{{ $product->page }}" placeholder="寫真張數">
                </div>
                <div class="form-group">
                    <label>寫真價格</label>
                    <input type="number" id="price" class="form-control" value="{{ $product->price }}" placeholder="寫真價格">
                </div>
                <div class="form-group">
                    <label>寫真類型</label>
                    <select id="type" class="custom-select">
                        <option value="A" @if($product->type == 'A') selected @endif>時裝</option>
                        <option value="B" @if($product->type == 'B') selected @endif>內衣</option>
                        <option value="C" @if($product->type == 'C') selected @endif>大尺度</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>主要介紹區</label>
                    <textarea id="main_info" class="form-control" rows="3">{{ $product->main_info }}</textarea>
                </div>
                <div class="form-group">
                    <label>詳細介紹區</label>
                    <textarea id="sub_info" class="form-control" rows="3">{{ $product->sub_info }}</textarea>
                </div>
                <div class="form-group row">
                    <div class="col-md-12 mb-3">
                        <label>預覽圖上傳區 (最多三張，第一張預設為封面圖)</label>
                        <br><label style="color: red;">注意：預覽圖如不修改請留空，要修改請一次上傳，無法單張修改</label>
                        <form>
                            <input type="file" onchange="upload_preview(event)" class="form-control-file" multiple>
                        </form>
                    </div>
                    <div class="col-md-4 mb-3">
                        <img id="preview1" src="" class="img-fluid pt-3"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <img id="preview2" src="" class="img-fluid pt-3"/>
                    </div>
                    <div class="col-md-4 mb-3">
                        <img id="preview3" src="" class="img-fluid pt-3"/>
                    </div>
                </div>

                <div class="form-group">
                    <label>壓縮檔網址 (會員購買後取得)</label>
                    <form>
                        <div class="form-group">
                            <input type="text" id="download_url" class="form-control" value="{{ $product->download_url }}" placeholder="壓縮檔網址">
                        </div>
                    </form>
                </div>

                <br><br>
                <button id="send" type="button" class="btn btn-primary">確認送出</button>
            </form>
            <!--/.cbp -->
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

    $(document).on('click', '#send', function(){

        let preview_check = true;

        if ($('#preview1').attr('src') === '' && $('#preview2').attr('src') === '' && $('#preview3').attr('src') === '') {
            preview_check = false;
        }

        $.ajax({
            type: "post",
            url: "{{ route('admin_edit_photo') }}?product_id={{ $product->product_id }}",
            dataType: "json",
            data: {
                product_name: $('#product_name').val(),
                actor_name:   $('#actor_name').val(),
                page:         $('#page').val(),
                price:        $('#price').val(),
                type:         $('#type').val(),
                main_info:    $('#main_info').val(),
                sub_info:     $('#sub_info').val(),
                download_url: $('#download_url').val(),
                preview1:     $('#preview1').attr('src'),
                preview2:     $('#preview2').attr('src'),
                preview3:     $('#preview3').attr('src'),
                preview_check: preview_check
            },
            success: function (result) {
                if (result.type) {
                    toast({
                        type: 'success',
                        title: '寫真編輯成功'
                    }).then((result) => {
                        location.assign('/admin_manage');
                    });
                } else {
                    toast({
                        type: 'error',
                        title: '編輯失敗'
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


    function upload_preview(event) {
        const files = event.target.files;
        console.log(files);
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            const reader = new FileReader();
            reader.addEventListener('load', function (event) {
                switch (i) {
                    case 0:
                        $('#preview1').attr('src', event.target.result);
                        break;
                    case 1:
                        $('#preview2').attr('src', event.target.result);
                        break;
                    case 2:
                        $('#preview3').attr('src', event.target.result);
                        break;
                    default:
                        break;
                }
            });
            reader.readAsDataURL(file);
        }
    }
</script>