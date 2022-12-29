<?php


namespace App\Models;


use Doctrine\Common\Annotations\Annotation\Enum;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;


class Disputes extends Model
{
    /** METHOD with variable X */
    const METHOD_DISPUTE_DEFAULT = 'default';
    /** METHOD without variable X */
    const METHOD_DISPUTE_CUSTOM = 'custom';
    /** All method */
    const METHOD_DISPUTE_ALL = [
        self::METHOD_DISPUTE_CUSTOM,
        self::METHOD_DISPUTE_DEFAULT
    ];

    const TYPE_DISPUTE_LIKE = 'like';
    const TYPE_DISPUTE_DISLIKE = 'dislike';
    const TYPE_DISPUTE_VIEW = 'view';
    const TYPE_DISPUTE_COMMENTS = 'comment';
    const TYPE_DISPUTE_TOP_25 = 'top25';
    const TYPE_DISPUTE_TOP_100 = 'top100';
    const TYPE_DISPUTE_ALL = [
        self::TYPE_DISPUTE_LIKE,
        self::TYPE_DISPUTE_DISLIKE,
        self::TYPE_DISPUTE_VIEW,
        self::TYPE_DISPUTE_COMMENTS,
        self::TYPE_DISPUTE_TOP_25,
        self::TYPE_DISPUTE_TOP_100,
    ];


    protected $table = 'disputes';
    protected $fillable = [
        'video_id', 'method', 'type', 'variable_x', 'variable_y', 'status', 'result', 'is_actual',
        'created_at', 'updated_at', 'time_bet'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function video(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Videos::class, 'uuid', 'video_id')->with('channel');
    }
}
