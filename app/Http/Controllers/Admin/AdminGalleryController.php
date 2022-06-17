<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $images = Image::select(DB::raw('count(*) as doubles'),DB::raw('MAX(id) as id'),DB::raw('MAX(image_id) as image_id'))
            ->groupBy('image_id')
            ->paginate(18);

        return view('admin.gallery',['images' => $images]);
    }

    public function download_image(Image $image,$quality)
    {
        return Response::download(public_path('images/').$image->image_id.'-'.$quality.'.jpg');
    }

    public function delete(Request $request)
    {
        $img = Image::find($request->id);
        File::delete('images/'.$img->image_id.'-132.jpg');
        File::delete('images/'.$img->image_id.'-263.jpg');
        File::delete('images/'.$img->image_id.'-555.jpg');
        File::delete('images/'.$img->image_id.'-original.jpg');

        $img->delete();

        \Session::flash('status', 'სურათი წაიშალა');
        return redirect()->back();
    }

    public function imagesAjax(Request $request)
    {
        //if($request->ajax())
        //{
            $images = Image::paginate(6);
            return view('admin.pagination_data_gallery', ['images' => $images, 'product_id' => $request->pid])->render();
        //}
    }

    public function addImageToProductAjax(Request $request)
    {
        if($request->ajax())
        {
            $image = Image::create([
                'image_id' => $request->image_id,
                'product_id ' => $request->pid,
            ]);
            if($image)
            {
                return Response::json(array('success' => true, 'image_added' => 1), 200);
            }
        }
    }
}
