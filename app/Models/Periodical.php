<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Notifications\Notifiable;

class Periodical extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'periodical_master_id',
        'date',
        'path',
        'keywords',
        'status',

    ];
    //Define Relationship with PeriodicalMaster
    public function periodicalMaster()
    {
        return $this->belongsTo(PeriodicalMaster::class);
    }
}
