<?php


namespace App\Console\Commands\Disputes;

use App\Interactors\Youtube\YouTube;
use App\Models\Disputes;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class VerificationDispute extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'dispute:verification {id}';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Verification dispute';

    /** @var \Google_Service_YouTube */
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
        $this->output->progressStart();
        $disputes = Disputes::where('video_id', $this->argument('id'));

        foreach ($disputes as $dispute) {

            $videos = $this->youtube->videos->listVideos('id, snippet, statistics', [
                'id' => $dispute->video_id
            ]);
            foreach ($videos as $video) {
                $video = get_object_vars($video);
                $carbon = Carbon::create($video['snippet']['publishedAt']);
                $carbon->addHours(3);
                try {
                    $data = [
                        'id' => $video['id'],
                        'viewCount' => $video['statistics']['viewCount'],
                        'likeCount' => $video['statistics']['likeCount'],
                        'dislikeCount' => $video['statistics']['dislikeCount'],
                        'commentCount' => $video['statistics']['commentCount'],
                        'publishedAt' => $carbon
                    ];
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    break;
                }
            }

            $now = Carbon::now('Europe/Moscow');
            $variableY = $dispute->variable_y;
            $created_at = $dispute->created_at;
            $diff = ($created_at->diffInMinutes($variableY)) / ($now->diffInMinutes($variableY));

            $var_x = $dispute->variable_x;
            if ($diff !== 2) {
                echo $diff;
                if ($dispute->status == true) {
                    if ($dispute->type == 'like') {
                        if ($var_x >= $data['likeCount'])
                            $dispute->update(['result' => true]);
                    } elseif ($dispute->type == 'dislike') {
                        if ($var_x >= $data['dislikeCount'])
                            $dispute->update(['result' => true]);
                    } elseif ($dispute->type == 'view') {
                        if ($var_x >= $data['viewCount'])
                            $dispute->update(['result' => true]);
                    } elseif ($dispute->type == 'comment') {
                        if ($var_x >= $data['commentCount'])
                            $dispute->update(['result' => true]);
                    }
                } elseif ($dispute->status == false) {
                    if ($dispute->type == 'like') {
                        if ($var_x < $data['likeCount'])
                            $dispute->update(['result' => true]);
                    } elseif ($dispute->type == 'dislike') {
                        if ($var_x < $data['dislikeCount'])
                            $dispute->update(['result' => true]);
                    } elseif ($dispute->type == 'view') {
                        if ($var_x < $data['viewCount'])
                            $dispute->update(['result' => true]);
                    } elseif ($dispute->type == 'comment') {
                        if ($var_x < $data['commentCount'])
                            $dispute->update(['result' => true]);
                    }
                }

                $dispute->save();
            }

        }
        $this->output->progressFinish();
    }
}
