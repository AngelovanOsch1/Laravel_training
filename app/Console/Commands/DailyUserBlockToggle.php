<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\BlockUser;
use App\Jobs\UnblockUser;

class DailyUserBlockToggle extends Command
{
    protected $signature = 'users:daily-toggle';

    protected $description = 'Daily block and unblock random users';

    public function handle()
    {
        $userToBlock = User::where('is_blocked', false)->inRandomOrder()->first();

        if ($userToBlock) {
            BlockUser::dispatch($userToBlock->id);
            $this->info("Scheduled block job for user #{$userToBlock->id}");
        }

        $userToUnblock = User::where('is_blocked', true)->inRandomOrder()->first();

        if ($userToUnblock) {
            UnblockUser::dispatch($userToUnblock->id);
            $this->info("Scheduled unblock job for user #{$userToUnblock->id}");
        }
    }
}
