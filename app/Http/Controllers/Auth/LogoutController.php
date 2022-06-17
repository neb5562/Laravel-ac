<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{

    public function __construct()
    {
      $this->middleware(['auth']);
    }
    public function store()
    {

      Auth::logout();
      Session::flush();
      return redirect()->route('home');
    }

}