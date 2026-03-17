<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeOffice extends Model
{
    protected $fillable = ['office_name'];
    public function locations()
    {
        return $this->hasMany(OfficeLocation::class);
    }
}
