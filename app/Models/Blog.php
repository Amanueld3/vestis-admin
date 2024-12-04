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

    protected $appends = ['cover_image', 'estimated_time'];


    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
    ];

    protected $hidden = [
        'media',
        'status',
        'deleted_at',
        'updated_at',
    ];

    public function getCoverImageAttribute()
    {
        if ($this->media->first()) {
            return $this->media->first()->getFullUrl();
        } else {
            return null;
        }
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function getEstimatedTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->body));

        $readingTimeInSeconds = ceil($wordCount / 200 * 60);

        $hours = floor($readingTimeInSeconds / 3600);
        $minutes = floor(($readingTimeInSeconds % 3600) / 60);
        $seconds = $readingTimeInSeconds % 60;

        $timeString = '';
        if ($hours > 0) {
            $timeString .= $hours . ' hour' . ($hours > 1 ? 's' : '') . ' ';
        }
        if ($minutes > 0) {
            $timeString .= $minutes . ' minute' . ($minutes > 1 ? 's' : '') . ' ';
        }
        if ($seconds > 0 || ($hours == 0 && $minutes == 0)) {
            $timeString .= $seconds . ' second' . ($seconds > 1 ? 's' : '');
        }

        return $timeString;
    }
}
