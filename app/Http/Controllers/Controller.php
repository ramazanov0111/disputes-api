<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(title="Disputes API", version="0.1"),
 *
 * @OA\Tag(name="auth", description="authentication in app"),
 *
 * @OA\SecurityScheme(
 *      name="Authorization",
 *      bearerFormat="JWT",
 *      in="header",
 *      type="apiKey",
 *      securityScheme="Authorization"
 * )
 */

class Controller extends BaseController
{
    //
}
