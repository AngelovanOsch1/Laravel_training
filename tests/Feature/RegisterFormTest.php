<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use App\Livewire\RegisterForm;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class RegisterFormTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormData;

    protected function setUp(): void
    {
        parent::setUp();

        $fakePassword = fake()->password(8);

        $this->baseFormData = [
            'form.email' => fake()->unique()->safeEmail(),
            'form.password' => $fakePassword,
            'form.password_confirmation' => $fakePassword,
            'form.firstName' => fake()->firstName(),
            'form.lastName' => fake()->lastName(),
            'form.country' => fake()->country(),
            'form.birthYear' => fake()->date('Y-m-d', '2000-01-01'),
            'form.gender' => fake()->randomElement(['male', 'female', 'other']),
        ];
    }

    #[Test]
    public function it_registers_a_user_and_authentication_record()
    {
        Livewire::test(RegisterForm::class)
            ->set($this->baseFormData)
            ->call('submit')
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => $this->baseFormData['form.email'],
            'first_name' => $this->baseFormData['form.firstName'],
            'last_name' => $this->baseFormData['form.lastName'],
            'country' => $this->baseFormData['form.country'],
            'date_of_birth' => $this->baseFormData['form.birthYear'],
            'gender' => $this->baseFormData['form.gender'],
        ]);

        $user = User::where('email', $this->baseFormData['form.email'])->first();
        $this->assertTrue(Hash::check($this->baseFormData['form.password'], $user->password));
    }

    #[Test]
    public function it_validates_required_fields()
    {
        $invalidData = array_replace($this->baseFormData, [
            'form.email' => '',
            'form.password' => '',
            'form.firstName' => '',
            'form.lastName' => '',
            'form.country' => '',
            'form.birthYear' => '',
            'form.gender' => '',
        ]);

        Livewire::test(RegisterForm::class)
            ->set($invalidData)
            ->call('submit')
            ->assertHasErrors([
                'form.email' => 'required',
                'form.password' => 'required',
                'form.firstName' => 'required',
                'form.lastName' => 'required',
                'form.country' => 'required',
                'form.birthYear' => 'required',
                'form.gender' => 'required',
            ]);
    }

    #[Test]
    public function it_requires_password_confirmation_to_match_password()
    {
        $passwordDontMatch = array_replace($this->baseFormData, [
            'form.password' => fake()->unique()->password(8),
            'form.password_confirmation' => fake()->unique()->password(8),
        ]);

        Livewire::test(RegisterForm::class)
            ->set($passwordDontMatch)
            ->call('submit')
            ->assertHasErrors([
                'form.password' => 'confirmed',
            ]);
    }

    #[Test]
    public function it_requires_password_to_be_at_least_8_characters_long()
    {
        $fakePassword = fake()->password(5);

        $shortPasswordData = array_replace($this->baseFormData, [
            'form.password' => $fakePassword,
            'form.password_confirmation' => $fakePassword,
        ]);

        Livewire::test(RegisterForm::class)
            ->set($shortPasswordData)
            ->call('submit')
            ->assertHasErrors([
                'form.password' => 'min',
            ]);
    }

    #[Test]
    public function it_requires_a_valid_email_address()
    {
        $invalidEmailData = array_replace($this->baseFormData, [
            'form.email' => fake()->firstName(),
        ]);

        Livewire::test(RegisterForm::class)
            ->set($invalidEmailData)
            ->call('submit')
            ->assertHasErrors([
                'form.email' => 'email',
            ]);
    }

    #[Test]
    public function it_requires_email_to_be_unique()
    {
        $user = User::factory()->create();

        $notUniqueEmailData = array_replace($this->baseFormData, [
            'form.email' => $user->email,
        ]);

        Livewire::test(RegisterForm::class)
            ->set($notUniqueEmailData)
            ->call('submit')
            ->assertHasErrors([
                'form.email' => 'unique',
            ]);
    }
}
