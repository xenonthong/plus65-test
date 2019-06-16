<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable,
        HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User's winning number.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function draw()
    {
        return $this->hasOne(Draw::class);
    }

    /**
     * Numbers that the user has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function numbers()
    {
        return $this->hasMany(Number::class);
    }

    /**
     * Get users where post is less than count.
     *
     * @param $count
     *
     * @return mixed
     */
    public static function withLessThanNumberCount($count)
    {
        return self::has('numbers', '<', $count);
    }

    /**
     * Get users where post is more than count.
     *
     * @param $count
     *
     * @return mixed
     */
    public static function withMoreThanNumberCount($count)
    {
        return self::has('numbers', '>', $count);
    }
}
