@inject('MenuItemPresenter','App\Presenters\Admin\MenuItemPresenter')
<aside class="main-sidebar sidebar-light-blue">
    <!-- Brand Logo -->
    <a href="#" style="height:56px;">
        <img src="/storage/image/RHanWorkLogo.png" alt="meihao Logo" class="brand-image elevation-1" style="width: 100%;padding: 10px">
        <span class="brand-text font-weight-light"></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel pb-3 pt-3 d-flex align-items-center">
            <div class="image">
                <i class="nav-icon fas fa-user-circle fa-2x"></i>
            </div>
            <div class="info">
                <a href="{{route('admin.user.edit',['user'=>\Illuminate\Support\Facades\Auth::id()])}}" class="d-block">{{\Illuminate\Support\Facades\Auth::user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{ $MenuItemPresenter->render() }}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
