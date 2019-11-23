<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUUID
{
    public static function bootHasUUID()
    {
        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyName()
    {
        return 'id';
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function getKeyType()
    {
        return 'string';
    }
}
