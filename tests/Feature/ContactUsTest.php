<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\ContactUs;
use Illuminate\Support\Str;
use App\Mail\ContactUsMessage;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactUsTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormData;
    private User $loggedInUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->loggedInUser = User::factory()->create();
        $this->actingAs($this->loggedInUser);

        $this->baseFormData = [
            'form.name' => fake()->firstName(),
            'form.email' => fake()->unique()->safeEmail(),
            'form.message' => Str::random(350),
        ];
    }

    #[Test]
    public function it_sends_email_succesfully()
    {
        Mail::fake();
        config(['mail.contact_us_receiver' => 'test@example.com']);

        Livewire::test(ContactUs::class)
            ->set($this->baseFormData)
            ->call('submit')
            ->assertRedirect(route('profile', ['id' => $this->loggedInUser->id]));

        Mail::assertSent(ContactUsMessage::class);
    }

    #[Test]
    public function it_validates_required_fields()
    {
        $invalidData = array_replace($this->baseFormData, [
            'form.name' => '',
            'form.email' => '',
            'form.message' => '',
        ]);

        Livewire::test(ContactUs::class)
            ->set($invalidData)
            ->call('submit')
            ->assertHasErrors([
                'form.name' => 'required',
                'form.email' => 'required',
                'form.message' => 'required',
            ]);
    }

    #[Test]
    public function it_required_safe_email_for_email_input()
    {
        $invalidData = array_replace($this->baseFormData, [
            'form.email' => str_replace('@', '', fake()->safeEmail()),
        ]);

        Livewire::test(ContactUs::class)
            ->set($invalidData)
            ->call('submit')
            ->assertHasErrors([
                'form.email' => 'email',
            ]);
    }

    #[Test]
    public function it_max_character_message_input()
    {
        $invalidData = array_replace($this->baseFormData, [
            'form.message' => Str::random(501),
        ]);

        Livewire::test(ContactUs::class)
            ->set($invalidData)
            ->call('submit')
            ->assertHasErrors([
                'form.message' => 'max',
            ]);
    }
}
