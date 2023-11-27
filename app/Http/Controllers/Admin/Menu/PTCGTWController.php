<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Exports\DemoExport;
use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\PtcgCard;
use App\Models\PtcgTwCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Pokemon\Pokemon;

class PTCGTWController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $queried = ['keyword'=>'','supertypes'=>'', 'rarity'=>'', 'type'=>'','set'=>['']];
        $cards = PtcgTwCard::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $cards = $cards->where('name','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('supertypes')) {
            $supertypes = $request->get('supertypes');
            $cards = $cards->where('supertypes',$supertypes);
            $queried['supertypes'] = $supertypes;
        }
        if($request->get('rarity')) {
            $rarity = $request->get('rarity');
            $cards = $cards->where('rarity',$rarity);
            $queried['rarity'] = $rarity;
        }
        if($request->get('type')) {
            $type = $request->get('type');
            $cards = $cards->where('types','LIKE',"%$type%");
            $queried['type'] = $type;
        }
        if($request->get('set')) {
            $set = $request->get('set');
            $cards = $cards->whereIn('set_id',$set);
            $queried['set'] = $set;
        }
        $cards = $cards->orderBy('created_at','ASC')->paginate(20);

//
        $supertypes = ['寶可夢卡','寶可夢道具','支援者卡','物品卡','競技場卡','能量卡'];
        $types = ['Grass'=>'草', 'Fire'=>'火', 'Water'=>'水', 'Lightning'=>'雷', 'Psychic'=>'超', 'Fighting'=>'鬥','Darkness'=>'惡', 'Metal'=>'鋼', 'Fairy'=>'妖', 'Dragon'=>'龍', 'Colorless'=>'無'];
        $rarities =['C','U','R','RR','RRR','PR','TR','SR','K','AR','SAR','無標記'];


        return view('admin.ptcg.ptcgTWCards',[
            'queried'=>$queried,
            'cards'=>$cards,
            'rarities'=>$rarities,
            'types'=>$types,
            'sets'=>$supertypes,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $card = PtcgCard::find($id);
//
//        Pokemon::Options(['verify' => true]);
//        Pokemon::ApiKey('804a3a3c-4a5e-4d03-bf65-881bbc9489d7');
//        $rarities = Pokemon::Rarity()->all();
//        $types = Pokemon::Type()->all();
//
//        return view('admin.ptcg.editPtcgCard',[
//            'card'=>$card,
//            'rarities'=>$rarities,
//            'types'=>$types,
//        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

//        $card = PtcgCard::find($id);
//        $image_small_tw = ''; $image_small_jp = '';
//        if($request->get('image_tw_change_check')){
//            if($request->hasFile('image_large_tw')) {
//                if($card->image_small_tw){
//                    if(Storage::disk('ptcgTWCard')->exists($card->image_small_tw)){
//                        Storage::disk('ptcgTWCard')->delete($card->image_small_tw);
//                    }
//                }
//                $img = $request->file('image_large_tw');
//                $image_small_tw = $card->CID.'.'.$img->getClientOriginalExtension();
//                Storage::disk('ptcgTWCard')->putFileAs('/',$img,$image_small_tw);
//                $image_large_tw = Storage::url('ptcg/twCard/').$image_small_tw;
//            }
//        }
//        if($request->get('image_jp_change_check')){
//            if($request->hasFile('image_large_jp')) {
//                if($card->image_small_jp){
//                    if(Storage::disk('ptcgJPCard')->exists($card->image_small_jp)){
//                        Storage::disk('ptcgJPCard')->delete($card->image_small_jp);
//                    }
//                }
//                $img = $request->file('image_large_jp');
//                $image_small_jp = $card->CID.$img->getClientOriginalExtension();
//                Storage::disk('ptcgJPCard')->put($image_small_jp,$img);
//                $image_large_jp = Storage::url('ptcg/jpCard/').$image_small_jp;
//            }
//        }
//
//        $data = [
//            'name_tw'=>$request->get('name_tw'),
//            'name_jp'=>$request->get('name_jp'),
//            'supertypes'=>$request->get('supertypes'),
//            'hp'=>$request->get('hp'),
//            'types'=>json_encode($request->get('types')),
//            'rarity'=>$request->get('rarity'),
//            'unlimited'=>($request->get('unlimited'))?true:false,
//            'standard'=>($request->get('standard'))?true:false,
//            'expanded'=>($request->get('expanded'))?true:false,
//            'image_small_tw'=>($image_small_tw)??'',
//            'image_large_tw'=>($image_large_tw)??'',
//            'image_small_jp'=>($image_small_jp)??'',
//            'image_large_jp'=>($image_large_jp)??'',
//        ];
//        $card->fill($data);
//        $card->update();
//
//        return redirect(route('admin.ptcg-card.index'))->with('message',
//            '卡牌已更新!');
//        return redirect(route('admin.ptcg-card.edit',['ptcg_card'=>$card->id]))->with('message',
//            '卡牌已更新!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
