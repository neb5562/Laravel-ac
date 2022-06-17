<?php

namespace App\Http\Controllers\Admin;

use App\Events\ProductAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Image as Img;
use App\Models\Product;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AdminProductController extends Controller
{
    protected $productValidationTerms = [
        'product_name' => 'required|max:255',
        //'product_categories' => 'required',
        'product_price' => 'required|regex:/^\d{1,13}(\.\d{1,4})?$/',
        'product_count' => 'required|numeric',
        'product_short_description' => 'required',
        'product_full_description' => 'required',
    ];

    protected $time;

    public function products(Req $request)
    {
        $q = $request->input('q');
        $products = Product::where('product_name', 'LIKE', "%".$q."%")
            ->select('products.*', DB::raw('(select images.image_id from images where images.product_id = products.id order by images.id asc limit 1) as product_image'))
            ->orderBy('id', 'DESC')
            ->paginate(10);
        $products->appends(['q' => $q]);
        return view('admin.products', ['products' => $products]);
    }

    public function newProductForm()
    {
        $categories = Category::all();

        return view('admin.newProductForm',['categories' => $categories]);
    }


    public function store(Req $request)
    {
        $this->productValidationTerms['CroppedImage64'] = 'required';

        $request->validate($this->productValidationTerms);

        $images = json_decode($request->CroppedImage64);

        $product =  Product::create([
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'product_count' => $request->product_count,
            'product_short_description' => $request->product_short_description,
            'product_full_description' => $request->product_full_description,
            'product_thumbs_count' => count($images),
        ]);

        if ($product)
        {
            $this->storeProductImages($images,$product);
        }

        foreach ($request->product_categories as $key => $cat) {
            $prod_cats[] = [
                'prod_id' => $product->id,
                'cat_id' => $cat,
            ];
        }
        DB::table('prod_cat')->insert($prod_cats);

        \Session::flash('status', 'პროდუქტი წარმატებით დაემატა. ');

        event(new ProductAddedEvent($product));

        return redirect()->route('admin.products');

    }

    public function showEditForm(Product $product)
    {
        $product_id = $product->id;
        $categories = DB::table('product_categories')
            ->leftJoin('prod_cat', function($join) use ($product_id){
                $join->on('product_categories.id', '=', 'prod_cat.cat_id')
                    ->where('prod_cat.prod_id', '=', $product_id);
            })
            ->select('product_categories.*','prod_cat.cat_id')
            ->get();
        $images = Img::paginate(6);

        return view('admin.editProductForm', ['product' => $product,'categories' => $categories,'images' => $images,'product_id' => $product->id]);
    }

    public function update(Req $request)
    {
        DB::table('prod_cat')
            ->where('prod_id','=',$request->product_id)
            ->delete();

        //$this->productValidationTerms['product_categories'] = 'required|unique:prod_cat,cat_id,prod_id'.$request->product_id;

        $request->validate($this->productValidationTerms);

        $imagesToDelete = json_decode($request->imagesToDelete);

        if($imagesToDelete !== NULL)
        {
            foreach($imagesToDelete as $key => $itd)
            {
                Img::where('image_id', '=', $itd)->where('product_id','=',$request->product_id)->update(['product_id' => null]);
                /*
                File::delete('images/'.$itd.'-132.jpg');
                File::delete('images/'.$itd.'-263.jpg');
                File::delete('images/'.$itd.'-555.jpg');
                File::delete('images/'.$itd.'-original.jpg');
                */
            }
        }

        if(! empty($request->imagesToAdd))
        {
            $toAdd = json_decode ($request->imagesToAdd, true);
            $toAdd = array_filter($toAdd, function($value) { return !is_null($value) && $value !== ''; });
            $doaddData = [];
            foreach($toAdd as $item){
                $doaddData[] = [
                    'image_id' => $item['image_id'],
                    'product_id' => $item['product_id'],
                ];
            }
            //dd($doaddData);
            DB::table('images')->insert($doaddData);
        }

        $images = json_decode($request->CroppedImage64);

        $countDelItems = $imagesToDelete !== NULL ? count($imagesToDelete) : 0;
        $countAddItems = $images !== null ? count($images) : 0;


        $product = Product::find($request->product_id);



        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_count = $request->product_count;
        $product->product_short_description = $request->product_short_description;
        $product->product_full_description = $request->product_full_description;
        //$product->product_thumbs_count = $product->product_thumbs_count - $countDelItems + $countAddItems;

        $product->save();

        if($request->product_categories)
        {
            foreach ($request->product_categories as $key => $cat) {
                $prod_cats[] = [
                    'prod_id' => $request->product_id,
                    'cat_id' => $cat,
                ];
            }
            DB::table('prod_cat')->insert($prod_cats);
        }

        $this->storeProductImages($images,$product);

        \Session::flash('status', 'პროდუქტი წარმატებით განახლდა. დაემატა '.$countAddItems.' სურათი. წაიშალა '.$countDelItems.' სურათი.');

        return redirect()->back();

    }

    public function removeProduct(Req $request)
    {

        $product = Product::findOrFail($request->product_id);
        $images = $product->image->all();

        if ($request->deletephotos !== null)
        {
            Img::where('product_id','=',$request->product_id)->delete();
            foreach($images as $itd)
            {
                File::delete('images/'.$itd->image_id.'-132.jpg');
                File::delete('images/'.$itd->image_id.'-263.jpg');
                File::delete('images/'.$itd->image_id.'-555.jpg');
                File::delete('images/'.$itd->image_id.'-original.jpg');
            }
        }

        try {

            $product->delete();

        }catch(\Exception $e){

            \Session::flash('status', 'პროდუქტის წაშლა არ მოხდა.');
            return redirect()->back();

        }


        \Session::flash('status', 'პროდუქტი წარმატებით წაიშალა.');
        return redirect()->route('admin.products');


    }

    private function storeProductImages($images,$product)
    {
        if(!empty($images))
        {
            //dd($images);
            foreach($images as $key => $image)
            {

                $image_id = md5($image[1] . time());

                Img::create([
                    'image_id' => $image_id,
                    'product_id' => $product->id,
                ]);

                $image_url0 = $image_id."-original.jpg";
                $image_url1 = $image_id."-555.jpg";
                $image_url2 = $image_id."-263.jpg";
                $image_url3 = $image_id."-132.jpg";

                $path0 = public_path().'/'.'images/' . $image_url0;
                $path1 = public_path().'/'.'images/' . $image_url1;
                $path2 = public_path().'/'.'images/' . $image_url2;
                $path3 = public_path().'/'.'images/' . $image_url3;

                $img = Image::make(file_get_contents($image[1]));

                $watermark = Image::make(public_path('/images/watermark-logo.png'));

                $img->insert($watermark, 'bottom-right', 20, 20);

                $img->save($path0);

                $img->resize(555, null, function ($constraint) {
                    $constraint->aspectRatio();
                });


                $img->save($path1);

                $img->resize(263, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($path2);

                $img->resize(132, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($path3);

            }

        }

    }

}
