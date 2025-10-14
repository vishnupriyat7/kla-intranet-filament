<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Section extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'status'
    ];
    /**
     * Get the order circulars for the section.
     */
    public function orderCirculars()
    {
        return $this->hasMany(OrderCircular::class, 'section_id');
    }
}
