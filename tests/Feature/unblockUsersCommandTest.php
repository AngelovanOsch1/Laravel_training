<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Jobs\BlockUser;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UnblockUsersCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_unblocks_users_and_dispatches_job()
    {
        Queue::fake();

        User::factory()->count(3)->create(['is_blocked' => true]);
        User::factory()->count(2)->create(['is_blocked' => false]);

        $this->artisan('users:unblock')
            ->expectsOutput('Unblocked 3 user(s).')
            ->assertExitCode(0);

        $this->assertDatabaseMissing('users', ['is_blocked' => true]);

        Queue::assertPushed(BlockUser::class, function ($job) {
            return $job->delay->greaterThan(now());
        });
    }
}
