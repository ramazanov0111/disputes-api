<?php


namespace App\Console\Commands\Disputes;


use App\Models\Channels;
use App\Models\LastVideoChannel;
use App\Models\FactorChannels;
use App\Services\Disputes\GenerateFactor;
use Google\Client;
use Illuminate\Console\Command;

class GenerateTableFactor extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'dispute:table-factor';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Generate dispute table factor';

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
        $videos = LastVideoChannel::with(['video', 'channel'])->get();
        $this->output->progressStart();
        foreach ($videos as $video) {
            $row = [
                'channel_id' => $video->channel->uuid,
                'latest_video_id' => $video->id,
            ];
            foreach (FactorChannels::TYPE_FACTOR_ALL as $type) {
                $row = array_merge($row, [
                    'f_' . $type => (new GenerateFactor([
                        'video' => $video->video->getAttributes(),
                        'channel' => $video->channel->getAttributes(),
                        'type' => $type
                    ]))->make()
                ]);
            }
            try {
                FactorChannels::create($row);
                $this->output->progressAdvance();
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }

        }
        $this->output->progressFinish();
    }
}
