<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Vote
 *
 * @property int $id
 * @property int $option_id
 * @property int $user_id
 * @property-read \App\Models\Option|null $option
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereOptionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vote whereUserId($value)
 * @mixin \Eloquent
 */
class Vote extends Model
{
    protected $fillable = [
        'user_id',
        'poll_id',
        'option_id'
    ];

    use HasFactory;

    public function option() {
        return $this->belongsTo(Option::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
