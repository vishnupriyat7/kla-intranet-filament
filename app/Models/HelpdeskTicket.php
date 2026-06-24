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
        return $this->hasMany(HelpdeskStatusHistory::class, 'helpdesk_ticket_id')->latest();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticket) {
            if (empty($ticket->ticket_no)) {
                DB::transaction(function () use ($ticket) {
                    $today = now()->format('Ymd');
                    $count = static::whereDate('created_at', today())
                        ->lockForUpdate()
                        ->count() + 1;
                    $ticket->ticket_no = 'IT-' . $today . '-' . $count;
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