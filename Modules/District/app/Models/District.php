<?php

namespace Modules\District\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\District\Database\factories\DistrictFactory;
use Modules\Province\app\Models\Province;
use Modules\Ward\app\Models\Ward;

class District extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'key_word',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
}
