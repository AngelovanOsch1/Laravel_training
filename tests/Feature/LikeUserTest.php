<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Reaction;
use App\Livewire\Profile;
use App\Models\SeriesStatus;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeUserTest extends TestCase
{
    use RefreshDatabase;

    protected User $loggedInUser;
    protected User $targetUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loggedInUser = User::factory()->create();
        $this->targetUser = User::factory()->create();

        $this->actingAs($this->loggedInUser);
    }

    #[Test]
    public function it_inserts_a_reaction_record_when_liking_a_user()
    {
        Livewire::test(Profile::class)
            ->call('likeUser', $this->targetUser->id);

        $this->assertDatabaseHas('reactions', [
            'user_id' => $this->loggedInUser->id,
            'reactionable_id' => $this->targetUser->id,
            'reactionable_type' => User::class,
            'type' => 'like',
        ]);
    }

    #[Test]
    public function it_removes_a_reaction_record_when_unliking_a_user()
    {
        $existingReaction = Reaction::factory()->create([
            'user_id' => $this->loggedInUser->id,
            'reactionable_id' => $this->targetUser->id,
            'reactionable_type' => User::class,
        ]);

        Livewire::test(Profile::class)
            ->call('likeUser', $this->targetUser->id);

        $this->assertDatabaseMissing('reactions', [
            'user_id' => $existingReaction->user_id,
            'reactionable_id' => $existingReaction->reactionable_id,
            'reactionable_type' => $existingReaction->reactionable_type,
            'type' => $existingReaction->type,
        ]);
    }
}
