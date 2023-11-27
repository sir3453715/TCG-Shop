@php
    unset($deck['count'])
@endphp

<div class="row" >
    @foreach($deck as $CID => $Card)
        <div class="col-md-4 col-6 mb-3 deck-card-info" data-id="{{$CID}}" id="CID-{{$CID}}" >
            <span>{{$Card['name']}}</span>
            <img class="w-100 m-1" src="{{$Card['image']}}" />
            <div class="box">
                <div class="minus changeCardNumber" data-type="minus">-</div>
                <span class="badge badge-secondary cardNumber">{{$Card['number']}}</span>
                <div class="add changeCardNumber" data-type="add">+</div>
            </div>
        </div>
    @endforeach
</div>