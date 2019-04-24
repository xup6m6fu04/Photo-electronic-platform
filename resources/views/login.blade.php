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
                    <h2 class="section-title mb-40 text-center">登入</h2>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">信箱</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="on">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">密碼</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-2"><strong class="color-dark"></strong></div>
                        <div class="col-sm-10">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck3">
                                <label class="custom-control-label" for="customCheck3">我確認本人已滿 18 歲。</label>
                            </div>
                        </div>
                    </div>
                    @if (isset($verify) && $verify === 'Y')
                    <div class="row">
                        <div class="col-lg-8 offset-lg-2">
                            <div class="alert alert-success" role="alert">信箱驗證成功，請重新登入</div>
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-8"><div class="g-recaptcha" data-sitekey="6LcwcnUUAAAAAFxJjNcN77UKOeHGl7oFOt72v1UF"></div></div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-navy" onclick="login()" >確認登入</button>
                            <a href="/register" class="btn btn-green">註冊帳號</a>
                            <button type="submit" id="lost_pwd" class="btn btn-salmon">忘記密碼</button>
                            {{--<button type="submit" id="test_login_btn" class="btn btn-sky">遊客登入</button>--}}
                            <button type="submit" id="send_code" class="btn btn-purple">重新寄送信箱驗證信</button>
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

    $(document).ready(function () {
        $('body').css('background-color', '#f7f8fc');
    });

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

    const loading = swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
    });

    $('input[type=password]').keypress(function (event) {
        if (event.which === 13) {
            $('#login_btn').click();
        }
    });

    function login() {

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
        let password = $('input[type=password]').val();

        if (!MyFun.Validate.isEmail(email)) {
            toast({
                type: 'error',
                title: '信箱格式錯誤'
            })
        } else if (!MyFun.Validate.chkPassword(password)) {
            toast({
                type: 'error',
                title: '密碼格式錯誤'
            })
        } else if ($('#customCheck3').prop('checked') === false) {
            toast({
                type: 'error',
                title: '請確認已滿 18 歲'
            })
        } else if (grecaptcha.getResponse() === ''){
            toast({
                type: 'error',
                title: '請點選我不是機器人'
            })
        } else {

            loading({
                onOpen: () => {
                    swal.showLoading();
                },
                title: '登入中'
            });

            $.ajax({
                type: "post",
                url: "{{ route('loginAction') }}",
                dataType: "json",
                async: false,
                data: {
                    email: email,
                    password: password,
                    recaptcha: grecaptcha.getResponse()
                },
                success: function (result) {
                    if (result.type === 'captcha') {
                        toast({
                            type: 'error',
                            title: 'Recaptcha 驗證失敗 ! 重導中..'
                        }).then((result) => {
                            location.assign('{{ route('index') }}');
                        })
                    } else if (result.type === 'verify'){
                        toast({
                            type: 'error',
                            title: '請先驗證信箱 ! 重導中..'
                        }).then((result) => {
                            location.assign('{{ route('index') }}');
                        })
                    } else if (result.type){
                        location.assign('{{ route('index') }}');
                    } else {
                        toast({
                            type: 'error',
                            title: '帳號或密碼錯誤！重導中..'
                        }).then((result) => {
                            location.assign('{{ route('index') }}');
                        })
                    }
                },
                error: function () {
                    toast({
                        type: 'error',
                        title: '異常錯誤！重導中..'
                    }).then((result) => {
                        location.assign('{{ route('index') }}');
                    })
                }
            });

        }
    }

    $(document).on('click', '#send_code', function () {

        (async function getEmail() {
            const {value: email} = await swal({
                title: "<span style='font-size: 24px'>請輸入註冊時的信箱</span>",
                input: 'email',
                inputPlaceholder: '',
                confirmButtonText: '確認送出',
                confirmButtonColor: '#2b4448',
            });

            if (email) {
                $.ajax({
                    type: "post",
                    url: "{{ route('sendCode') }}",
                    dataType: "json",
                    data: {
                        email: email
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
                                                    {{--title: '驗證成功！..請重新登入'--}}
                                                {{--})--}}
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
                                {{--}--}}

                            {{--})()--}}
                        {{--} else {--}}
                            {{--toast({--}}
                                {{--type: 'error',--}}
                                {{--title: '信箱輸入錯誤'--}}
                            {{--})--}}
                        {{--}--}}

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

    $(document).on('click', '#lost_pwd', function () {

        (async function getEmail() {
            const {value: email} = await swal({
                title: "<span style='font-size: 24px'>請輸入註冊時的信箱</span>",
                input: 'email',
                inputPlaceholder: '',
                confirmButtonText: '確認送出',
                confirmButtonColor: '#2b4448',
            })

            if (email) {
                $.ajax({
                    type: "post",
                    url: "{{ route('sendResetPasswordMail') }}",
                    dataType: "json",
                    data: {
                        email: email
                    },
                    success: function (result) {
                        if (result.type) {
                            toast({
                                type: 'success',
                                title: '請前往信箱收取修改密碼連結'
                            })
                        } else {
                            toast({
                                type: 'error',
                                title: '信箱錯誤，請重新輸入'
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
