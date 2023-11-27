<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\EventClass;
use Illuminate\Http\Request;

class EventClassesController extends Controller
{

    /**
     * index
     */
    function index(Request $request){

        $eventClasses = EventClass::whereNotNull('id');
        $eventClasses = $eventClasses->orderBy('created_at','ASC')->paginate(25);

        return view('admin.events.eventClasses',[
            'eventClasses'=>$eventClasses,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.events.createEventClass');

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
        ];

        $eventClass = EventClass::create($data);

        ActionLog::create_log($eventClass,'新增');

        return redirect(route('admin.eventClass.index'))->with('message', '活動分類已新增!');

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
        $eventClass = EventClass::find($id);

        return view('admin.events.editEventClass',[
            'eventClass'=>$eventClass,
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
        $eventClass = EventClass::find($id);

        $data=[
            'title'=>$request->get('title'),
        ];
        $eventClass->fill($data);

        ActionLog::create_log($eventClass);
        $eventClass->save();

        return redirect(route('admin.eventClass.index'))->with('message', '活動分類已修改!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $eventClass = EventClass::find($id);


        $eventClass->delete();
        ActionLog::create_log($eventClass,'刪除');

        return redirect(route('admin.eventClass.index'))->with('message', '活動分類已刪除!');
    }
}
