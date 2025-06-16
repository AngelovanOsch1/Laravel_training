<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\ProfilePhoto;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadProfilePhotoTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    #[Test]
    public function test_it_stores_image_and_updates_user_profile_photo_on_success()
    {
        $existingPhoto = UploadedFile::fake()->create('image.jpg', 100, 'image/jpeg');
        $existingPhotoPath = Storage::disk('public')->putFile('photos', $existingPhoto);

        $this->user->update(['profile_photo' => $existingPhotoPath]);

        $newPhoto = UploadedFile::fake()->create('image.jpg', 100, 'image/jpeg');

        Livewire::test(ProfilePhoto::class, ['user' => $this->user])
            ->set('form.photo', $newPhoto);

        $newPhotoPath = 'photos/' . $newPhoto->hashName();
        $this->assertTrue(Storage::disk('public')->exists($newPhotoPath));
        $this->assertFalse(Storage::disk('public')->exists($existingPhotoPath));

        $this->user->refresh();
        $this->assertEquals($newPhotoPath, $this->user->profile_photo);
    }

    #[Test]
    public function it_dispatches_warning_modal_when_invalid_mimes_is_uploaded()
    {
        $photo = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::test(ProfilePhoto::class, ['user' => $this->user])
            ->set('form.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.";
            });
    }

    #[Test]
    public function it_dispatches_warning_modal_when_file_exceeds_max_size()
    {
        $photo = UploadedFile::fake()->create('large-image.jpg', 10241, 'image/jpeg');

        Livewire::test(ProfilePhoto::class, ['user' => $this->user])
            ->set('form.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "The file size is too large. Maximum size is 10MB.";
            });
    }
}
