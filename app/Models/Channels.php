<?php


namespace App\Models;


use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;


class Channels extends Model
{
    protected $fillable = [
        'uuid', 'title', 'thumbnails', 'subscriber_count', 'view_count', 'video_count', 'published_at'
    ];

}
