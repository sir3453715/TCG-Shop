@extends('layouts.app')

@section('content')

<div class="news-top p-4 p-lg-5">
    <h1 class="fs-40 fw-bold mb-4 mb-lg-5">賽事內容</h1>
    <img class="img-fluid w-100" src="https://placehold.co/1095x628" alt="">
    <h2 class="fs-2 fw-bold my-5">寶可夢對戰的世界大賽「寶可夢世界錦標賽」首次於日本舉辦！</h2>
    <p class="fs-5 lh-lg">來自世界各地的選手將聚集於此，在《寶可夢朱/紫》、《寶可夢集換式卡牌遊戲》、《Pokémon GO》、《Pokémon
        UNITE》中進行對戰。並且為紀念寶可夢世界錦標賽舉辦，我們將以橫濱港未來為中心，舉辦寶可夢慶典。和寶可夢一起，盡情享受夏季慶典和遊行等多采多姿的活動吧。還有一些特殊區域，您可以在那裡與其他粉絲進行休閒的寶可夢對戰，並觀看錦標賽。​快來跟寶可夢們一起度過愉快的夏天吧！
    </p>
</div>

<div class="news-section m-4 m-lg-5">
    <div class="col-12 my-5 ms-3">
        <div class="news-date">
            <p class="m-0 news-date-number">12<br>/<br>10<br></p>
            <div class="d-flex justify-content-center">
                <p class="news-date-day m-0">周日</p>
            </div>
        </div>
    </div>
    <div class="row news-list">
        <div class="card-wrapper col-md-6 mb-5">
            <div class="card cus-card-news">
                <img src="https://placeholder.co/416x321" class="card-img-top" alt="Card Image">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fs-2">台灣首間Pokémon Center即將在新光三越台北信義新天地A11盛大開幕！</h5>
                    <div class="d-flex mt-5 mb-3">
                        <span class="w-50 fs-5 fw-bold">2023.07.14</span>
                        <span class="w-50 fs-5 fw-bold text-red text-end">大切なお知らせ</span>
                    </div>
                </div>
            </div>
        </div>

        @for($i = 1; $i <= 5; $i++)
        <div class="card-wrapper col-md-6 mb-5">
            <div class="card cus-card-news">
                <img src="https://placeholder.co/416x321" class="card-img-top" alt="Card Image">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fs-2">即將在新光三越台北信義新天地A11盛大開幕！</h5>
                    <div class="d-flex mt-5 mb-3">
                        <span class="w-50 fs-5 fw-bold">2023.07.14</span>
                        <span class="w-50 fs-5 fw-bold text-red text-end">大切なお知らせ</span>
                    </div>
                </div>
            </div>
        </div>
    @endfor

</div>
</div>
@endsection

@push('app-scripts')
@endpush