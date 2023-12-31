<?php

namespace Modules\Ward\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\District\app\Models\District;
use Modules\Ward\Database\factories\WardFactory;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'key_word',
        'district_id'
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }
}
