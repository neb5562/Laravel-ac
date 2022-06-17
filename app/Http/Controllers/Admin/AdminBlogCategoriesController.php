<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBlogCategoriesController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::paginate(10);
        return view('admin.blog-categories',['blog_categories' => $categories]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_category_name' => 'required|max:255|unique:blog_categories',
        ]);

        BlogCategory::create([
            'blog_category_name' => $request->blog_category_name,
            'url_name' => str_slug($request->blog_category_name, '-'),
        ]);

        \Session::flash('status', 'ბლოგის კატეგორია წარმატებით დაემატა' );

        return redirect()->route('admin.showPostCategories');
    }
    public function delete(Request $request)
    {
        BlogCategory::where('id',$request->category_id)->delete();
        \Session::flash('status', 'ბლოგის კატეგორია წარმატებით წაიშალა. ');
        return redirect()->route('admin.showPostCategories');
    }
}
