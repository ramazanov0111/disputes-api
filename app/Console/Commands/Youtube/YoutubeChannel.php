<?php

namespace App\Console\Commands\Youtube;

use App\Interactors\Youtube\YouTube;
use App\Models\Channels;
use Illuminate\Console\Command;

class YoutubeChannel extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     *
     * @var string
     */
    protected $signature = 'youtube:add-channel';

    /**
     * Описание консольной команды.
     *
     * @var string
     */
    protected $description = 'Add channel in Channels';

    /** @var \Google_Service_YouTube  */
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
//        $idChannel = [
//            'UCU_yU4xGT9hrVFo6euH8LLw',
//            'UCrFiA0hztL9e8zTi_qBuW4w',
//            'UCM44x9uWlx__9M9Y2IFhxzQ',
//            'UCf31Gf5nCU8J6eUlr7QSU0w',
//            'UCyJrhZm9KXrzRub3-wD2zWg',
//            'UCRW3VLiVep5Ud4Ovhj2eUyA',
//            'UCq1JpGFxcZTbbOAz010U-og',
//            'UCrpt82vHWIWZSHtNQxncPrg',
//            'UCuZeiI5pdpgqDojXZujoYgg',
//            'UCdKuE7a2QZeHPhDntXVZ91w',
//            'UC-27_Szq7BtHDoC0R2U0zxA',
//            'UCwipTluVS2mjuhPtx2WU7eQ',
//            'UCWnqnojAgMdN0fQpr_xByJw',
//            'UCt7sv-NKh44rHAEb-qCCxvA',
//            'UCMCgOm8GZkHp8zJ6l7_hIuA',
//            'UC9diVCDUnRAB3buT1vLn4-w',
//            'UCPX53dr-NSKoXspKmXanbCw',
//            'UCdKEBeInDzinQ6MG2HkF7Gw',
//            'UC0cWWruNMb95iCBEOzPnjRA',
//            'UCBYvr4SqfGQd5fTmOXVQ4Zw',
//            'UCWGK2_WVaXWv-QrkgT9-KDw',
//            'UCI-t7aBR9T38EzLaNNXLLqA',
//            'UCAvrIl6ltV8MdJo3mV4Nl4Q',
//            'UCpDzpaUTbIkdjkCZ9pmfMrA',
//            'UCC83eap-hc6uFQHRJ2F2LNg',
//            'UCy6p8krDY33mDRMt19YrlXg',
//            'UC2il4ZKYE7gwjoVDGAbgMbQ',
//            'UCZUrS0zDszsXI_5ir_tI3cg',
//            'UC-b89a0Fw6pNoP-g-_qLeiw',
//            'UCcvSMLuj0OcAASPsTyVlzBA',
//            'UCxz6gPUpL6l5WSTUObsH9MA',
//            'UCu7TZ_ATWgjgD9IrNLdnYDA',
//            'UCUHQKxU-_DWsrwBxlKWgsew',
//            'UCYFc8A8ZxeanxfBm4dyJUNg',
//            'UCJatXmy5PyaZ6gFs-NEAFWQ',
//            'UCsAw3WynQJMm7tMy093y37A',
//            'UCvo4dSGxJ3r0ZL6NQJIuG5Q',
//            'UCKj4BooYGVlBTXW21nOwcgQ',
//            'UC5sSL56GJWCi4wsMpobTrAw',
//            'UCzlzGhKI5Y1LIeDJI53cWjQ',
//            'UC-Osiqly2kWjXcB6ElD2iCQ',
//            'UCNqktdxgAADBj36dC7VGOgg',
//            'UCZeinbsBPa37qf4HPj_w-lw',
//            'UCOjjJFywLQTzZcARKsTUzXA',
//            'UC5hNc6nMPLmcgygWgdHifgw',
//            'UCPT9_sNLoBLjH1uea7zpVIA',
//            'UCA0Xum6Bxx-rhmrog1A1ISQ',
//            'UCWVztZJW14GQ-jcQGsYDgYQ',
//            'UCCiGUQiWcz3lKev49TX8-Ew',
//            'UCTl7rTGi0SROUH_zeXMS_fw',
//            'UCNb2BkmQu3IfQVcaPExHkvQ',
//            'UC0lT9K8Wfuc1KPqm6YjRf1A',
//            'UCpgNxHZ3TCbB3_Xczm9TIDg',
//            'UCdd2rozVKNHZg9oTeY_X7WQ',
//            'UCrd7UM5OBtB0n1zl41qwCUw',
//            'UCthfjHehYgSyhf8ONjzJMUw',
//            'UCUllb83Lugbka-rvF6Nutxg',
//            'UC7TkMpfCCRwhi8vbTCAOw-A',
//            'UCpFJWSlmXbQVgti5s49PkSg',
//            'UCnQBjLBbZ6TXMwM_D_iaXjQ',
//            'UCR8qqzjkpbCdY4yx8axvHYA',
//            'UC5hcH25pD-rgIlQvzErgE7A',
//            'UCtGJ_XI0ZGwEmKZaj3VQITw',
//            'UC6S1hSjVMFbB9WKv-qZKwuw',
//            'UCG4yz4wtp2E5S62L06yqC9w',
//            'UC8M5YVWQan_3Elm-URehz9w',
//            'UCbj1rZy7-qktxZTawl1S_nA',
//            'UCkEiEd4fV3pvUmcoJYacDqA',
//            'UC9XJvt8OT-9_8QHDBdqocaw',
//            'UCp07Dwx0hHg3tM1Is8kQy4Q',
//            'UCzKJ5CGa4PDB2UgUw0vKKYA',
//            'UCLQTgW5IpinVwpkr3BA9GxQ',
//            'UCOynRdpGiTCNFhCgD0RTe1w',
//            'UCXEsHh2duNWSsX6K9WbmfIg',
//            'UCwPzq5yQwczLmivBX8zq7Mw',
//            'UCjDwvpIhyfBGz4bbH8bcvUg',
//            'UCGrzKEXqpIX-SCStZs77o-A',
//            'UCDx2-SCLzDaC4vlh2PCGYQA',
//            'UCtWY35eYO7jI9LnCRJxBGRQ',
//            'UC2VQebBHZ0Jmh-AI2JrXkQg',
//            'UCsIEFXNO4bxh0hW3-_z2-0g',
//            'UCR-Hcwi27-Ee6VnGzmxE1pA',
//            'UCJjMGnyycI7f4Vl_UMuDB1Q',
//            'UC3P2xNP1eppZFwCYUS7qD7Q',
//            'UCIIDymHgUB6wD91-h8wlZdQ',
//            'UCXFxgPppcehs2LoiKhkakQg',
//            'UCwAlUoQBC1Tqn0PlrNDDz_A',
//            'UCF5LvuL3cqagGSw6WPTs_tg',
//            'UCBnKMiYzbE9opd0Mtg9B7Dg',
//            'UC9oLBiosH8I3muPxumGEVIg',
//            'UCe9pVmC9VWLON835WSevAiQ',
//            'UCOJRJqAaearydfTvGKriCPQ',
//            'UCn9bv143ECsDMw-kJCNN7QA',
//            'UC6JRrn_7Qe1CZBcQDMieadw',
//            'UC6bTF68IAV1okfRfwXIP1Cg',
//            'UCDaIW2zPRWhzQ9Hj7a0QP1w',
//            'UC101o-vQ2iOj9vr00JUlyKw',
//            'UCAf-RYRpQgxpj8voC29ck7w',
//            'UCjm6XUTNSz8Q68WqJIMJ0eQ',
//            'UCdu1AosJcTPsQYFolNHki8Q',
//            'UCBu3eTzufhcBLMhlJAmqDyg',
//            'UC1eFXmJNkjITxPFWTy6RsWg',
//            'UCLZIN4aTXYm92c1ENyN8KmA',
//            'UCvQXaJTjA3jRucTKN4CGiwg',
//            'UCve3ohcLCBO5uFoQcFGZMPQ',
//            'UCP_oaaQqr3r0jlxeHh_vE9A',
//            'UCD3cxCSDwsNVrOfHHpcqwQA',
//            'UCinCNv1-7hb19w51LwbazRg',
//            'UCJKqpCqE0LqAAvVloQbDJ0g',
//            'UCn1YQ4g_kKwJbt0MUVZfY7A',
//            'UC4yxdlsaRT6WpZ_FZQ6uIpQ',
//            'UCQwRlx8hVI-CFv_E-v5s84Q',
//            'UCM7-8EfoIv0T9cCI4FhHbKQ',
//            'UCHxmpe0x92ECyimlkazbuKg',
//            'UC9ql--q_LV7zhDI1CCO9Xdg',
//            'UCUFl0SxF14-eZGTxhWuhM8Q',
//            'UCSoYSTOt1g_Vdo8xCJeQpHw',
//            'UCBELlne6XFSBbYaSTDbCvvA',
//            'UC7mFtKMM819ZeYiwgbUyy0g',
//            'UC1EubwyksxHrpJZ9DvebeqQ',
//            'UC8j5GsMc0pjInklm4DfwCZQ',
//            'UC1_FrNtrgzFPQVHuwAAR3xQ',
//            'UCYhXOzYd6-Vf4Uq-avzxh6g',
//            'UCAe4XfXD-WqP5FsGSO_h-xg',
//            'UChQtxlW250ea-BImn9cjSJQ',
//            'UC7p0GCM88wBsrlv5n5eeCHw',
//            'UCuOyP59Q8OiqetsjABP8Hhw',
//            'UC-iU28QW_832Fx_3RJ_vYPQ',
//            'UCbvXcK_Yu6E42Y3MLHNfKiw',
//            'UCzTom8k7UduI9jcs6umWD9Q',
//            'UCVgvnGSFU41kIhEc09aztEg',
//            'UCmb1mMtwPfQ5WC-bVlqdJdg',
//            'UCYT3lHUPq3m4z2Gz8Sbr92g',
//            'UCI-vs_XT8MztGQw8uuYQVSg',
//            'UCK0iilUPnz6LXDF6EJpzGbA',
//            'UCLKB9g1374gcxezJINOLtag',
//            'UCoRAnB8KixJiszlSpMHa-SA',
//            'UC1qWaT8_iPHSBYgB4T2ltuA',
//            'UCjDPtHEW-QqbUtAUIqD00gg',
//            'UCkbSaWqttPHTS00K0fjniTQ',
//            'UCoUSunDkX_BwrZctbMUyI8A',
//            'UCQ18THOcZ8nIP-A3ZCqqZwA',
//            'UCKC0KDcTiwYVS2y_dN5fGlg',
//            'UCOOSjVij3mlBNediltkb-ig',
//            'UCWkWE0rMMJshs4QX7i7LLxQ',
//            'UCa5GHJVSH0s6YlJXU6YlGaw',
//            'UCD3JX5aiXiFQeg0PwiMyI-Q',
//            'UCtGw6h7S9POPQbsI39jSspg',
//            'UCp7_K5hgSzo7nGJc5v6sHFA',
//            'UCK9lZ2lHRBgx2LOcqPifukA',
//            'UCkaVP4nrYPlie1-VInSgjqQ',
//            'UCSpU8Y1aoqBSAwh8DBpiM9A',
//            'UCrMU71nSWHAmpb1-3wEtW8g',
//            'UCoPAAPkUpAQJTul8KFWBaRg',
//            'UCsKiNBoIWLpIxU6vsAv3v3w',
//            'UCNRYbltJXhf6DepS26-uSbQ',
//            'UC5DS1uraRM87x49mNIEkKuQ',
//            'UCnDgIiMU3CyNHGP9wlLbgqw',
//            'UCYD4ELT_1LS3VtM8jb-vZxQ',
//            'UCeKCxQDv6lWDSzuqUXGtMRA'
//        ];
        $idChannel = [
            'UCnDgIiMU3CyNHGP9wlLbgqw',
        ];
        $this->output->progressStart(count($idChannel));
        foreach ($idChannel as $id) {
            $youtube_channels = $this->youtube->channels->listChannels('snippet, statistics', [
                'id' => $id
            ]);
            foreach ($youtube_channels as $youtube_channel) {
                $channel = get_object_vars($youtube_channel);
                try {
                    Channels::create([
                        'uuid' => $channel['id'],
                        'title' => $channel['snippet']['title'],
                        'thumbnails' => $channel['snippet']['thumbnails']['default']['url'],
                        'subscriber_count' => $channel['statistics']['subscriberCount'],
                        'view_count' => $channel['statistics']['viewCount'],
                        'video_count' => $channel['statistics']['videoCount'],
                        'published_at' => $channel['snippet']['publishedAt']
                    ]);
                    $this->output->progressAdvance();
                } catch (\Exception $exception) {
                    $this->error($exception->getMessage());
                    break;
                }
            }

        }
        $this->output->progressFinish();
    }
}
