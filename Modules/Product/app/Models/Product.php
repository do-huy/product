<?php

namespace Modules\Product\app\Models;

use App\Traits\ActiveQuery;
use App\Traits\ComparativePrice;
use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\app\Models\Category;
use Modules\Product\Database\factories\ProductFactory;
use Modules\Seller\app\Models\Seller;
use Modules\SubCategory\app\Models\SubCategory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use
    HasFactory,
    InteractsWithMedia,
    SlugHandle,
    // Searchable,
    ActiveQuery,
    ComparativePrice;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $appends = [
        'price_text',
        'comparative_price_text',
        'comparative_price_discount',
    ];

    protected $fillable = [
        'name',
        'price',
        'comparative_price',
        'slug',
        'content',
        'quantity',
        'seller_id',
        'category_id',
        'sub_category_id',
        'status',
    ];

    public function seller()
        {
            return $this->belongsTo(Seller::class);
        }

        public function category()
        {
            return $this->belongsTo(Category::class);
        }

        public function sub_category()
        {
            return $this->belongsTo(SubCategory::class);
        }

        public function productItems()
        {
            return $this->hasMany(ProductItem::class);
        }

        public function variants()
        {
            return $this->hasMany(Variant::class);
        }

        public function getProductItemSelected(&$variantQuery = [])
        {
            if (empty($this->productItems)) {
                return null;
            }

            // prepare variant query
            $this->variants()
                ->with('variantOptions')
                ->get()
                ->each(function ($variant, $index) use (&$variantQuery) {
                    if (!isset($variantQuery[$index]) || !$variant->variantOptions->contains('value', $variantQuery[$index])) {
                        $variantQuery[$index] = $variant->variantOptions->first()->value;
                    }
                });

            return $this->productItems->first(function ($productItem) use ($variantQuery) {
                return compareIsEqualArray(
                    $productItem->variantOptions->pluck('value')->toArray(),
                    $variantQuery
                );
            });
        }

        public function scopeSimilar($query, $product, ...$relations)
        {
            foreach ($relations as $relation) {
                if ($this->{$relation}) { // kiểm tra xem có tồn tại quan hệ đó hay không? nếu có thì tìm không có thì bỏ qua
                    $query->whereHas($relation, function ($subQuery) use ($product, $relation) { // thêm điều kiện vào $query
                        $names = $product->{$relation}->pluck('name'); // lấy ra tên của các quan hệ có tại sản phẩm gốc
                        $subQuery->whereIn('name', $names); // tìm kiếm theo tên các quan hệ đã lấy ở trên
                    });
                }
            }
        }

        public function getComparativePriceTextAttribute() {
            return implode(" - ",
                array_map(function ($pr) {
                    return $pr ? number_format($pr, 0, '', ',') . '₫' : '' ;
                }, $this->rangerPrice('comparative_price')
            ));
        }

        public function getPriceTextAttribute()
        {
            return implode(" - ",
                array_map(function ($pr) {
                    return number_format($pr, 0, '', ',') . '₫';
                }, $this->rangerPrice('price')
            ));
        }

        public function maxComparativePriceDiscount()
        {
            if (!$this->productItems->count()) {
                return $this->comparativePriceDiscount;
            }

            return $this->productItems->max('comparativePriceDiscount');
        }

        public function rangerPrice($fieldPrice = 'price')
        {
            if (!$this->productItems->count()) {
                return [$this->{$fieldPrice}];
            }

            $min = $this->productItems->min($fieldPrice);
            $max = $this->productItems->max($fieldPrice);

            if ($min === null && $max === null) {
                return [];
            }

            return ($min == $max) ? [$min] : [$min, $max];
        }



}
