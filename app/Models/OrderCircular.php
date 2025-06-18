<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class OrderCircular extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'go_type',
        'sub_type',
        'sub_sub_type',
        'number',
        'date',
        'title',
        'keywords',
        'path',
        'status',
        'section_id'
    ];
    /**
     * Get the section that owns the order circular.
     */
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
