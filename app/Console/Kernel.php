<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Зарегистрируйте пользовательские команды Artisan.
     */
    protected $commands = [
        \App\Console\Commands\CreateAdminUser::class, // ← добавь сюда свою команду, если есть
    ];

    /**
     * Определите расписание команд.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly(); // Пример
    }

    /**
     * Регистрация маршрутов для команд artisan.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
