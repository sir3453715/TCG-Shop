@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="">
                <div class="col-md-12 m-1 slider">
                    <img alt="Bootstrap Image Preview" class="w-100" src="/storage/image/ptcg/poke-banner.jpg" />
                    <img alt="Bootstrap Image Preview" class="w-100" src="/storage/image/ptcg/poke-banner.jpg" />
                    <img alt="Bootstrap Image Preview" class="w-100" src="/storage/image/ptcg/poke-banner.jpg" />
                    <img alt="Bootstrap Image Preview" class="w-100" src="/storage/image/ptcg/poke-banner.jpg" />
                </div>
            </div>
            <div class=" m-5 mt-5">
                <div class="col-md-12">
                    <div class="row">
                        <h1>最新卡牌</h1>
                    </div>
                    <div class="row">
                        @foreach($TWCards as $TWCard)
                            <div class="col-md-2 mb-3">
                                <span>{{$TWCard->name}}</span>
                                <img class="w-100 m-1" src="{{$TWCard->image}}" />
                            </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <h1>最新賽事</h1>
                    </div>
                    <div class="row">
                        @for($i=1;$i<=4;$i++)
                            <div class="col-md-6 mb-3">
                                <div class="bg-secondary w-100" style="height: 300px;"></div>
                                <h3>OOOOOO</h3>
                            </div>
                        @endfor
                    </div>
                    <div class="row">
                        <h1>最新消息</h1>
                    </div>
                    <div class="row">
                        @for($i=1;$i<=4;$i++)
                            <div class="col-md-6 mb-3">
                                <div class="bg-secondary w-100" style="height: 300px;"></div>
                                <h3>XXXXXXX</h3>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('app-scripts')
@endpush
