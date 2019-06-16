<?php

namespace Tests\Traits;

use App\Models\User;

trait HasUserInteraction
{
    public function createAdminUser()
    {
        $user = factory(User::class)->create();

        $user->assignRole('admin');

        return $user;
    }

    public function createUser()
    {
        return factory(User::class)->create();
    }
}