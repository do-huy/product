<?php

namespace App\Traits;


use Modules\Voucher\app\Models\Voucher ;

trait Voucherable
{
    public function sellerVoucher()
    {
        return $this->belongsTo(Voucher::class, 'seller_voucher_id');
    }

    public function getSellerDiscountTmpAttribute()
    {
        if (!$this->sellerVoucher) {
            return 0;
        }

        return $this->sellerVoucher->calculateDiscount($this->total_tmp);
    }

    public function getPlatformDiscountTmpAttribute()
    {
        if (!$this->platformVoucher) {
            return 0;
        }

        return $this->platformVoucher->calculateDiscount($this->total_tmp);
    }

    public function platformVoucher()
    {
        return $this->belongsTo(Voucher::class, 'platform_voucher_id');
    }
}
