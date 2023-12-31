<?php

namespace App\Traits;

trait ComparativePrice
{
    public function getComparativePriceDiscountAttribute()
    {
        if ($this->productItems && $this->productItems->count()) {
            return $this->productItems->max('comparativePriceDiscount');
        }

        if (!$this->comparative_price || $this->comparative_price == $this->price) {
            return 0;
        }

        $discount = intval(floor(100 * (1 - $this->price / $this->comparative_price)));

        return $discount > 0 ? $discount : 1;
    }
}
