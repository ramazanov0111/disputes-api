<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use phpseclib3\Math\BigInteger;

/**
 * Class UserDisputes
 * @package App\Models
 *
 * @property $dispute_id string
 * @property $user_id int
 * @property $coin int
 */
class UserDisputes extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dispute_id', 'user_id', 'coin'
    ];
    protected $table = 'user_disputes';
    protected $hidden = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dispute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Disputes::class, 'dispute_uuid', 'uuid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
