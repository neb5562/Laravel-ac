<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'url_name',
        'category_name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,'prod_cat','cat_id','prod_id');
    }
}
