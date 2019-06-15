<?php

use Illuminate\Database\Seeder;


class NumbersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\User::class, 10)
            ->create()
            ->each(function ($user) {
                $user->numbers()->saveMany(factory(App\Models\Number::class, rand(1, 10))->make());
            });
    }
}
