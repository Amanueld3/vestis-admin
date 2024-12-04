<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model  implements HasMedia
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, HasUuids, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];
    protected $appends = ['avatar'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    protected $hidden = [
        'status',
        'deleted_at',
        'updated_at',
    ];

    public function getAvatarAttribute()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl();
        } else {
            return null;
        }
    }
}
