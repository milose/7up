<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function createUnique()
    {
        $maxTries = 3;
        $slugLength = 4;

        $next = 0;

        while (true) {
            for ($i = 0; $i < $maxTries; $i++) {
                $slug = random_str($slugLength + $next);

                if (!static::find($slug)) {
                    return static::create(compact('slug'));
                }
            }
            $next++;
        }
    }
}
