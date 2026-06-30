<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendorComplaint extends Model
{
    protected $table = 'vendor_complaints';
    protected $fillable = [
        'vendor',
        'complaint_ticket_id',
        'vendor_complaint_no',
        'complaint_description',
        'status',
        'report_no',
        'chm_remark',
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

    public function complaintTicket()
    {
        return $this->belongsTo(ComplaintRegister::class, 'complaint_ticket_id');
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
