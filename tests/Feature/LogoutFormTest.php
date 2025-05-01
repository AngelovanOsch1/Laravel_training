<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Header;
use App\Models\Authentication;
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
        $auth = Authentication::factory()->create();
        $this->actingAs($auth);

        $this->assertAuthenticatedAs($auth);

        Livewire::test(Header::class)
            ->call('logout')
            ->assertRedirect(route('dashboard'));

        $this->assertGuest();
    }
}
