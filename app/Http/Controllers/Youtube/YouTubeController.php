<?php

namespace App\Http\Controllers\Youtube;

use App\Http\Controllers\Controller;
use Google_Client;
use Google_Service_YouTube;

class YouTubeController extends Controller
{
    private $apiKey = 'AIzaSyAcikULTW71AJ7UDYuikKTJPI4dQSpC3ZI';
    private $youtube;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setDeveloperKey($this->apiKey);

        $this->youtube = new Google_Service_YouTube($client);
    }

    /*
    * Получение данных видео по их id
    */
    public function videoById($id)
    {
        $options = ['maxResults' => 1, 'id' => $id];

        $videos = $this->youtube->videos->listVideos('snippet, statistics', $options);
        if (count($videos->getItems()) == 0) {
            return redirect('404');
        }
        return (['video' => $videos[0]]);
    }

    /**
     * Получение списка популярных видео (данные - snippet и statistics)
     */
    public function videoPopular(int $maxResults = 15, string $region = 'RU')
    {
        $options = ['chart' => 'mostPopular', 'maxResults' => $maxResults, 'regionCode' => $region];

        $videos = $this->youtube->videos->listVideos('id, snippet', $options);
        if (count($videos->getItems()) == 0) {
            return redirect('404');
        }
        return (['videos' => $videos]);
    }

    /**
    * Получение данных канала по id
     * @return mixed
    */
    public function channelById($idChannel)
    {
        $options = ['maxResults' => 1, 'id' => $idChannel];

        $channels = $this->youtube->channels->listChannels('snippet, statistics', $options);
        if (count($channels->getItems()) == 0) {
            return redirect('404');
        }
        return (['channel' => $channels[0]]);
    }


    /**
     * Поиск канала по фразе
     */
    public function channelSearch(string $q, int $maxResults = 3, string $lang = 'ru')
    {
        $options = [
            'q' => $q,
            'maxResults' => $maxResults,
            'relevanceLanguage' => $lang,
            'type' => 'channel'
        ];

        $response = $this->youtube->search->listSearch('snippet', $options);
        if (count($response->getItems()) == 0) {
            return redirect('404');
        }
        return (['search' => $response[0]]);

    }

}
