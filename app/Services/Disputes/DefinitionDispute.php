<?php


namespace App\Services\Disputes;


use App\Models\Disputes;
use Carbon\Traits\Creator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DefinitionDispute
{
    /**
     * @var Collection $dispute
     */
    protected $dispute;

    /**
     * @var string[]
     */
    protected $typesRow = [
        Disputes::TYPE_DISPUTE_LIKE => 'like_count',
        Disputes::TYPE_DISPUTE_DISLIKE => 'dislike_count',
        Disputes::TYPE_DISPUTE_VIEW => 'view_count',
        Disputes::TYPE_DISPUTE_COMMENTS => 'comment_count'
    ];

    public function __construct(Collection $collection)
    {
        $this->dispute = $collection;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->dispute['type'] . 's';
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->dispute['video'][$this->typesRow[$this->dispute['type']]];
    }

    /**
     * @return string
     */
    public function publishedAgo(): string
    {
        $carbon = new Carbon();
        return str_replace('после', 'назад', $carbon->diffForHumans($this->dispute['created_at']));
    }

    /**
     * @return array
     */
    public function getTitle(): array
    {
        $status = $this->dispute['status'] ? 'больше' : 'меньше';
        $subs = config('disputes.title.default');
        $title = [];
        foreach ($subs as $sub) {
            array_push($title, preg_replace(
                ['/status/', '/x/', '/type/', '/y/',],
                [$status, $this->dispute['variable_x'] + $this->getValue(), config('disputes.translate.' . $this->dispute['type']), $this->dispute['time_bet']],
                $sub
            ));
        }
        return $title;
    }

}
