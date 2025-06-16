<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Session;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserOnlineStatusTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_returns_true_if_user_has_active_session_within_10_minutes()
    {
        $session = Session::factory()->create();

        $this->assertTrue($session->user->is_online);
    }

    #[Test]
    public function it_returns_false_if_user_has_no_recent_activity_within_10_minutes()
    {
        $session = Session::factory()->create([
            'last_activity' => now()->subMinutes(15)->timestamp,
        ]);

        $this->assertFalse($session->user->is_online);
    }
}
