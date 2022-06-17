<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\Hashidable;

class Product extends Model
{
    use HasFactory;
    use Hashidable;

    protected $appends = ['hashid'];

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_price',
        'product_count',
        'product_short_description',
        'product_full_description',
        'product_thumbs_count',
        'product_sold_count',
    ];

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
    public function available_discount()
    {
        return $this->discount()->whereRaw("'".date('Y-m-d H:i:s')."' BETWEEN off_starts_at AND off_ends_at");
    }

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'prod_cat','prod_id','cat_id');
    }
}
