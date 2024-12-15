<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Form extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;


    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'course',
        'course_number',
        'company_name',
        'position',
        'role',
        'photo',
    ];

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image');
    }

    public function getImageUrlAttribute()
    {
        $media = $this->getFirstMedia('image');
        return $media ? $media->getUrl() : null;
    }

}
