<?php

namespace Modules\Cart\app\Models;

use App\Traits\Voucherable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Database\factories\CartFactory;
use Modules\Seller\app\Models\Seller;
use Modules\User\app\Models\User;

class Cart extends Model
{
    use HasFactory, Voucherable;

    protected $fillable = [
        'user_id',
        'seller_id',
        'seller_voucher_id',
        'platform_voucher_id',
        'note',
    ];

    protected $appends = ['total', 'amount', 'seller_discount_tmp', 'platform_discount_tmp'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function getTotalAttribute()
    {
        $total = $this->total_tmp - $this->seller_discount_tmp - $this->platform_discount_tmp;

        return $total > 0 ? $total : 0;
    }

    public function getTotalTmpAttribute()
    {
        return $this->cartItems
            ->filter(function ($cartItem) {
                return $cartItem->canCheckout();
            })
            ->sum(function ($cartItem) {
                return $cartItem->total;
            });
    }

    public function getAmountAttribute()
    {
        return $this->cartItems
            ->filter(function ($cartItem) {
                return $cartItem->canCheckout();
            })
            ->sum(function ($cartItem) {
                return $cartItem->amount;
            });
    }
}
