<?php

namespace Modules\Carousel\app\Models;

use App\Traits\SlugHandle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Carousel\Database\factories\CarouselFactory;
use Modules\User\app\Models\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Carousel extends Model implements HasMedia
{
    use HasFactory, SlugHandle, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'link',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
