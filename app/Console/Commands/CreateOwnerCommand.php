<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateOwnerCommand extends Command
{

    protected $signature = 'create:owner';

    protected $description = 'This command for create owner User';


    public function handle()
    {

        if (Role::where('role', 'Owner')->first()) {
            Artisan::call('db:seed', ['--class' => 'RoleAndPermissionSeeder']);
        }

        $name = $this->ask('What is the name of the owner?');
        $email = $this->ask('What is the email of the owner?');
        $password = $this->ask('What is the password of the owner?');
        $password_confirm = $this->ask('What is the password confirmation of the owner?');


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
            'account_verified_at' => now(),
            'password' => Hash::make($password),
            'otp' => random_int(100000, 999999),
        ]);

        $ownerRole = Role::where('role', 'Owner')->first();
        $user->roles()->attach($ownerRole->id);

        $this->info('Owner ' . $name . ' created successfully!');
    }
}
