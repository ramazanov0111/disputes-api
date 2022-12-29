<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $fillable = [
        'uuid','title','view_count','like_count','dislike_count','comment_count',
        'published_at','thumbnails', 'channel_id', 'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function channel(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Channels::class, 'uuid', 'channel_id');
    }
}
