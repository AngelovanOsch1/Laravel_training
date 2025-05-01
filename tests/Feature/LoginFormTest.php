<?php

namespace Tests\Feature;

use App\Models\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\LoginForm;
use PHPUnit\Framework\Attributes\Test;

class LoginFormTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_logs_in_with_correct_credentials()
    {
        $auth = Authentication::factory()->create();

        $validCredentials = [
            'form.email' => $auth->email,
            'form.password' => 'Password123!',
        ];

        Livewire::test(LoginForm::class)
            ->set($validCredentials)
            ->call('submit')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    #[Test]
    public function it_shows_error_for_invalid_credentials()
    {
        $invalidCredentials = [
            'form.email' => fake()->safeEmail(),
            'form.password' => fake()->password(),
        ];

        Livewire::test(LoginForm::class)
            ->set($invalidCredentials)
            ->call('submit')
            ->assertHasErrors(['form.email' => ['Incorrect credentials']]);

        $this->assertGuest();
    }

    #[Test]
    public function it_requires_email_and_password()
    {
        $invalidCredentials = [
            'form.email' => '',
            'form.password' => '',
        ];

        Livewire::test(LoginForm::class)
            ->set($invalidCredentials)
            ->call('submit')
            ->assertHasErrors([
                'form.email' => 'required',
                'form.password' => 'required',
            ]);
    }
}
