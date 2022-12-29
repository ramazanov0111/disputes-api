<?php


namespace App\Console\Commands\Disputes;


use App\Models\Disputes;
use App\Models\FactorChannels;
use App\Models\LastVideoChannel;
use App\Models\Videos;
use App\Services\Disputes\GenerateDispute;
use App\Services\Disputes\GenerateFactor;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class GenerateTableDisputes extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'dispute:video {uuid} {method} {status}';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Generate dispute table dispute';

    /**
     * Создание нового экземпляра команды.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Выполнение консольной команды.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->progressStart(count(Disputes::METHOD_DISPUTE_ALL));
        $video = Videos::where('uuid', $this->argument('uuid'))
            ->with('channel')
            ->first();
        $formula = FactorChannels::where('channel_id', $video->channel->uuid)->first();
        $factor = $formula->getAttributes();
        $dispute = [
            'video_id' => $video->uuid,
            'method' => $this->argument('method'),
            'status' => $this->argument('status')
        ];

        /**
         * Если выбран тип спора дефолтный:
         * Генерируем по дефолтным типам (лайки, дизлайки, комментарии, просмотры)
         * Ложь/Истина зависит от аргумента заданной команде
         */
        if ($this->argument('method') === Disputes::METHOD_DISPUTE_DEFAULT) {
            $variables = [];
            foreach (config('disputes.methods.default') as $type) {
                $generate = $this->factor($this->argument('method'), Disputes::METHOD_DISPUTE_DEFAULT);
                $timeBet = $generate->timeBet();
                $variableY = Carbon::now('Europe/Moscow');
                $variableY->addMinutes($timeBet);
                $variables = array_merge($variables, [
                    $type => [
                        'variable_x' => (int) $generate->formulaX([
                            'created_at' => $video->created_at,
                            'published_at' => $video->published_at,
                            'subscribers' => $video->channel->subscriber_count,
                            'a' => (float) $factor['f_' . $type]
                        ]),
                        'variable_y' => $variableY,
                        'time_bet' => $timeBet
                    ]
                ]);
            }

            foreach ($variables as $k => $v) {
                $dispute = array_merge($dispute, ['type' => $k], $v);
                try {
                    Disputes::create($dispute);
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                }
            }

        }

        $this->output->progressFinish();
    }


    /**
     * @param string $status
     * @param string $method
     * @return GenerateDispute
     */
    static function factor(string $method, string $status): GenerateDispute
    {
        return new GenerateDispute([
            'dispute' => [
                'method' => $method,
                'result' => $status
            ]
        ]);
    }
}
