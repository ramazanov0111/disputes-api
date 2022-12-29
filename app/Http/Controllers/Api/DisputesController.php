<?php


namespace App\Http\Controllers\Api;


use App\Http\Resources\Disputes\DisputeItem;
use App\Http\Resources\Disputes\DisputesList;
use App\Models\Disputes;
use Illuminate\Http\Request;

class DisputesController
{
    /**
     * @param Request $request
     * @return DisputesList
     */
    public function tape(Request $request): DisputesList
    {
        $builder = Disputes::where('is_actual', true)
            ->with('video');
        // TODO: выводить только те, в которых не участвует пользователь
        return new DisputesList($builder->get());
    }

    /**
     * @param int $item
     * @return DisputeItem
     */
    public function item(int $item): DisputeItem
    {
        $builder = Disputes::find($item);
        return new DisputeItem($builder);
    }
}
