<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;
    protected $table = 'blog_categories';

    protected $fillable = [
        'url_name',
        'blog_category_name',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class,'blog_cat','cat_id','blog_id');
    }


}
