<?php

namespace App\Http\Controllers;


use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $latest_product = Product::with(['image','available_discount'])
            ->orderBy('created_at','DESC')
            ->limit(4)
        ->get();

        $discount = DB::table('discounts')->whereRaw("'".date('Y-m-d H:i:s')."' BETWEEN off_starts_at AND off_ends_at")->max('product_off');

        $latest_blogs = Blog::with('image')->orderBy('created_at','DESC')
            ->limit(4)
            ->get();

        return view('home', ['latest_product' => $latest_product,'latest_blogs' => $latest_blogs,'max_discount' => $discount]);
    }

    public function emailSubscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|max:255|email|unique:email_verifications_to_send_guests',
        ]);

        $check1 = DB::table('users')->where('email','=',$request->email)->limit(1)->get();
        $check2 = DB::table('email_subscribers')->where('email','=',$request->email)->limit(1)->get();

        if($check1->isEmpty() && $check2->isEmpty())
        {
            DB::table('email_verifications_to_send_guests')->insert([
                'email' => $request->email,
            ]);
            DB::table('email_subscribers')->insert([
                'name' => null,
                'email' => $request->email,
                'token' => Str::random(33),
                'is_verified' => false
            ]);
        }

        \Session::flash('status', 'თუ ელ.ფოსტა ჩვენს ბაზაში ვერ მოიძებნა თქვენ მიიღებთ ვერიფიკაციის ბმულს. გაითვალისწინეთ, ვერიფიკაციის ბმული
        აქტიური იქნება მოსვლიდან '.config('settings.verification_links_expire_time').' წუთის განმავლობაში!' );

        return redirect()->back();
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function faq()
    {
        $fucks = DB::table('fucks')->get();
        return view('pages.faq',['fucks' => $fucks]);
    }

    public function unsubscribe(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }

        $row = DB::table('email_subscribers')->where('email','=',Crypt::decrypt($request->email))->limit(1)->get();

        if (! $row->count()) {
            abort(404);
        }
        DB::table('email_subscribers')->where('email','=',Crypt::decrypt($request->email))->limit(1)->delete();

        \Session::flash('status', 'სიახლეების სიიდან ამოშლა წარმატებით დასრულდა :(' );

        return redirect()->route('home');
    }
}
