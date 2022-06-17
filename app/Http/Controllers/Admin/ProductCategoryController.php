<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(10);
        return view('admin.products-categories',['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|unique:product_categories|max:255',
        ]);

        $category = Category::create([
            'category_name' => $request->category_name,
            'url_name' => str_slug($request->category_name, '-')
        ]);

        \Session::flash('status', 'კატეგორია წარმატებით დაემატა. ');

        return redirect()->route('admin.showCategories');

    }

    public function delete(Request $request)
    {
        Category::where('id',$request->category_id)->delete();
        \Session::flash('status', 'კატეგორია წარმატებით წაიშალა. ');
        return redirect()->route('admin.showCategories');
    }
}
