<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{

    protected $signature = 'create:admin';

    protected $description = 'This command for create admin User';


    public function handle()
    {
        $name = $this->ask('What is the name of the admin?');
        $email = $this->ask('What is the email of the admin?');
        $password = $this->ask('What is the password of the admin?');
        $password_confirm = $this->ask('What is the password confirmation of the admin?');


        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $password_confirm,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            // Display all validation errors
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'role' => 'admin',
            'account_verified_at' => now(),
            'password' => Hash::make($password),
            'otp' => random_int(100000, 999999),
        ]);
        $this->info('Admin ' . $name . 'created successfully!');
    }
}
