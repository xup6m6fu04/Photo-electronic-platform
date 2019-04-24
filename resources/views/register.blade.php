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
                    <h2 class="section-title mb-40 text-center">註冊帳號</h2>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">信箱</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">密碼</label>
                        <div class="col-sm-10">
                            <input type="password" name="pwd1" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">密碼確認</label>
                        <div class="col-sm-10">
                            <input type="password" name="pwd2" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"><strong class="color-dark"></strong></div>
                        <div class="col-sm-10">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                <label class="custom-control-label" for="customCheck3">我已滿 18 歲且已閱讀並完全同意下方條款聲明</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" id="register_btn" class="btn btn-navy">確認註冊</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="alert alert-success" role="alert">為確保會員收信權益，<br>本站僅可使用 gmail.com  結尾的信箱註冊</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper gray-wrapper">
        <div class="container inner" style="padding-top: 0px">
            <h2 class="section-title mb-20 text-center">本站條款聲明</h2>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div id="accordion1" class="accordion-wrapper bordered">
                        <div class="card">
                            <div class="card-header">
                                <h3> <a data-toggle="collapse" data-parent="#accordion1" href="#collapse1-1">本網站已依『電腦網路內容分級處理辦法』列為限制級。</a> </h3>
                            </div>
                            <div id="collapse1-1" class="collapse show">
                                <div class="card-block">
                                    <p>本網站的內容，完全符合政府『成人頻道必須以鎖碼方式且不得於公開場合播放之原則』，所提供的圖片影片皆通過新聞局審核，非國內新聞局尺度內之影片，本站不予提供，會員須年滿18歲並具有完整行為能力，且須遵守以下條款：</p>
                                    <p>1. 本人不以任何方式將本網站的內容轉載、製作未經同意的超連結、複製或移作他用。</p>
                                    <p>2. 為維護網站資訊提供者的權益，若網站內容違反所在地政府法令，本人願放棄因此引起損失的一切求償權或抗辯權。</p>
                                    <p>3. 本人保證已經是年滿 18 歲並具有自主能力的成年人，進入本站完全是基於自己的意願。</p>
                                    <p>4. 本站有絕對權利控制會員帳號及網站所有服務，不保證所有服務及網站任何功能永遠正常啟用。</p>
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

    const answer = swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: true,
        timer: 30000
    });

    const toast = swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 3000
    });

    $(document).on('click', '#register_btn', function () {
        if ($('#customCheck3').prop('checked') === true) {
            register();
        } else {
            toast({
                type: 'error',
                title: '請先閱讀條款聲明，並確認已滿 18 歲'
            })
        }
    });

    function register() {

        let MyFun = {
            Validate: {
                isEmail: function (para) {
                    return para === '' ? false : !(!/^[^\s]+@[^\s]+\.[^\s]{2,3}$/.test(para));
                }, chkPassword: function (para) {
                    return para === '' ? false : /(?=^.{6,12}$)(?=.*[a-zA-Z])(?=.*[0-9])(?!.*\s).*$/.test(para);
                }
            }
        };


        let email = $('input[type=email]').val().toLowerCase();
        let pwd1 = $('input[name=pwd1]').val();
        let pwd2 = $('input[name=pwd2]').val();

        if (!MyFun.Validate.isEmail(email)) {
            toast({
                type: 'error',
                title: '信箱格式錯誤'
            })
        } else if (email.split("@")[1] !== 'gmail.com') {
            toast({
                type: 'error',
                title: '本站僅可使用 gmail.com 結尾的信箱'
            })
        } else if (!MyFun.Validate.chkPassword(pwd1)) {
            toast({
                type: 'error',
                title: '密碼格式錯誤，請輸入英文+數字且6~12位數'
            })
        } else if (pwd1 !== pwd2) {
            toast({
                type: 'error',
                title: '兩次密碼輸入不同！'
            })
        } else {
            $.ajax({
                type: "post",
                url: "{{ route('registerAction') }}",
                dataType: "json",
                data: {
                    email: email,
                    pwd1: pwd1,
                    pwd2: pwd2,
                },
                success: function (result) {
                    if (result.type) {
                        answer({
                            type: 'success',
                            title: '請前往信箱收取驗證信，方能完成註冊'
                        })
                    } else {
                        toast({
                            type: 'error',
                            title: '信箱輸入錯誤'
                        })
                    }
                    {{--if (result.type) {--}}
                        {{--(async function getCode() {--}}
                            {{--const {value: code} = await swal({--}}
                                {{--title: "<span style='font-size: 24px'>請至信箱收取驗證碼</span>",--}}
                                {{--input: 'text',--}}
                                {{--inputPlaceholder: '',--}}
                                {{--confirmButtonText: '確認送出',--}}
                                {{--confirmButtonColor: '#2b4448',--}}
                                {{--allowOutsideClick: false--}}
                            {{--});--}}

                            {{--if (code) {--}}
                                {{--$.ajax({--}}
                                    {{--type: "post",--}}
                                    {{--url: "{{ route('verifyEmail') }}",--}}
                                    {{--dataType: "json",--}}
                                    {{--data: {--}}
                                        {{--email: email,--}}
                                        {{--code: code,--}}
                                    {{--},--}}
                                    {{--success: function (result) {--}}
                                        {{--if (result.type) {--}}
                                            {{--toast({--}}
                                                {{--type: 'success',--}}
                                                {{--title: '註冊成功！..為您轉至登入頁'--}}
                                            {{--}).then((value) => {--}}
                                                {{--location.assign('{{ route('login') }}');--}}
                                            {{--});--}}
                                        {{--} else {--}}
                                            {{--toast({--}}
                                                {{--type: 'error',--}}
                                                {{--title: '驗證碼輸入錯誤'--}}
                                            {{--})--}}
                                        {{--}--}}
                                    {{--},--}}
                                    {{--error: function () {--}}
                                        {{--toast({--}}
                                            {{--type: 'error',--}}
                                            {{--title: '連線錯誤，請重試或回報客服'--}}
                                        {{--})--}}
                                    {{--}--}}
                                {{--});--}}
                            {{--} else {--}}
                                {{--toast({--}}
                                    {{--type: 'error',--}}
                                    {{--title: '驗證失敗，請前往登入頁面點擊『補寄驗證碼』'--}}
                                {{--})--}}
                            {{--}--}}
                        {{--})()--}}
                    {{--}--}}
                },
                error: function () {
                    toast({
                        type: 'error',
                        title: '錯誤'
                    })
                }
            });

        }
    }

</script>
