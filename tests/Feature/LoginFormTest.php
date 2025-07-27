<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\LoginForm;
use Illuminate\Support\Facades\Cookie;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginFormTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected array $validCredentials;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->user = User::factory()->create();

        $this->validCredentials = [
            'form.email' => $this->user->email,
            'form.password' => 'Password123!',
            'form.rememberMe' => true
        ];
    }

    #[Test]
    public function it_logs_in_with_correct_credentials()
    {
        Livewire::test(LoginForm::class)
            ->set($this->validCredentials)
            ->call('submit')
            ->assertRedirect(route('profile', ['id' => $this->user->id]));

        $this->assertAuthenticated();

        $this->assertNotNull(Cookie::get(app('config')->get('auth.remember_cookie')));
    }

    #[Test]
    public function it_user_is_blocked()
    {
        $this->user->is_blocked = true;
        $this->user->save();

        Livewire::test(LoginForm::class)
            ->set($this->validCredentials)
            ->call('submit')
            ->assertHasErrors(['form.email' => ['Your account has been blocked.']]);

        $this->assertGuest();
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

        $this->assertGuest();
    }
}
