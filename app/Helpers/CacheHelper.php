<?php

namespace App\Helpers;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class CacheHelper
{
  public static function getMenu()
  {
    return Cache::remember('menu', now()->addHours(6), fn() => Menu::all());
  }

  public static function clearMenu()
  {
    Cache::forget('menu');
  }

  public static function refreshMenu()
  {
    self::clearMenu();
    return self::getMenu();
  }
}
