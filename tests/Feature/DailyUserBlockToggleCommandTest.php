<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\BlockUser;
use App\Jobs\UnblockUser;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DailyUserBlockToggleCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_daily_block_and_unblock_command()
    {
        Queue::fake();

        $userToBlock = User::factory()->create(['is_blocked' => false]);
        $userToUnblock = User::factory()->create(['is_blocked' => true]);

        $this->artisan('users:daily-toggle')
            ->expectsOutput("Scheduled block job for user #{$userToBlock->id}")
            ->expectsOutput("Scheduled unblock job for user #{$userToUnblock->id}")
            ->assertExitCode(0);

        Queue::assertPushed(BlockUser::class, function ($job) use ($userToBlock) {
            return $job->userId === $userToBlock->id;
        });

        Queue::assertPushed(UnblockUser::class, function ($job) use ($userToUnblock) {
            return $job->userId === $userToUnblock->id;
        });
    }
}
