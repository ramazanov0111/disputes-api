<?php

namespace App\Http\Controllers\Auth;

trait RespondWithToken
{

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getTokenById(int $id): \Illuminate\Http\JsonResponse
    {
        if (! $token = auth()->tokenById($id)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

}
