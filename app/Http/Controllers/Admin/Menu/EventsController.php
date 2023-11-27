<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Event;
use App\Models\EventClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventsController extends Controller
{

    /**
     * index
     */
    function index(Request $request){

        $queried = ['keyword'=>'','dateTime'=>'','class_id'=>'','status'=>'','top'=>''];
        $events = Event::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $events = $events->where('title','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('dateTime')) {
            $dateTime = $request->get('dateTime');
            $events = $events->whereDate('dateTime',$dateTime);
            $queried['dateTime'] = $dateTime;
        }
        if($request->get('class_id')) {
            $class_id = $request->get('class_id');
            $events = $events->where('class_id',$class_id);
            $queried['class_id'] = $class_id;
        }
        if($request->get('status') != '') {
            $status = $request->get('status');
            $events = $events->where('status',$status);
            $queried['status'] = $status;
        }
        if($request->get('top') != '') {
            $top = $request->get('top');
            $events = $events->where('top',$top);
            $queried['top'] = $top;
        }



        $events = $events->orderBy('created_at','ASC')->paginate(25);

        $eventClasses = EventClass::all();

        return view('admin.events.events',[
            'queried'=>$queried,
            'events'=>$events,
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
        $eventClasses = EventClass::all();

        return view('admin.events.createEvent',[
            'eventClasses'=>$eventClasses,
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
        $image = '';
        if($request->hasFile('image')) {
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Events')->putFileAs('/',$img,$image_name);
            $image = Storage::url('events/').$image_name;
        }


        $data = [
            'class_id'=>$request->get('class_id'),
            'title'=>$request->get('title'),
            'image'=>$image,
            'content'=>$request->get('content'),
            'dateTime'=>$request->get('dateTime'),
            'status'=>$request->get('status'),
            'top'=>$request->get('top'),
        ];


        $event = Event::create($data);

        ActionLog::create_log($event,'新增');

        return redirect(route('admin.event.index'))->with('message', '活動已新增!');

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
        $event = Event::find($id);
        $eventClasses = EventClass::all();

        return view('admin.events.editEvent',[
            'eventClasses'=>$eventClasses,
            'event'=>$event,
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
        $event = Event::find($id);

        $image = $event->image;
        if($request->hasFile('image')) {
            if($image){
                $oldImageName = explode('/',$event->image);
                if(Storage::disk('Events')->exists(end( $oldImageName))){
                    Storage::disk('Events')->delete(end( $oldImageName));
                }
            }
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Events')->putFileAs('/',$img,$image_name);
            $image = Storage::url('events/').$image_name;
        }


        $data = [
            'class_id'=>$request->get('class_id'),
            'title'=>$request->get('title'),
            'image'=>$image,
            'content'=>$request->get('content'),
            'dateTime'=>$request->get('dateTime'),
            'status'=>$request->get('status'),
            'top'=>$request->get('top'),
        ];

        $event->fill($data);
        ActionLog::create_log($event);
        $event->save();


        return redirect(route('admin.event.index'))->with('message', '活動已修改!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        $event->delete();
        ActionLog::create_log($event,'刪除');

        return redirect(route('admin.event.index'))->with('message', '活動已刪除!');

    }
}
