<?php

namespace App\Traits;

use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductItem;

trait ViewProductWithItem
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productItem()
    {
        return $this->belongsTo(ProductItem::class);
    }

    public function getItemInfo()
    {
        if (!$this->product) {
            return null;
        }

        if (!$this->product->productItems->count() && !$this->productItem) {
            return [
                'image' => $this->product->getFirstMediaUrl('product'),
                'quantity' => $this->product->quantity,
                'price' => $this->product->price,
                'name' => $this->renderProductName(),
            ];
        }

        if (!$this->product->productItems->count()
            || !$this->productItem
            || !$this->product->productItems->pluck('id')->contains($this->productItem->id)
        ) {
            return null;
        }

        $firstMedia = $this->productItem->medias->first();

        return [
            'image' => $firstMedia ? $firstMedia->getUrl() : null,
            'quantity' => $this->productItem->quantity,
            'price' => $this->productItem->price,
            'name' => $this->renderProductName(),
        ];
    }

    public function renderProductName()
    {
        if (!$this->productItem) {
            return $this->product->name;
        }

        return $this->product->name . ', ' . $this->productItem->variantOptions->map(function ($variantOption) {
            return "{$variantOption->variant->name} {$variantOption->value}";
        })->implode(', ');
    }
}
