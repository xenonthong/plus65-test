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
     * User that owns this number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
