<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model  implements HasMedia
{
    /** @use HasFactory<\Database\Factories\BlogFactory> */
    use HasFactory, HasUuids, SoftDeletes, InteractsWithMedia;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    protected $hidden = [
        'status',
        'deleted_at',
        'updated_at',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover_image')
            ->singleFile();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
