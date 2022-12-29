<?php


namespace App\Http\Resources\Disputes;


use App\Services\Disputes\DefinitionDispute;
use Illuminate\Http\Resources\Json\JsonResource;

class DisputeItem extends JsonResource
{
    /**
     * @var DefinitionDispute
     */
    protected $dispute;

    public function toArray($request): array
    {
        $this->dispute = new DefinitionDispute(collect($this->resource));
        return [
            'id' => $this->resource->id,
            'meta' => [
                'type' => $this->dispute->getType(),
                'thumbnails' => $this->resource->video->thumbnails,
                'title' => $this->dispute->getTitle(),
            ],
            'video' => [
                'views' => $this->resource->video->view_count,
                'comments' => $this->resource->video->comment_count,
                'dislike' => $this->resource->video->dislike_count,
                'like' => $this->resource->video->like_count,
                'title' => $this->resource->video->title
            ],
            'channel' => [
                'title' => $this->resource->video->channel->title,
                'thumbnails' => $this->resource->video->channel->thumbnails,
            ],
            'published_at' => $this->dispute->publishedAgo()
        ];
    }
}
