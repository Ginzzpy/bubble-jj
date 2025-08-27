<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public $timestamps = false;

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class, 'role_id');
    }

    public function viewers(): HasMany
    {
        return $this->hasMany(Viewer::class, 'role_id');
    }
}
