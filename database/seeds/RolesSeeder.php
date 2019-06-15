<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => Role::ADMIN],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
