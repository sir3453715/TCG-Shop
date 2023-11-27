<?php

namespace App\Presenters\Admin;

use App\Presenters\Html\HtmlPresenter;
use Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

class AdminTitlePresenter
{

    public function get()
    {
        $siteName = app('Option')->site_name;
        $Pagetitle = Route::getCurrentRoute()->getName();

        $userName = (Auth::check())?Auth::user()->name:'';
        if(Lang::has($Pagetitle)) {
            return trans($Pagetitle) . ' - ' .$userName. ' - ' . $siteName;
        } else {
            return $siteName;
        }
    }
}
