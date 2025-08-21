<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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
        'year',
        'title',
        'keywords',
        'path',
        'status',
        'title_length',
        'error_type',
        'updated_by',
        'section_id',
        'title_lingo',
        'link'
    ];
    /**
     * Get the section that owns the order circular.
     */
    public function sections()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
    /**
     * Get the user who updated the order circular.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($orderCircular) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user) {
                $orderCircular->updated_by = $user->id;
            }
        });

        static::updating(function ($orderCircular) {
            /** @var \App\Models\User|null $user */
            $user = Auth::user();
            if ($user) {
                $orderCircular->updated_by = $user->id;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'sub_type');
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_sub_type');
    }
}
