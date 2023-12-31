<?php

namespace Modules\Product\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\VariantFactory;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_id',
        'category_id',
    ];

    public function variantOptions()
    {
        return $this->hasMany(VariantOption::class);
    }
}
