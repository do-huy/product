<?php

namespace Modules\User\app\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Modules\Address\app\Models\Address;
use Modules\Bill\app\Models\Bill;
use Modules\Cart\app\Models\Cart;
use Modules\Seller\app\Models\Seller;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SlugHandle;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'slug',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }


    public function addresses()
    {
        return $this->hasMany(Address::class);
    }


    public function getAmountCartAttribute()
    {
        return $this->carts()
            ->with('cartItems')
            ->get()
            ->sum(function ($cart) {
                return $cart->cartItems->count();
            });
    }

    public function getAmountCartSelectedCanBuyAttribute()
    {
        return $this->carts()
            ->with('cartItems')
            ->get()
            ->sum(function ($cart) {
                return $cart->amount;
            });
    }

    public function getTotalSelectedCanBuyAttribute()
    {
        return $this->carts()
            ->with('cartItems')
            ->get()
            ->sum(function ($cart) {
                return $cart->total;
            });
    }

}
