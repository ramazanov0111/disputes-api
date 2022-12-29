<?php

namespace App\Models;

use Faker\Provider\DateTime;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use phpseclib3\Math\BigInteger;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Traits\RoleTrait;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory, HasRoles, RoleTrait;

    /**
     * @OA\Property( title="uuid", example=123456)
     * @var int
     */
    protected $uuid;

    /**
     * @OA\Property(property="id", type="integer", example=1)
     * @var int
     */
    protected $id;

    /**
     * @OA\Property(property="created_at", type="datetime", example="2021-05-03T16:29:10.000000Z")
     * @var datetime
     */
    protected $created_at;

    /**
     * @OA\Property(property="updated_at", type="datetime", example="2021-05-03T16:29:10.000000Z")
     * @var datetime
     */
    protected $updated_at;

    /**
     * @OA\Property(property="coin", type="integer", example=200)
     * @var BigInteger
     */
    protected $coin;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid','email','password', 'google_id', 'coin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'id'];

    public function myRoles(): HasManyThrough
    {
        return $this->hasManyThrough(
            Role::class,
            ModelHasRole::class,
            'model_id',
            'id',
            'id',
            'role_id'
        );
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
