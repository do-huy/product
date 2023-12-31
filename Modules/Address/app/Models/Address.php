<?php

namespace Modules\Address\app\Models;

use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Address\Database\factories\AddressFactory;
use Modules\District\app\Models\District;
use Modules\Province\app\Models\Province;
use Modules\User\app\Models\User;
use Modules\Ward\app\Models\Ward;

class Address extends Model
{
    use HasFactory, SlugHandle;

    protected $fillable = [
        'name', 'phone', 'description', 'status', 'user_id', 'province_id', 'district_id', 'ward_id', 'is_default'
    ];

    protected $slugField = 'phone';

    protected $appends = ['full'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    public function getFullAttribute()
    {
        $fullAddress = $this->attributes['description'].', '.
                        $this->ward->name.', '.
                        $this->district->name.', '.
                        $this->province->name.', Việt Nam';
        return $fullAddress;
    }
}
