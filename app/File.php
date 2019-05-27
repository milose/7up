<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_image' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function setExpiresAtAttribute()
    {
        $this->attributes['expires_at'] = $this->attributes['size'] > 262144
            ? now()->addhours(7)
            : now()->addDays(7);
    }

    public static function createWithSlug(array $values)
    {
        $maxTries = 3;
        $slugLength = 4;

        $next = 0;

        // @TODO: There must be a better way to generate unique slug.
        while (true) {
            for ($i = 0; $i < $maxTries; $i++) {
                $slug = random_str($slugLength + $next);

                if (!static::find($slug)) {
                    return static::create($values + [
                        'slug' => $slug,
                        'expires_at' => null,
                    ]);
                }
            }
            $next++;
        }
    }
}
