<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user with admin role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $input = [
            'name'     => $this->ask('What is the admin\'s name?'),
            'email'    => $this->ask('What\'s the admin\'s email?'),
            'password' => Hash::make($this->secret('What\'s the admin\'s default password?')),
        ];

        if ($this->confirm('Do you wish to proceed to create the admin account?')) {
            $user = User::create($input);

            $user->assignRole(Role::ADMIN);

            $this->info('An admin has been created.');
        }
    }
}
