<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.option');
    }
    public function store(Request $request)
    {

        $fields = $request->toArray();
        unset($fields['_token']);
        foreach ($fields as $key => $value) {
            app('Option')->$key = $value;
        }
        $data=[
            'user_id'=>Auth::id(),
            'action_table'=>'App\Models\Option',
            'change_column'=>json_encode($fields),
            'action'=>'update',
        ];
        ActionLog::create($data);



        return redirect(route('admin.option.index'))->with('message','設定修改成功!');



    }

}
