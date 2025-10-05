<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create {--type=} {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new marketing or sales user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $type = $this->option('type') ?: $this->choice('Select user type', ['marketing', 'sales']);
        $name = $this->option('name') ?: $this->ask('Enter user name');
        $email = $this->option('email') ?: $this->ask('Enter user email');
        $password = $this->option('password') ?: $this->secret('Enter user password');

        // التحقق من صحة البيانات
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'type' => $type,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'type' => 'required|in:marketing,sales',
        ]);

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        // إنشاء المستخدم
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'user_type' => $type,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $this->info("User created successfully!");
        $this->line("Name: {$user->name}");
        $this->line("Email: {$user->email}");
        $this->line("Type: {$user->user_type}");
        $this->line("Login URL: /{$type}/login");
        $this->line("Dashboard URL: /{$type}/dashboard");

        return 0;
    }
}
