<?php


namespace App\Interactors\Youtube;

use Google_Client;
use Google_Service_YouTube;

/**
 * Class YouTube
 * @package App\Interactors\Youtube
 *
 * @method
 */
abstract class YouTube
{
    /**
     * @return Google_Service_YouTube
     */
    public static function init(): Google_Service_YouTube
    {
        $client = new Google_Client();
        $client->setDeveloperKey(getenv('GOOGLE_API_KEY'));
        return new Google_Service_YouTube($client);
    }
}
