<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

class BlogController extends Controller
{
    public $all_blog_categories = null;

    public function __construct()
    {
        $this->all_blog_categories = Blogcategory::withCount('blogs')->get();
    }

    //
    public function index(Request $request, $category = null)
    {
        $title = null;


        if($category !== null)
        {
            $title = BlogCategory::where('url_name', '=',$category)->firstOrFail();
        }
        $q = $request->query('q') ?? null;

        $blogs = Blog::with(['categories'])
            ->when($category, function ($query, $category) {
                return $query->whereHas('categories', function ($query) use ($category) {
                    return $query->where('url_name', '=', $category);
                });
            })
            ->when($q, function($query) use ($q) {
                return $query->where('blog_title','LIKE',"%".$q."%")->orWhere('blog_short_descr','LIKE',"%".$q."%");
            })->paginate(10);

        return view('blog.index',['blogs' => $blogs, 'category' => $category, 'all_blog_categories' => $this->all_blog_categories,'title' => $title]);
    }

    public function blog(Blog $blog)
    {
        $category = null;

        $previous = $blog->previous();
        $next = $blog->next();

       return view('blog.blogpost',['previous'=>$previous,'next' => $next,'blog' => $blog,'all_blog_categories' => $this->all_blog_categories,'category' => $category]);
    }
}
