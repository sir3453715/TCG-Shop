<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannersController extends Controller
{

    /**
     * index
     */
    function index(Request $request){

        $queried = ['keyword'=>'','status'=>''];
        $banners = Banner::whereNotNull('id');
        if($request->get('keyword')) {
            $keyword = $request->get('keyword');
            $banners = $banners->where('title','LIKE',"%$keyword%");
            $queried['keyword'] = $request->get('keyword');
        }
        if($request->get('status') != '') {
            $status = $request->get('status');
            $banners = $banners->where('status',$status);
            $queried['status'] = $status;
        }
        $banners = $banners->orderBy('created_at','ASC')->paginate(25);

        return view('admin.banners.banners',[
            'queried'=>$queried,
            'banners'=>$banners,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banners.createBanner');
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
            Storage::disk('Banners')->putFileAs('/',$img,$image_name);
            $image = Storage::url('banners/').$image_name;
        }

        $data = [
            'title'=>$request->get('title'),
            'image'=>$image,
            'sort'=>$request->get('sort'),
            'status'=>$request->get('status'),
            'link'=>$request->get('link'),
        ];

        $event = Banner::create($data);
        ActionLog::create_log($event,'新增');

        return redirect(route('admin.banner.index'))->with('message', 'Banner已新增!');

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
        $banner = Banner::find($id);

        return view('admin.banners.editBanner',[
            'banner'=>$banner,
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
        $banner = Banner::find($id);

        $image = $banner->image;
        if($request->hasFile('image')) {
            if($image){
                $oldImageName = explode('/',$banner->image);
                if(Storage::disk('Banners')->exists(end( $oldImageName))){
                    Storage::disk('Banners')->delete(end( $oldImageName));
                }
            }
            $img = $request->file('image');
            $image_name = date('YmdHis').uniqid().'.'.$img->getClientOriginalExtension();
            Storage::disk('Banners')->putFileAs('/',$img,$image_name);
            $image = Storage::url('banners/').$image_name;
        }


        $data = [
            'title'=>$request->get('title'),
            'image'=>$image,
            'sort'=>$request->get('sort'),
            'status'=>$request->get('status'),
            'link'=>$request->get('link'),
        ];

        $banner->fill($data);
        ActionLog::create_log($banner);
        $banner->save();


        return redirect(route('admin.banner.index'))->with('message', 'Banner已修改!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);

        $banner->delete();
        ActionLog::create_log($banner,'刪除');

        return redirect(route('admin.banner.index'))->with('message', 'Banner已刪除!');

    }
}
