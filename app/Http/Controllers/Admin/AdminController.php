<?php

namespace App\Http\Controllers\Admin;

use DB;
use Response;
use App\Http\Controllers\Controller;


class AdminController extends Controller
{


    public function __construct()
    {
        $this->time = time();
    }

    public function index()
    {
        $config_data = DB::table('config_data')->first();
        return view('admin.index',['config_data' => $config_data]);
    }


}
