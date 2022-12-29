<?php


namespace App\Services\Disputes;


use App\Models\Channels;
use App\Models\Disputes;
use App\Models\LastVideoChannel;
use App\Models\Videos;
use Illuminate\Support\Carbon;

/**
 * Class CustomDispute
 * @package App\Services\Disputes
 *
 *
 */
class GenerateFactor
{
    /** @var array */
    protected $channel;
    /** @var array */
    protected $video;
    /** @var int */
    protected $q;

    /**
     * GenerateFactor constructor.
     * @param array $params
     */
    public function __construct(array $params) {
        $this->channel = $params['channel'];
        $this->video = $params['video'];
        $this->identityType($params['type']);
    }

    /**
     * @return float
     */
    public function make(): float
    {
        return self::factor();
    }

    /**
     * @return float
     */
    protected function factor(): float
    {
        $carbon = new Carbon();
        $diff = $carbon->diffInMinutes($this->video['published_at'], $this->video['created_at']);
        return round($this->q / ($this->channel['subscriber_count'] * sqrt($diff)), 12);
    }

    protected function identityType(string $type)
    {
        switch ($type) {
            case Disputes::TYPE_DISPUTE_VIEW: $this->q = $this->video['view_count']; break;
            case Disputes::TYPE_DISPUTE_LIKE: $this->q = $this->video['like_count']; break;
            case Disputes::TYPE_DISPUTE_DISLIKE: $this->q = $this->video['dislike_count']; break;
            case Disputes::TYPE_DISPUTE_COMMENTS: $this->q = $this->video['comment_count']; break;
        }
    }
}
