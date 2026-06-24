<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'vendor',
        'complaint_id',
        'description',
        'status',
        'report_no',
        'report_description',
        'image',
    ];
}
