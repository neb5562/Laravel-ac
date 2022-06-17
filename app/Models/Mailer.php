<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailer extends Model
{
    use HasFactory;
    protected $table = 'email_subscribers';


    protected $fillable = [
        'name',
        'email',
        'token',
        'is_verified',
    ];
}
