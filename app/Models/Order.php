<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'data_order';

    protected $guarded = [
        'id',
    ];

    public function files()
    {
        return $this->hasMany(File::class, 'order_id');
    }

    public function viewer()
    {
        return $this->belongsTo(Viewer::class, 'viewer_id');
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
