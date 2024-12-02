<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Gallery extends Model implements HasMedia
{
    use HasFactory, HasUuids, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];
    protected $appends = ['image'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    protected $hidden = [
        'media',
        'status',
        'deleted_at',
        'updated_at',
        'created_at',
    ];

    public function getImageAttribute()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl();
        } else {
            return null;
        }
    }
}
