<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\LoginLog;
use Illuminate\Http\Request;

class WebLogController extends Controller
{
    //
    public function index(Request $request)
    {
        $tables = $this->getModels();


        $queried = ['id'=>'','table'=>'','action'=>''];

        $action_log = ActionLog::whereNotNull('id');

        if($request->get('id')) {
            $id = $request->get('id');
            $action_log = $action_log->where('action_id',$id);
            $queried['id'] = $id;
        }
        if($request->get('table')) {
            $table = $request->get('table');
            $action_log = $action_log->where('action_table',$table);
            $queried['table'] = $table;
        }
        if($request->get('action')) {
            $action = $request->get('action');
            $action_log = $action_log->where('action',$action);
            $queried['action'] = $action;
        }

        $action_log = $action_log->orderBy('created_at','desc')->paginate(20);

        return view('admin.setting.webHistoryLog',[
            'queried'=>$queried,
            'action_log'=>$action_log,
            'tables'=>$tables,
        ]);
    }

    function getModels(){
        $path = app_path() . "/Models";
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;

            $out[] = substr($result,0,-4);

        }
        return $out;
    }

}
