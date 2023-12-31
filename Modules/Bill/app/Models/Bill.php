<?php

namespace Modules\Bill\app\Models;

use App\Traits\Voucherable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bill\Database\factories\BillFactory;

class Bill extends Model
{
    use HasFactory, Voucherable;

    const STATUS_NEW = 'new';
    const STATUS_PACKING = 'packing';
    const STATUS_TRANSPORT = 'transport';
    const STATUS_SUCCESS = 'success';
    const STATUS_REFUND = 'refund';
    const STATUS_ERROR = 'error';

    const PAYMENT_PAY = 'pay';
    const PAYMENT_DEBT = 'debt';
    const DEFAULT_SHIPPING_FEE = 20000;

    protected $fillable = [
        'address',
        'receiver_name',
        'receiver_phone',
        'note',
        'user_id',
        'seller_id',
        'payment',
        'status',
        'transport_at',
        'success_at',
        'total',
        'tax',
        'shipping_fee',
        'seller_voucher_id',
        'platform_voucher_id',
        'seller_discount',
        'platform_discount',
    ];

    public function billDetails()
    {
        return $this->hasMany(BillDetail::class);
    }
}
