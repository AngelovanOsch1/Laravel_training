<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\ProfileBanner;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadProfileBannerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_it_stores_image_and_updates_user_profile_banner_on_success()
    {
        Storage::fake('public');

        $existingBanner = UploadedFile::fake()->create('banner.jpg', 100, 'image/jpeg');
        $existingBannerPath = Storage::disk('public')->putFile('banners', $existingBanner);

        $user = User::factory()->create([
            'profile_banner' => $existingBannerPath,
        ]);

        $this->actingAs($user);

        $newBanner = UploadedFile::fake()->create('banner.jpg', 100, 'image/jpeg');

        Livewire::test(ProfileBanner::class, ['profileBanner' => null])
            ->set('form.photo', $newBanner);

        $newBannerPath = 'banners/' . $newBanner->hashName();

        $this->assertTrue(Storage::disk('public')->exists($newBannerPath));
        $this->assertFalse(Storage::disk('public')->exists($existingBannerPath));

        $user->refresh();
        $this->assertEquals($newBannerPath, $user->profile_banner);
    }

    #[Test]
    public function it_dispatches_warning_modal_when_invalid_mimes_is_uploaded()
    {
        $photo = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::test(ProfileBanner::class, ['profileBanner' => null])
            ->set('form.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.";
            });
    }

    #[Test]
    public function it_dispatches_warning_modal_when_file_exceeds_max_size()
    {
        $photo = UploadedFile::fake()->create('large-image.jpg', 10241, 'image/jpeg');

        Livewire::test(ProfileBanner::class, ['profileBanner' => null])
            ->set('form.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "The file size is too large. Maximum size is 10MB.";
            });
    }
}
