<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('is_admin', function (Builder $builder) {
            $builder->where('is_admin', true);
        });
    }
}
