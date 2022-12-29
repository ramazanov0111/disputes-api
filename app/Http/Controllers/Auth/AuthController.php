<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    use RespondWithToken;

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      operationId="login",
     *      tags={"auth"},
     *      summary="login",
     *      @OA\RequestBody(request="User", description="User object that needs to be login or if not exist create", required=true,
     *          @OA\JsonContent(@OA\Property(property="uuid", type="string", example="123456"),),
     *      ),
     *      @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *                  @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8wLjAuMC4wOjgwODhcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjIwMjkzODM5LCJleHAiOjE2MjAyOTc0MzksIm5iZiI6MTYyMDI5MzgzOSwianRpIjoiUG4yOHhPMHo4VHZLRjBzVyIsInN1YiI6MTIzLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.fsfFD7PQ3MePJz7TIfW6pXHec71ZjgE2laoyzrWJgv0"),
     *                  @OA\Property(property="token_type", type="string", example="bearer"),
     *                  @OA\Property(property="expires_in", type="integer", example=3600),
     *          )
     *      )
     * )
     */

    public function login(Request $request)
    {

        $user = User::where('uuid', $request->uuid)->first();
        if (is_null($user)) {
            $user = User::create($this->validate($request,[
                'uuid' => 'required|unique:users|max:255',
            ]));
        }
        return $this->getTokenById($user->id);

    }

    /**
     * @OA\Get(
     *     path="/auth/me",
     *     tags={"auth"},
     *     summary="me",
     *     description="Return user data",
     *     operationId="getUser",
     *     security={ {"Authorization": {"Authorization:Bearer token"}} },
     *     @OA\Response(response=200, description="OK", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Get(
     *     path="/auth/logout",
     *     tags={"auth"},
     *     summary="logout",
     *     description="logout user, delete token",
     *     operationId="logoutUser",
     *     security={ {"Authorization": {"Authorization:Bearer token"}} },
     *     @OA\Response(response=200, description="OK",
     *          @OA\JsonContent( @OA\Property(property="message", type="string", example="Successfully logged out"))
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     *
     * )
     */

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Get(
     *     path="/auth/refresh",
     *     tags={"auth"},
     *     summary="refresh",
     *     description="refresh token",
     *     operationId="refreshToken",
     *     security={ {"Authorization": {"Authorization:Bearer token"}} },
     *     @OA\Response(response=200, description="OK",
     *          @OA\JsonContent(
     *                  @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8wLjAuMC4wOjgwODhcL2F1dGhcL2xvZ2luIiwiaWF0IjoxNjIwMjkzODM5LCJleHAiOjE2MjAyOTc0MzksIm5iZiI6MTYyMDI5MzgzOSwianRpIjoiUG4yOHhPMHo4VHZLRjBzVyIsInN1YiI6MTIzLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.fsfFD7PQ3MePJz7TIfW6pXHec71ZjgE2laoyzrWJgv0"),
     *                  @OA\Property(property="token_type", type="string", example="bearer"),
     *                  @OA\Property(property="expires_in", type="integer", example=3600),
     *          ),
     *     ),
     *     @OA\Response(response=401, description="Unauthenticated")
     * )
     */

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

}
