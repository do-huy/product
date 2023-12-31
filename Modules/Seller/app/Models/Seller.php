<?php

namespace Modules\Seller\app\Models;

use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seller\Database\factories\SellerFactory;

class Seller extends Model
{
    use HasFactory, SlugHandle;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'slug',
        'user_id'
    ];

    // protected static function newFactory(): SellerFactory
    // {
    //     //return SellerFactory::new();
    // }
}
