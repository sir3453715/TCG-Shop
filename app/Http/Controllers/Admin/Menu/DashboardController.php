<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Exports\DemoExport;
use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use DuskCrawler\Dusk;
use Facebook\Facebook;
use Facebook\FacebookRequest;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Crawler\Crawler;
use Spatie\Crawler\CrawlObservers\CrawlObserver;

class DashboardController extends Controller
{
    /**
     * index
     */
    function index(Request $request){

        $isAdmin = Auth::user()->hasRole('vendor');

        if($isAdmin){
            $login_log = LoginLog::where('user_id',Auth::id())->orderBy('created_at','desc')->limit(25)->get();
        }else{
            $login_log = LoginLog::orderBy('created_at','desc')->limit(25)->get();
        }



        return view('admin.dashboard.dashboard',[

            'login_log'=>$login_log,
        ]);

    }

}
