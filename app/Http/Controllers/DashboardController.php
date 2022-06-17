<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Address;
use App\Events\PasswordChangedEvent;
use App\Notifications\PasswordChanged;

class DashboardController extends Controller
{
    public function __construct()
    {
    }


    public function index()
    {
      return view('user.index');
    }

    public function settings()
    {

      $subscriptionStatus = DB::table('email_subscribers')->where('email', '=', auth()->user()->email)->where('is_verified','=', TRUE)->limit(1)->get();
      return view('user.settings', ['is_subscribed' => (isset($subscriptionStatus[0]))]);
    }

    public function toggleEmailSubscription(Request $request)
    {
      //$this->middleware('throttle:6,1')->only('verify', 'resend');

      if($request->user_is_subscribed == 1)
      {
        DB::table('email_subscribers')->insert(['name' => auth()->user()->name, 'email' => auth()->user()->email, 'is_verified' => TRUE]);
        \Session::flash('status', 'სიახლეები გამოწერილია!');
      }
      else if($request->user_is_subscribed == null)
      {
        DB::table('email_subscribers')->where('email', '=',auth()->user()->email)->limit(1)->delete();
        \Session::flash('status', 'სიახლეების გამოწერა გაუქმებულია!' );
      }
      return redirect()->route('user.settings');
    }
    public function address()
    {
      $city = DB::table('city')->get();
      $addresses = Address::where('user_id', auth()->user()->id)->paginate(5);
      return view('user.address', ['city' => $city, 'addresses' => $addresses]);
    }
    public function storeAddress(Request $request)
    {


      $request->validate([
        'address_name' => 'required|max:255',
        'full_name' => 'required|max:255',
        'phone' => 'required|numeric',
        'city' => 'required|numeric|min:0|max:100',
        'address' => 'required|max:255',


      ]);

      $Address =  Address::create([
        'user_id' => auth()->user()->id,
        'address_name' => $request->address_name,
        'full_name' => $request->full_name,
        'phone' => $request->phone,
        'city_id' => $request->city,
        'address' => $request->address,
        'additional_info' => $request->additional_info,
    ]);

    \Session::flash('status', 'მისამართი წარმატებით დაემატა' );

    return redirect()->route('user.address');
    }
    public function orders()
    {
      //return view('dashboard');
    }
}
