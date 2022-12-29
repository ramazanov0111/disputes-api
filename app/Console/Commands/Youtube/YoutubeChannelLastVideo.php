<?php


namespace App\Console\Commands\Youtube;


use App\Interactors\Youtube\YouTube;
use App\Models\Channels;
use App\Models\LastVideoChannel;
use Google_Client;
use Google_Service_YouTube;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class YoutubeChannelLastVideo extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'youtube:get-last-video';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Get last videos';

    /** @var Google_Service_YouTube  */
    private $youtube;

    /**
     * Создание нового экземпляра команды.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->youtube = YouTube::init();
    }

    /**
     * Выполнение консольной команды.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->output->progressStart();
        $channels = Channels::all();
        foreach ($channels as $channel) {
            $attributes = $channel->getAttributes();
            $videos = $this->youtube->search->listSearch('snippet', [
                'maxResults' => 100,
                'channelId' => $attributes['uuid'],
                'type' => 'video'
            ]);

            foreach ($videos as $video) {
                $video = get_object_vars($video);
                $collect[] = $video;
            }
            usort($collect, function ($a_new, $b_new) {
                $a_new = strtotime($a_new['snippet']['publishedAt']);
                $b_new = strtotime($b_new['snippet']['publishedAt']);
                return $b_new - $a_new;
            });

            $publishedAt =  Carbon::create($collect['0']['snippet']['publishedAt']);
            $publishedAt->addHours(3);
            $data = [
                'channel_id' => $attributes['uuid'],
                'video_id' => $collect['0']['id']['videoId'],
                'published_at' => $publishedAt
            ];
            try {
                LastVideoChannel::create($data);
            } catch (\Exception $exception) {
                $this->error($exception->getMessage());
            }
        }
        $this->output->progressFinish();
    }
}
