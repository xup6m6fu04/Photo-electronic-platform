<nav class="navbar solid nav-wrapper-dark inverse-text navbar-expand-lg">
    <div class="container">
        <div class="navbar-header">
            <div class="navbar-brand">
            	<a href="/">
            		@if(\Illuminate\Support\Facades\Auth::check())
                        {{--<img src="#" srcset="style/images/logo-light.png 1x, style/images/logo-light@2x.png 2x" alt="" />--}}
                    @endif
            	</a>
        	</div>
            <div class="navbar-hamburger ml-auto d-lg-none d-xl-none"><button class="hamburger animate" data-toggle="collapse" data-target=".navbar-collapse"><span></span></button></div>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav ml-auto">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item"><a class="nav-link" href="{{ route('pageCart') }}">購物車</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pageTransaction') }}">我的訂單</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pagePasswordReset') }}">修改密碼</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">回首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">登出</a></li>
                    @if(\Illuminate\Support\Facades\Auth::user()->email == 'sarah82529@gmail.com' || \Illuminate\Support\Facades\Auth::user()->email == 'admin@gmail.com')
                        <li class="nav-item"><a class="nav-link" href="{{ route('admin') }}">管理區</a></li>
                    @endif
                    {{--<li class="nav-item"><a class="nav-link" href="{{ route('collection') }}">我的收藏</a></li>--}}
                @else
                    {{--<li class="nav-item"><a class="nav-link" href="{{ route('donate') }}">贊助我們</a></li>--}}
                    <li class="nav-item"><a class="nav-link" href="{{ route('index') }}">回首頁</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登入 / 註冊</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
