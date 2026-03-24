<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            $ticket->ticket_no = 'IT-' . now()->format('dmY') . '-' . rand(1000, 9999);
        });
    }
}