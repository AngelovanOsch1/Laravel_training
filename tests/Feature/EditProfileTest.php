<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Livewire\EditProfile;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProfileTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormData;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->baseFormData = [
            'form.firstName' => fake()->firstName(),
            'form.lastName' => fake()->lastName(),
            'form.country' => Country::factory()->create()->id,
            'form.birthYear' => fake()->date('Y-m-d', '2000-01-01'),
            'form.gender' => fake()->randomElement(['Male', 'Female', 'Other']),
            'form.description' => Str::random(50)
        ];
    }

    #[Test]
    public function it_updates_all_profile_fields_for_authenticated_user()
    {
        $formData = $this->baseFormData;

        Livewire::test(EditProfile::class)
            ->set($formData)
            ->call('submit');

        $this->user->refresh();

        $this->assertEquals($formData['form.firstName'], $this->user->first_name);
        $this->assertEquals($formData['form.lastName'], $this->user->last_name);
        $this->assertEquals($formData['form.country'], $this->user->country_id);
        $this->assertEquals($formData['form.birthYear'], Carbon::parse($this->user->date_of_birth)->toDateString());
        $this->assertEquals($formData['form.gender'], $this->user->gender);
        $this->assertEquals($formData['form.description'], $this->user->description);
    }

    #[Test]
    public function it_validates_required_fields()
    {
        $invalidData = array_replace($this->baseFormData, [
            'form.firstName' => '',
            'form.lastName' => '',
            'form.country' => '',
            'form.birthYear' => '',
            'form.gender' => '',
        ]);

        Livewire::test(EditProfile::class)
            ->set($invalidData)
            ->call('submit')
            ->assertHasErrors([
                'form.firstName' => 'required',
                'form.lastName' => 'required',
                'form.country' => 'required',
                'form.birthYear' => 'required',
                'form.gender' => 'required',
            ]);
    }

    #[Test]
    public function it_description_too_many_characters()
    {
        $invalidDescriptionData = array_replace($this->baseFormData, [
            'form.description' => Str::random(101),
        ]);

        Livewire::test(EditProfile::class, ['user' => $this->user])
            ->set($invalidDescriptionData)
            ->call('submit')
            ->assertHasErrors([
                'form.description' => 'max',
            ]);
    }
}
