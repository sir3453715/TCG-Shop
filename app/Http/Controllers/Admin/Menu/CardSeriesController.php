<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\CardSeries;
use Illuminate\Http\Request;

class CardSeriesController extends Controller
{

    /**
     * index
     */
    function index(Request $request){

        $serieses = CardSeries::whereNotNull('id');
        $serieses = $serieses->orderBy('created_at','ASC')->paginate(25);

        return view('admin.cards.series',[
            'serieses'=>$serieses,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $kingdoms = config('cards.kingdoms');
        return view('admin.cards.createSeries',[
            'kingdoms'=>$kingdoms,
        ]);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=[
            'title'=>$request->get('title'),
            'serial_number'=>$request->get('serial_number'),
            'sort'=>$request->get('sort'),
            'kingdom'=>$request->get('kingdom'),
        ];

        $series = CardSeries::create($data);

        ActionLog::create_log($series,'新增');

        return redirect(route('admin.series.index'))->with('message', '卡牌系列已新增!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $series = CardSeries::find($id);
        $kingdoms = config('cards.kingdoms');
        return view('admin.cards.editSeries',[
            'series'=>$series,
            'kingdoms'=>$kingdoms,
        ]);
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
        $series = CardSeries::find($id);

        $data=[
            'title'=>$request->get('title'),
            'serial_number'=>$request->get('serial_number'),
            'sort'=>$request->get('sort'),
            'kingdom'=>$request->get('kingdom'),
        ];
        $series->fill($data);

        ActionLog::create_log($series);
        $series->save();

        return redirect(route('admin.series.index'))->with('message', '卡牌系列已修改!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $series = CardSeries::find($id);


        $series->delete();
        ActionLog::create_log($series,'刪除');

        return redirect(route('admin.series.index'))->with('message', '卡牌系列已刪除!');
    }
}
