<?php


namespace App\Services\Disputes;


use App\Models\Disputes;
use Illuminate\Support\Carbon;

class GenerateDispute
{
    public $timeBet;
    /* Time for dispute "Will there be more / less" */
    public $timeBetInMinuteDefault = [10, 10, 10, 20, 20, 20, 30, 30, 40, 50, 60];
    /* Time for dispute "In top 25" */
    public $timeBetInMinuteCustom = [
        'true' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
        'false' => [1, 2, 3, 4, 5]
    ];

    /**
     * GenerateDispute constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->timeBet = $this->identityTimeBet($params);
    }

    /**
     * @param array $condition
     * @return float|int
     */
    public function formulaX(array $condition)
    {
        $carbon = new Carbon();
        $sqrtTime = sqrt($carbon->diffInMinutes($condition['created_at'], $condition['published_at']) + array_rand($this->timeBet));
        return $condition['a'] * $condition['subscribers'] * $sqrtTime;
    }

    /**
     * @return int
     */
    public function timeBet(): int
    {
        return $this->timeBet[array_rand($this->timeBet)];
    }
    /**
     * @param array $params
     * @return int[]
     */
    protected function identityTimeBet(array $params): array
    {
        if ($params['dispute']['method'] == Disputes::METHOD_DISPUTE_DEFAULT) {
            return $this->timeBetInMinuteDefault;
        }
        return $this->timeBet = $params['dispute']['result'] ?
            $this->timeBetInMinuteCustom['true'] : $this->timeBetInMinuteCustom['false'];
    }
}
