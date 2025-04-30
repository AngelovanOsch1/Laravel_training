<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Authentication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use App\Livewire\LoginForm;

class LoginFormTest extends TestCase
{
    use RefreshDatabase;

    private array $validCredentials;
    private $auth;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        $this->auth = Authentication::factory()->create();
    }

    /** @test */
    public function it_logs_in_with_correct_credentials()
    {
        $this->validCredentials = [
            'form.email' => $this->auth->email,
            'form.password' => 'Password123!',
        ];

        Livewire::test(LoginForm::class)
            ->set($this->validCredentials)
            ->call('submit')
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
    }

    /** @test */
    public function it_shows_error_for_invalid_credentials()
    {
        // Invalid credentials to test error handling
        $this->validCredentials = [
            'form.email' => 'test@example.com',
            'form.password' => 'Password123!',
        ];

        // Test the login form submission with incorrect credentials
        Livewire::test(LoginForm::class)
            ->set('form.email', 'wrong@example.com')  // Incorrect email
            ->set('form.password', 'wrongpass')      // Incorrect password
            ->call('submit')
            // Ensure that there are errors on the email field
            ->assertHasErrors(['form.email'])
            // Check that the error message is exactly what you expect
            ->assertHasError('form.email', 'Incorrect credentials');

        // Ensure that the user is still a guest (not logged in)
        $this->assertGuest();
    }

    /** @test */
    public function it_requires_email_and_password()
    {
        Livewire::test(LoginForm::class)
            ->set('form.email', '')
            ->set('form.password', '')
            ->call('submit')
            ->assertHasErrors([
                'form.email' => 'required',
                'form.password' => 'required',
            ]);
    }
}
