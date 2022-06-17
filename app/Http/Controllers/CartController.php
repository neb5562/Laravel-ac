<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use DateTime;
use App\Models\Product;
use App\Models\Address;
use App\Models\Image as Img;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index()
    {
        //dd(Cart::Content());
        $addresses = null;
        if (Auth::check()) {
            $addresses = Address::where('user_id', auth()->user()->id)->get();
        }

        $d_now = new \DateTime();

        foreach(Cart::content() as $key => $ifd)
        {
            $p_ends = new \DateTime($ifd->options->discount_ends);

            Cart::setDiscount($ifd->rowId, ($ifd->options->discount > 0) ? $ifd->options->discount : 0);
            
            if($p_ends < $d_now)
            {
                Cart::setDiscount($ifd->rowId, 0);
            }
        }

        //Cart::destroy();
        return view('shop.cart',['addresses' => $addresses]);
        //return Cart::content();
    }

    public function store(Request $request)
    {   

        
        $product = Product::where('products.id', \Hashids::decode($request->productId)[0] ?? null)
        ->leftJoin('discounts', function($join){
            $join->on('products.id', '=', 'discounts.product_id')
            ->whereRaw("'".date('Y-m-d H:i:s')."' BETWEEN discounts.off_starts_at AND discounts.off_ends_at");
          })
          ->select('products.*', 'discounts.product_id', 'discounts.product_off','discounts.off_starts_at','discounts.off_ends_at')
          ->firstOrFail();
        $img = $product->image()->first();

        Cart::add(
            ['id' => $request->productId, 
            'name' => $product->product_name, 
            'qty' => $request->qty, 
            'price' => $product->product_price, 
            'weight' => 0,
            'options' => ['thumbnail' => (!isset($img->image_id)) ? null :$img->image_id,
                          'discount' => $product->product_off,
                          'discount_ends' => $product->off_ends_at,
            ]]);

        // set discounts
        
        return redirect()->route('cart.index');
    }

    public function remove(Request $request)
    {
        Cart::remove($request->rowId);

        return redirect()->route('cart.index');
    }

    public function update(Request $request)
    {

        Cart::update($request->rowId,$request->itemCount);

        return redirect()->route('cart.index');
    }

}
