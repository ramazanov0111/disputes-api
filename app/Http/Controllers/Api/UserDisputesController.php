<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Disputes;
use App\Models\User;
use App\Models\UserDisputes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDisputesController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function rate(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json([
                'data' => UserDisputes::create(
                    $request->merge(['user_id' => auth()->user()->id])->all()
                )
            ]);
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage(), 500);
        }
    }
}
