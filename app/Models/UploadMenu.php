<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UploadMenu extends Model
{
    protected $guarded = ['id'];

    protected static function booted()
    {
        static::saved(function ($menu) {
            Cache::forget('menus_all');
        });

        static::deleted(function ($menu) {
            Cache::forget('menus_all');
        });
    }
}
