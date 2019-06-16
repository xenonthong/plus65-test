<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Draw extends Model
{
    protected $guarded = [];

    public function drawnNumber()
    {
        return $this->hasOne(Number::class, 'value', 'number')->withDefault();
    }
}
