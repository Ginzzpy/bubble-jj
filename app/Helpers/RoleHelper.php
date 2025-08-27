<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
  public static function hasRole(array $roles, ?string $guard = null): bool
  {
    if (!$guard) {
      foreach (array_keys(config('auth.guards')) as $guardName) {
        $user = Auth::guard($guardName)->user();
        if ($user && isset($user->role) && in_array($user->role->name, $roles)) {
          return true;
        }
      }
      return false;
    }

    $user = Auth::guard($guard)->user();
    if (!$user || !isset($user->role)) {
      return false;
    }

    return in_array($user->role->name, $roles);
  }
}
