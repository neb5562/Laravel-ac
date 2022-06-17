<?php

namespace App\Http\Controllers\Admin;

use App\Events\BlogAddedEvent;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Image as Img;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Request as Req;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class AdminBlogController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $blogs = Blog::with(['image'])->when($q, function($query) use ($q) {
            return $query->where('blog_title','LIKE',"%".$q."%");
        })->paginate(10);

        return view('admin.blogs',['blogs' => $blogs]);
    }

    public function newBlogPost()
    {
        $categories = BlogCategory::all();
        return view('admin.newBlogPost',['categories' => $categories]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|max:255',
            'blog_short_descr' => 'required',
            'blog_full_body' => 'required',
            'CroppedImage64' => 'required',
        ]);

        $images = json_decode($request->CroppedImage64);

        $blog = Blog::create([
            'blog_title' => $request->blog_title,
            'blog_short_descr' => $request->blog_short_descr,
            'blog_full_body' => $request->blog_full_body,
        ]);

        if ($blog)
        {
            $this->storeBlogImages($images,$blog);
        }

        foreach ($request->blog_categories as $key => $cat) {
            $blog_cats[] = [
                'blog_id' => $blog->id,
                'cat_id' => $cat,
            ];
        }
        DB::table('blog_cat')->insert($blog_cats);

        event(new BlogAddedEvent($blog));

        \Session::flash('status', 'ბლოგი წარმატებით დაემატა' );

        return redirect()->route('admin.showPosts');
    }

    public function showEditForm(Blog $blog)
    {
        $blog_id = $blog->id;

        $categories = DB::table('blog_categories')
            ->leftJoin('blog_cat', function($join) use ($blog_id){
                $join->on('blog_categories.id', '=', 'blog_cat.cat_id')
                    ->where('blog_cat.blog_id', '=', $blog_id);
            })
            ->select('blog_categories.*','blog_cat.cat_id')
            ->get();

        return view('admin.editBlogPost', ['blog' => $blog,'categories' => $categories]);
    }

    public function update(Req $request)
    {
        DB::table('blog_cat')
            ->where('blog_id','=',$request->blog_id)
            ->delete();


        $request->validate([
            'blog_title' => 'required|max:255',
            'blog_short_descr' => 'required',
            'blog_full_body' => 'required',
        ]);

        $imagesToDelete = json_decode($request->imagesToDelete);

        if($imagesToDelete !== NULL)
        {
            foreach($imagesToDelete as $key => $itd)
            {
                Img::where('image_id', '=', $itd)->delete();
                File::delete('images/'.$itd.'-132.jpg');
                File::delete('images/'.$itd.'-263.jpg');
                File::delete('images/'.$itd.'-555.jpg');
                File::delete('images/'.$itd.'-original.jpg');
            }
        }

        $images = json_decode($request->CroppedImage64);

        $countDelItems = $imagesToDelete !== NULL ? count($imagesToDelete) : 0;
        $countAddItems = $images !== null ? count($images) : 0;


        $blog = Blog::find($request->blog_id);



        $blog->blog_title = $request->blog_title;
        $blog->blog_short_descr = $request->blog_short_descr;
        $blog->blog_full_body = $request->blog_full_body;

        $blog->save();

        if($request->blog_categories)
        {
            foreach ($request->blog_categories as $key => $cat) {
                $blog_cats[] = [
                    'blog_id' => $request->blog_id,
                    'cat_id' => $cat,
                ];
            }
            DB::table('blog_cat')->insert($blog_cats);
        }

        $this->storeBlogImages($images,$blog);

        \Session::flash('status', 'ბლოგი წარმატებით განახლდა. დაემატა '.$countAddItems.' სურათი. წაიშალა '.$countDelItems.' სურათი.');

        return redirect()->back();

    }



    public function delete(Req $request)
    {

        $blog = Blog::findOrFail($request->blog_id);
        $images = $blog->image->all();

        if ($request->deletephotos !== null)
        {
            Img::where('blog_id','=',$request->blog_id)->delete();
            foreach($images as $itd)
            {
                File::delete('images/'.$itd->image_id.'-132.jpg');
                File::delete('images/'.$itd->image_id.'-263.jpg');
                File::delete('images/'.$itd->image_id.'-555.jpg');
                File::delete('images/'.$itd->image_id.'-original.jpg');
            }
        }

        try {

            $blog->delete();

        }catch(\Exception $e){

            \Session::flash('status', 'ბლოგის წაშლა არ მოხდა.');
            return redirect()->back();

        }


        \Session::flash('status', 'ბლოგი წარმატებით წაიშალა.');
        return redirect()->route('admin.showPosts');


    }
    private function storeBlogImages($images,$blog)
    {
        if(!empty($images))
        {
            //dd($images);
            foreach($images as $key => $image)
            {

                $image_id = md5($image[1] . time());

                Img::create([
                    'image_id' => $image_id,
                    'blog_id' => $blog->id,
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
