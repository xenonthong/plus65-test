<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    /**
     * The mass assignable fields.
     *
     * @var array
     */
    protected $fillable = ['value'];

    /**
     * Return highest number of numbers owned by users.
     *
     * @return mixed
     */
    public static function highestCountByUsers()
    {
        return self::selectRaw('user_id, count(*) as aggregate')
                   ->groupBy('user_id')
                   ->get()
                   ->max('aggregate');
    }

    /**
     * User that owns this number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }
}
