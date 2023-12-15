<aside id="sidebar-menu">
    <ul class="navbar-nav ml-auto fixed-top">
        <li class="nav-item">
            <a class="nav-link" href="{{route('news')}}">最新活動</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('news')}}">最新賽事</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('deck')}}">推薦牌組</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{route('card')}}">卡牌列表</a>
        </li>
            <li class="btn-toggle collapsed nav-link" data-bs-toggle="collapse" data-bs-target="#account-collapse"
                aria-expanded="false">
                會員中心
            </li>
            <div class="collapse" id="account-collapse">
                <ul class="btn-toggle-nav list-unstyled">
                    @if(\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item sub-nav-item">
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <div class="form-inline">
                                <span class="mr-3"> Hi! {{ \Illuminate\Support\Facades\Auth::user()->name  }}</span>
                                <button class="nav-link btn btn-sm text-danger">登出</button>
                            </div>
                        </form>
                    </li>
                    @else
                    <li class="nav-item sub-nav-item">
                        <a class="nav-link" href="{{route('dashboard')}}">會員資料</a>
                        <a class="nav-link" href="{{route('myDeck')}}">我的牌組</a>
                        <a class="nav-link" href="{{route('wishlist')}}">願望清單</a>
                        <a class="nav-link" href="{{route('order')}}">我的訂單</a>
                        <a class="nav-link" href="{{route('login')}}">登入</a>
                        <a class="nav-link" href="{{route('register')}}">註冊</a>
                        
                    </li>
                    @endif
                </ul>
            </div>
    </ul>
</aside>