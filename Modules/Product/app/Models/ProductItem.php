<?php

namespace Modules\Product\app\Models;

use App\Traits\ComparativePrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\ProductItemFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

class ProductItem extends Model
{
    use HasFactory, ComparativePrice;

    protected $appends = [
        'price_text',
        'comparative_price_text',
        'comparative_price_discount',
    ];

    protected $fillable = [
        'product_id',
        'price',
        'comparative_price',
        'quantity',
        'sku',
        'first_variant_option_id',
    ];

    public function variantOptions()
    {
        return $this->belongsToMany(
            VariantOption::class,
            'product_item_options',
        );
    }

    public function getMediasAttribute()
    {
        return $this->variantOptions->reduce(function ($carry, $variantOption) {
            return $carry->concat($variantOption->getMedia('variant_option_images'));
        }, new MediaCollection());
    }

    public function getComparativePriceTextAttribute()
    {
        return $this->comparative_price
            ? number_format($this->comparative_price, 0, '', ',') . '₫'
            : '';
    }

    public function getPriceTextAttribute()
    {
        return number_format($this->price, 0, '', ',');
    }
}
