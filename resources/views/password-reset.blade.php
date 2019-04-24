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
            <div class="row">
                <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <h2 class="section-title mb-40 text-center">密碼修改</h2>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">新密碼</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="pwd1" placeholder="New Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">確認新密碼</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="pwd2" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" id="action" class="btn btn-navy">確定修改</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container inner">
            <h2 class="section-title mb-40 text-center">本站條款聲明</h2>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div id="accordion1" class="accordion-wrapper bordered">
                        <div class="card">
                            <div class="card-header">
                                <h3> <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-1">本網站已依『電腦網路內容分級處理辦法』列為限制級。</a> </h3>
                            </div>
                            <div id="collapse1-1" class="collapse show">
                                <div class="card-block">
                                    <p>本網站的內容，完全符合政府『成人頻道必須以鎖碼方式且不得於公開場合播放之原則』，所提供的影片皆通過新聞局審核，非國內新聞局尺度內之影片，本站不予提供，會員須年滿18歲並具有完整行為能力，且須遵守以下條款：</p>
                                    <p>1. 本人不以任何方式將本網站的內容轉載、製作未經同意的超連結、複製或移作他用。</p>
                                    <p>2. 為維護網站資訊提供者的權益，若網站內容違反所在地政府法令，本人願放棄因此引起損失的一切求償權或抗辯權。</p>
                                    <p>3. 本人保證已經是年滿 18 歲並具有自主能力的成年人，進入本站完全是基於自己的意願。</p>
                                    <p>4. 本站有絕對權利控制會員帳號及網站所有服務，不保證所有服務及網站任何功能永遠正常啟用。</p>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3> <a class="collapsed" data-toggle="collapse" data-parent="#accordion1" href="#collapse1-3">＊ 本站絕對禁止未滿 18 歲以上人士進入，請自重！ ＊</a></h3>
                            </div>
                            <div id="collapse1-3" class="collapse">
                                <div class="card-block">
                                    <p>＊ 本站絕對禁止未滿 18 歲以上人士進入，請自重！ ＊</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
@include('layouts.footer_js')
<script>

    $(document).on('click', '#action', function () {
        let MyFun = {
            Validate: {
                chkPassword: function (para) {
                    return para === '' ? false : /(?=^.{6,12}$)(?=.*[a-zA-Z])(?=.*[0-9])(?!.*\s).*$/.test(para);
                }
            }
        }

        const toast = swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });

        let pwd1 = $('#pwd1').val();
        let pwd2 = $('#pwd2').val();

        if (!MyFun.Validate.chkPassword(pwd1)) {
            toast({
                type: 'error',
                title: '密碼格式錯誤，請輸入 6 ~ 12 碼之英文加數字！'
            })
        } else if (pwd1 !== pwd2) {
            toast({
                type: 'error',
                title: '兩次密碼輸入不同！'
            })
        } else {
            $.ajax({
                type: "post",
                url: "{{ route('passwordResetAction') }}",
                dataType: "json",
                data: {
                    pwd1: pwd1,
                    pwd2: pwd2
                },
                success: function (result) {
                    if (result.type) {
                        toast({
                            type: 'success',
                            title: '密碼修改成功！..  將跳轉至登入頁'
                        }).then((value) => {
                            location.assign('{{ route('logout') }}');
                        });
                    } else {
                        toast({
                            type: 'error',
                            title: '修改密碼失敗'
                        })
                    }
                },
                error: function () {
                    toast({
                        type: 'error',
                        title: '系統異常'
                    })
                }
            });

        }
    });

</script>
