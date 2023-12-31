<?php

namespace Modules\Province\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\District\app\Models\District;
use Modules\Province\Database\factories\ProvinceFactory;
use Modules\Ward\app\Models\Ward;

class Province extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'key_word',
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function wards()
    {
        return $this->hasManyThrough(Ward::class,District::class);
    }
}
