<?php

namespace Modules\Cart\app\Models;

use App\Traits\ViewProductWithItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cart\Database\factories\CartItemFactory;
use Modules\Product\app\Models\Product;
use Modules\User\app\Models\User;

class CartItem extends Model
{
    use HasFactory, ViewProductWithItem;

    const IS_SELECTED = 1;
    const IS_NOT_SELECTED = 0;

    protected $fillable = [
        'cart_id',
        'name',
        'amount',
        'product_id',
        'product_item_id',
        'note',
        'is_selected',
    ];

    protected $appends = ['total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function getTotalAttribute()
    {
        $cartInfo = $this->getItemInfo();

        return $cartInfo ? $cartInfo['price'] * $this->amount : 0;
    }

    public function canCheckout()
    {
        $cartInfo = $this->getItemInfo();

        return $cartInfo['quantity'] > 0
            && $this->product
            && $this->product->status == Product::STATUS_ACTIVE
            && $this->is_selected == CartItem::IS_SELECTED;
    }
}
