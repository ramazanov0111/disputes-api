<?php

namespace App\Console\Commands\Youtube;

use App\Interactors\Youtube\YouTube;
use App\Models\Channels;
use App\Models\Videos;
use Google_Service_YouTube;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class YoutubeVideo extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'youtube:add-videos';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Add videos in Videos';

    /** @var Google_Service_YouTube  */
    protected $youtube;

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
        $channels = Channels::all();
        $this->output->progressStart();
        foreach ($channels as $channel) {
            $attributes = $channel->getAttributes();
            $responses = $this->youtube->search->listSearch('snippet', [
                'maxResults' => 100,
                'channelId' => $attributes['uuid'],
                'type' => 'video'
            ]);

            foreach ($responses as $response) {
                $response = get_object_vars($response);
                $videos = $this->youtube->videos->listVideos('id, snippet, statistics', [
                    'id' => $response['id']['videoId']
                ]);
                foreach ($videos as $video) {
                    $video = get_object_vars($video);
                    $carbon = Carbon::create($video['snippet']['publishedAt']);
                    $carbon->addHours(3);
                    try {
                        Videos::create([
                            'uuid' => $video['id'],
                            'title' => $video['snippet']['title'],
                            'view_count' => $video['statistics']['viewCount'],
                            'like_count' => $video['statistics']['likeCount'],
                            'dislike_count' => $video['statistics']['dislikeCount'],
                            'comment_count' => $video['statistics']['commentCount'],
                            'published_at' => $carbon,
                            'thumbnails' => $video['snippet']['thumbnails']['standard']['url'],
                            'channel_id' => $video['snippet']['channelId']
                        ]);
                    } catch (\Exception $exception) {
                        $this->error($exception->getMessage());
                        break;
                    }
                }
                $this->output->progressAdvance();
            }
        }
        $this->output->progressFinish();
    }
}
