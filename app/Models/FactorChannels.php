<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class FactorChannels extends Model
{
    const TYPE_FACTOR_VIEW = 'view';
    const TYPE_FACTOR_LIKE = 'like';
    const TYPE_FACTOR_DISLIKE = 'dislike';
    const TYPE_FACTOR_COMMENTS = 'comment';
    CONST TYPE_FACTOR_ALL = [
        self::TYPE_FACTOR_VIEW,
        self::TYPE_FACTOR_COMMENTS,
        self::TYPE_FACTOR_DISLIKE,
        self::TYPE_FACTOR_LIKE,
    ];

    protected $fillable = [
        'id', 'channel_id', 'latest_video_id', 'f_view', 'f_like', 'f_dislike', 'f_comment', 'created_at', 'updated_at'
    ];
}
