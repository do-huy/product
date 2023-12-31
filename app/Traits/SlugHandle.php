<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugHandle
{
    /**
     * Overide boot model to create slug
     *
     */
    public static function bootSlugHandle()
    {
        self::creating(function ($model) {
            $model->slug = $model->generateSlug();
        });

        self::updating(function ($model) {
            if ($model->getOriginal('name') != $model->getAttribute($model->slugField ?? 'name')) {
                $model->slug = $model->generateSlug();
            }
        });
    }

    /**
     * Generate new Slug
     *
     * @return string
     */
    private function generateSlug()
    {
        $slug = Str::slug($this->getAttribute($this->slugField ?? 'name'));
        $latestSlug = self::where('slug', $slug)
            ->orWhere('slug', 'LIKE', "{$slug}-%")
            ->latest()->value('slug');

        if ($latestSlug) {
            $pieces = explode('-', $latestSlug);
            $number = intval(end($pieces));
            $slug .= '-' . ($number + 1);
        }

        return $slug;
    }
}
