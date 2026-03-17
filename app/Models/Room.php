<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'floor',
        'block',
        'office_location_id'
    ];

    public function location()
    {
        return $this->belongsTo(OfficeLocation::class, 'office_location_id');
    }
}
