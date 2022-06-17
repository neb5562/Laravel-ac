<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\DB;

class AdminDiscountController extends Controller
{
    public function ProductsOffs(Req $request)
    {
        $q = $request->input('q');

        $discounts = DB::table('discounts')
            ->join('products', 'discounts.product_id', '=', 'products.id')
            ->select('discounts.*', 'products.product_name')
            ->where('discount_name', 'like', "%".$q."%")
            ->orWhere('products.product_name', 'LIKE', "%".$q."%")
            ->paginate(10);
        $discounts->appends(['q' => $q]);
        return view('admin.offs', ['discounts' => $discounts]);
    }

    public function newProductsOff()
    {
        $products = Product::select('id', 'product_name')->get();
        return view('admin.newProductsOff', ['products' => $products]);
    }

    public function storeProductsOff(Req $request)
    {
        $request->validate([
            'discount_name' => 'required|max:255',
            'product_id' => 'required',
            'product_off' => 'required|numeric',
            'off_starts_at' => 'required|date',
            'off_ends_at' => 'required|date|after:off_starts_at',
        ]);


        if(array_search('all', $request->product_id) === 0)
        {
            $select_all_products = Product::select('id')->get();
            $temp_data = array();
            foreach($select_all_products as $item)
            {
                $temp_data[] = ['discount_name' => $request->discount_name,
                    'product_id' => $item->id,
                    'product_off' => $request->product_off,
                    'off_starts_at' => $request->off_starts_at,
                    'off_ends_at' => $request->off_ends_at];
            }

            try {

                DB::table('discounts')->insert($temp_data);

            }catch(\Exception $e){

                \Session::flash('status', 'დამატება ვერ მოხდა. გთხოვთ გადაამოწმოთ ფასდაკლება ორჯერ ხომ არ ვრცელდება რომელიმე პროდუქტზე.');

                return redirect()->route('admin.ProductsOffs');

            }

        }
        else
        {
            $temp_data = array();
            foreach($request->product_id as $item)
            {
                $temp_data[] = [
                    'discount_name' => $request->discount_name,
                    'product_id' => \Hashids::connection('product')->decode($item)[0],
                    'product_off' => $request->product_off,
                    'off_starts_at' => $request->off_starts_at,
                    'off_ends_at' => $request->off_ends_at];
            }
            try {

                DB::table('discounts')->insert($temp_data);

            }catch(\Exception $e){

                \Session::flash('status', 'დამატება ვერ მოხდა. გთხოვთ გადაამოწმოთ ფასდაკლება ორჯერ ხომ არ ვრცელდება რომელიმე პროდუქტზე.');

                return redirect()->route('admin.ProductsOffs');

            }
        }

        \Session::flash('status', 'ფასდაკლება წარმატებით დაემატა');

        return redirect()->route('admin.ProductsOffs');




    }

    public function removeProductsOff(Req $request)
    {


        try {

            DB::table('discounts')->where('id', $request->discount_id)->delete();

        }catch(\Exception $e){

            \Session::flash('status', 'ფასდაკლების წაშლა არ მოხდა.');

        }

        \Session::flash('status', 'ფასდაკლება წარმატებით წაიშალა.');

        return redirect()->route('admin.ProductsOffs');

    }
}
