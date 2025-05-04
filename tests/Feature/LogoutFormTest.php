<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Header;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LogoutFormTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertAuthenticatedAs($user);

        Livewire::test(Header::class)
            ->call('logout')
            ->assertRedirect(route('dashboard'));

        $this->assertGuest();
    }
}
