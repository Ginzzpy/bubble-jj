<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataJJ extends Model
{
    protected $table = 'data_jj';

    protected $guarded = [
        'id',
    ];

    public function viewer()
    {
        return $this->belongsTo(Viewer::class, 'viewer_id');
    }
}
