<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    protected $signature = 'app:create-admin
                            {email : Admin email address}
                            {--name=Admin : Display name}
                            {--password= : Password (prompted if omitted)}';

    protected $description = 'Create or promote a Job4U admin user';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email')));
        $name = trim((string) $this->option('name')) ?: 'Admin';
        $password = $this->option('password') ?: $this->secret('Password');

        $validator = Validator::make([
            'email' => $email,
            'name' => $name,
            'password' => $password,
        ], [
            'email' => ['required', 'email'],
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $user->update([
                'name' => $name,
                'role' => User::ROLE_ADMIN,
                'password' => $password,
                'is_suspended' => false,
            ]);

            $this->info("Updated existing user {$email} to admin.");
        } else {
            User::create([
                'name' => $name,
                'email' => $email,
                'role' => User::ROLE_ADMIN,
                'password' => $password,
                'is_suspended' => false,
            ]);

            $this->info("Created admin user {$email}.");
        }

        return self::SUCCESS;
    }
}
