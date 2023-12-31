<?php

namespace Modules\Voucher\app\Models;

use App\Traits\ActiveQuery;
use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Voucher\Database\factories\VoucherFactory;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Carbon;
use Modules\Bill\app\Models\Bill;
use Modules\Seller\app\Models\Seller;

class Voucher extends Model implements HasMedia
{
    use HasFactory, SlugHandle, InteractsWithMedia, ActiveQuery;

    public $slugField = 'code';

    protected $fillable = [
        'code',
        'type',
        'name',
        'discount_amount',
        'quantity',
        'min_order_amount',
        'start_at',
        'expire_at',
        'max_discount_amount',
        'description',
        'status',
        'apply_time',
        'use_for',
        'apply_count',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_PERCENT = 1;
    const TYPE_FIX = 2;

    const APPLY_TIME_ONCE = 1;
    const APPLY_TIME_MANY = 2;

    const USE_FOR_SOME_STORE = 0;
    const USE_FOR_ALL = 1;

    /**
     * Get records is available
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeAvailable($query)
    {
        return $query->active()
            ->where('vouchers.expire_at', '>=', Carbon::now()->toDateTimeString());
    }

    /**
     * The orders that are applied to the seller voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sellerBills()
    {
        return $this->hasMany(Bill::class, 'seller_voucher_id');
    }

    /**
     * The orders that are applied to the platform voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function platformBills()
    {
        return $this->hasMany(Bill::class, 'platform_voucher_id');
    }

    /**
     * The seller that applied the voucher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sellers()
    {
        return $this->belongsToMany(Seller::class);
    }

    /**
     * Check voucher can use
     *
     * @return boolean
     */
    public function canUse()
    {
        return $this->isActive() && Carbon::now()->lte($this->expire_at);
    }

    /**
     * Voucher is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    /**
     * Can apply many times
     *
     * @return boolean
     */
    public function canApplyMany()
    {
        return $this->apply_time == self::APPLY_TIME_MANY;
    }

    /**
     * Can apply many times
     *
     * @return boolean
     */
    public function canUseAllStore()
    {
        return $this->use_for == self::USE_FOR_ALL;
    }

    /**
     * Check can apply for store with voucher is not for all
     *
     * @return boolean
     */
    public function canApplyForSeller($sellerId)
    {
        return !$this->canUseAllStore() && $this->sellers()->whereId($sellerId)->exists();
    }

    /**
     * Can apply for user
     */
    public function canApplyForUser($userId)
    {
        if (!$this->canApplyMany()) {
            if (($this->canUseAllStore() && $this->platformBills()->whereUserId($userId)->exists())
                || !$this->canUseAllStore() && $this->sellerBills()->whereUserId($userId)->exists()) {
                return false;
            }
        }

        return $this->quantity
            ? $this->apply_count < $this->quantity
            : true;
    }

    /**
     * Can apply for cart
     */
    public function canApplyForCart($cart)
    {
        return !$this->min_order_amount || $cart->total_tmp >= $this->min_order_amount;
    }

    public function calculateDiscount($price)
    {
        $discount = $this->type == self::TYPE_FIX
            ? $this->discount_amount
            : floor($this->discount_amount * $price / 100);

        return $this->max_discount_amount && $discount > $this->max_discount_amount
            ? $this->max_discount_amount
            : $discount;
    }
}
