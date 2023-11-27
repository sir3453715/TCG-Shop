
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('index')}}" class="mr-1">
                <button class="btn btn-success btn-sm">前台網站</button>
            </a>
        </li>
        @if(\Illuminate\Support\Facades\Auth::user()->hasRole('administrator'))
        <li>
            <a href="{{ route('admin.clear-cache') }}">
                <button class="btn btn-outline-danger btn-sm">清除快取</button>
            </a>
        </li>
        @endif
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link" data-toggle="dropdown" href="#">--}}
{{--                <i class="far fa-bell"></i>--}}
{{--                <span class="badge badge-danger navbar-badge">3</span>--}}
{{--            </a>--}}
{{--            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
{{--                <div class="dropdown-divider"></div>--}}
{{--                <a href="#" class="dropdown-item">--}}
{{--                    <i class="fas fa-file-invoice-dollar mr-2"></i>有 3 張訂單--}}
{{--                </a>--}}
{{--            </div>--}}
{{--        </li>--}}
        <li class="nav-item dropdown">
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="nav-link btn btn-outline-danger btn-sm text-danger">登出<i class="fas fa-sign-out-alt ml-1"></i></button>
            </form>
        </li>
    </ul>
</nav>
