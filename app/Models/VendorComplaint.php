<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorComplaint extends Model
{
    protected $table = 'complaints';
    protected $fillable = [
        'vendor',
        'complaint_id',
        'description',
        'status',
        'report_no',
        'report_description',
        'image',
        'service_reports',
        'user_id',
    ];

    protected $casts = [
        'service_reports' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($vendor_complaint) {
            if (empty($vendor_complaint->user_id) && auth()->check()) {
                $vendor_complaint->user_id = auth()->id();
            }
        });
    }
}
