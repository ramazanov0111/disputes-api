<?php


namespace App\Http\Controllers\Youtube;


class VideoController
{
    /** @var string */
    protected $uuid;

    /**
     * VideoController constructor.
     * @param string $uuid
     */
    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function update()
    {
        // TODO: update video
    }
}
