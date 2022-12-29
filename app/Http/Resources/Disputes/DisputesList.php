<?php


namespace App\Http\Resources\Disputes;


use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Disputes\DisputeItem;

class DisputesList extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'data' => DisputeItem::collection($this->resource)
        ];
    }
}
