<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MakeAdminUser extends Command
{
    protected $signature = 'make:admin';
    protected $description = 'Создать пользователя-админа';

    public function handle()
    {
        $name = $this->ask('Введите имя');
        $email = $this->ask('Введите email');
        $password = $this->secret('Введите пароль');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info("Админ {$user->email} создан успешно.");
    }
}
