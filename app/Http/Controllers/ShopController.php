<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use DB;

class ShopController extends Controller
{
    public function index(Request $request, $category = null)
    {
        $title = null;
        if($category !== null)
        {
          $title = Category::where('url_name', '=',$category)->firstOrFail();
        }

      $sort = ($request->has('sort')) ? $request->query('sort') : 1 ;
      $show = ($request->has('show')) ? $request->query('show') : 1 ;

      $q = $request->query('q') ?? null;

      $paginate = array(1 => 9, 2 => 12, 3 => 15);

      $toSort = array(1 => array( 1 => 'products.created_at', 2 => 'desc'),
                      2 => array(1 => 'products.product_sold_count', 2 => 'desc'),
                      3 => array(1 => 'products.product_price', 2 =>'asc'),
                      4 => array(1 => 'products.product_price', 2 =>'desc'));

      if(! array_key_exists($show,$paginate) || ! array_key_exists($sort,$toSort))
      {
          abort('404');
      }

        $products = Product::with(['image','available_discount','categories'])
            ->when($category, function ($query, $category) {
                return $query->whereHas('categories', function ($query) use ($category) {
                    return $query->where('url_name', '=', $category);
                });
            })
            ->when($q, function($query) use ($q) {
                return $query->where('product_name','LIKE',"%".$q."%");
            })
            ->orderBy($toSort[$sort][1], $toSort[$sort][2])
            ->paginate($paginate[$show]);

        $categories = Category::withCount('products')->get();

      return view('shop.index', ['products' => $products ,  'category' => $category, 'sort' => $sort, 'show' => $show, 'categories' => $categories,'title' => $title]);

    }


    public function product(Product $product)
    {
      return view('shop.product', ['product' => $product]);
    }
}
