<?php

namespace Modules\SubCategory\app\Models;

use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\app\Models\Category;
use Modules\SubCategory\Database\factories\SubCategoryFactory;

class SubCategory extends Model
{
    use HasFactory, SlugHandle;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'status',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // protected static function newFactory(): SubCategoryFactory
    // {
    //     //return SubCategoryFactory::new();
    // }
}
