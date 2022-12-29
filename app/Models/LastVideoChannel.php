<?php


namespace App\Models;


use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

class LastVideoChannel extends Model
{
    protected $table = 'last_video_channel';
    protected $hidden = ['id'];
    protected $fillable = ['channel_id', 'video_id', 'published_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function channel(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Channels::class, 'uuid', 'channel_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function video(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Videos::class, 'uuid', 'video_id');
    }
}
