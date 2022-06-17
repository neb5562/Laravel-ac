<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class Blog extends Model
{
    use HasFactory;
    use Hashidable;

    protected $table = 'blog_posts';


    protected $fillable = [
        'blog_title',
        'blog_short_descr',
        'blog_full_body',

    ];

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class,'blog_cat','blog_id','cat_id');
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function next()
    {
        return Blog::where('id', '>', $this->id)->orderBy('id','asc')->first();
    }
    public function previous()
    {
        return Blog::where('id', '<', $this->id)->orderBy('id','asc')->first();
    }
}
