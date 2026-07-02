<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ComplaintRegister extends Model
{
    protected $table = 'complaint_tickets';

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
        'vendor_complaint_id',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function location()
    {
        return $this->belongsTo(OfficeLocation::class, 'office_location_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function statusHistories()
    {
        return $this->hasMany(ComplaintRegisterStatusHistory::class, 'helpdesk_ticket_id')->latest();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_no)) {
                DB::transaction(function () use ($ticket) {
                    $year = now()->format('Y');
                    $count = static::whereYear('created_at', now()->year)
                        ->lockForUpdate()
                        ->count() + 1;
                    
                    // Format: IT-YYYY0001
                    $ticket->ticket_no = 'IT-' . $year . str_pad($count, 4, '0', STR_PAD_LEFT);
                });
            }
        });

        static::saved(function ($ticket) {
            $isNew = $ticket->wasRecentlyCreated;
            $statusChanged = $ticket->wasChanged('status');
            $remarksChanged = $ticket->wasChanged('remarks');
            $techChanged = $ticket->wasChanged('technician_id');

            if ($isNew || $statusChanged || $remarksChanged || $techChanged) {
                $ticket->statusHistories()->create([
                    'status' => $ticket->status ?? 'Open',
                    'remarks' => $ticket->remarks ?? ($isNew ? 'Ticket created' : 'Status/Remarks updated'),
                    'technician_id' => $ticket->technician_id,
                ]);
            }
        });
    }
}