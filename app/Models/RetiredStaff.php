<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RetiredStaff extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'retired_staffs';
    protected $fillable = [
        'name_eng',
        'name_mal',
        'gender',
        'retired_as',
        'retired_on',
        'address',
        'district',
        'pin',
        'contact_no',
        'kla_id',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->singleFile(); // one photo per staff
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('images');
    }

    public function getFirstMediaUrl($collectionName = 'images', $conversion = '')
    {
        return $this->getMedia($collectionName)->first() ? $this->getMedia($collectionName)->first()->getUrl($conversion) : '';
    }
}
