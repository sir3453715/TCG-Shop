<!-- NAVBAR -->
<nav id="header-nav" class="navbar navbar-expand-lg navbar-custom sticky-top">
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
                    <li class="nav-item">
                        <a class="nav-link" href="">需求詢價</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Q&A</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">購物車</a>
                    </li>
                </ul>
            </div>
            <form id="cus-search" class="d-none d-md-flex">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="search in site" aria-label="search in site"
                        aria-describedby="search in site">
                    <span class="input-group-text">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                            </path>
                        </svg>
                    </span>
                </div>
            </form>
            <button id="search-btn" class="d-flex d-md-none btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cus-search-nav"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
     
    </div>
    <div id="cus-search-nav" class="collapse d-md-none px-2 w-100 mt-2">
            <form id="cus-search">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="search in site" aria-label="search in site"
                        aria-describedby="search in site">
                    <span class="input-group-text">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                            </path>
                        </svg> -->
                    </span>
                </div>
            </form>
            </div>
</nav>
<!-- NAVBAR END-->