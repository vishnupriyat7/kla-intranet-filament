<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HelpdeskStatusHistory extends Model
{
    protected $fillable = [
        'helpdesk_ticket_id',
        'status',
        'remarks',
        'technician_id',
    ];

    public function ticket()
    {
        return $this->belongsTo(HelpdeskTicket::class, 'helpdesk_ticket_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
