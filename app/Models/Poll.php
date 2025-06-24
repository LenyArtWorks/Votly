<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Poll
 *
 * @property int $id
 * @property string $title
 * @property int $user_id
 * @property string $status
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Option> $options
 * @property-read int|null $options_count
 * @method static \Illuminate\Database\Eloquent\Builder|Poll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Poll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Poll query()
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Poll whereUserId($value)
 * @mixin \Eloquent
 */
class Poll extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'title',
        'user_id',
        'status',
        'category_id'
    ];

    public function options() {
        return $this->hasMany(Option::class);
    }
}
