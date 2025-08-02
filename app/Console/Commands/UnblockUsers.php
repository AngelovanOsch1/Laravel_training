<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Jobs\ReblockUser;
use Illuminate\Console\Command;

class UnblockUsers extends Command
{
    protected $signature = 'users:unblock';

    protected $description = 'Unblock all users by setting is_blocked to false';

    public function handle()
    {
        $updated = User::where('is_blocked', true)->update(['is_blocked' => false]);
        $this->info("Unblocked {$updated} user(s).");

        $randomUser = User::where('is_blocked', false)->inRandomOrder()->first();

        if ($randomUser) {
            ReblockUser::dispatch($randomUser->id)->delay(now()->addMinutes(1));
            $this->info("⏳ Reblock job scheduled for user #{$randomUser->id} in 1 minute.");
        }
    }
}
