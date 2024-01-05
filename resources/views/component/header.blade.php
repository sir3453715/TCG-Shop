<!-- NAVBAR -->
<nav id="header-nav" class="navbar navbar-expand-lg navbar-custom">
    <div class="container-fluid">
        <div class="col-md-4">
            <button class="btn btn-menu d-md-none p-0 me-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand logo" href="{{route('index')}}">
                <i class="fa-solid fa-diamond"></i>
                Trading Card
            </a>
        </div>
        <div class="d-flex">
            <div id="navbarNav" class="me-3">
                <ul class="navbar-nav">
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="">需求詢價</a>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link" href="">Q&A</a>--}}
{{--                    </li>--}}
                    <li class="nav-item position-relative">
                        <a id="mini-cart" class="nav-link" href="javascript:void(0)">購物車</a>
{{--                        <span class="deck-card-count">{{$card['num']}}</span>--}}
                    </li>
                </ul>
            </div>
            <form id="cus-search" class="d-none d-md-flex" method="get" action="{{route('search')}}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="search in site" aria-label="search in site" aria-describedby="search in site" id="s" name="s">
                    <span class="input-group-text">
                        <button class=" btn border-none p-0 m-0">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <button id="search-btn" class="d-flex d-md-none btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cus-search-nav"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
    <div id="cus-search-nav" class="collapse d-md-none px-2 w-100 mt-2">
            <form id="cus-search" method="get" action="{{route('search')}}">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="search in site" aria-label="search in site" aria-describedby="search in site" id="s" name="s">
                    <span class="input-group-text">
                        <button class=" btn border-none p-0 m-0">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            </div>
</nav>
<!-- NAVBAR END-->