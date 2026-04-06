<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HelpdeskTicket extends Model
{
    protected $fillable = [
        'ticket_no',
        'employee_id',
        'section',
        'office_location_id',
        'floor',
        'room_id',
        'complaint_type',
        'description',
        'status',
        'technician_id',
        'remarks',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class , 'technician_id');
    }

    public function location()
    {
        return $this->belongsTo(OfficeLocation::class , 'office_location_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class , 'room_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            DB::transaction(function () use ($ticket) {
                    $today = now()->format('Ymd');
                    $count = static::whereDate('created_at', today())
                        ->lockForUpdate()
                        ->count() + 1;
                    $ticket->ticket_no = 'IT-' . $today . '-' . $count;
                }
                );
            });
    }
}