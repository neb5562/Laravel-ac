<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'discount_name',
        'product_id',
        'product_off',
        'off_starts_at',
        'off_ends_at',

    ];

    public function product()
    {
        return $this->hasOne(Product::class);
    }

}
