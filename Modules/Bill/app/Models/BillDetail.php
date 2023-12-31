<?php

namespace Modules\Bill\app\Models;

use App\Traits\ViewProductWithItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Bill\Database\factories\BillDetailFactory;

class BillDetail extends Model
{
    use HasFactory, ViewProductWithItem;

    protected $fillable = [
        'name',
        'price',
        'amount',
        'product_id',
        'product_item_id',
        'bill_id',
        'note',
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->amount;
    }
}
