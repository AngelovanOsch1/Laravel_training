<?php

namespace Tests\Feature;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Comments;
use App\Models\Reaction;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormData;
    private User $loggedInUser;
    private User $targetUser;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->loggedInUser = User::factory()->create();
        $this->actingAs($this->loggedInUser);

        $this->targetUser = User::factory()->create();

        $this->baseFormData = [
            'form.message' => fake()->sentence(),
            'form.photo' => null,
        ];
    }

    #[Test]
    public function it_inserts_comment_record_on_user_page()
    {
        Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set($this->baseFormData)
            ->call('submit');

        $this->assertDatabaseHas('comments', [
            'message' => $this->baseFormData['form.message'],
            'photo' => $this->baseFormData['form.photo'],
            'commentable_id' => $this->targetUser->id,
            'commentable_type' => User::class,
            'user_id' => $this->loggedInUser->id,
        ]);
    }

    #[Test]
    public function it_inserts_comment_record_on_user_pages_with_photo()
    {
        $newPhoto = UploadedFile::fake()->create('image.jpg', 100, 'image/jpeg');
        $newPhotoPath = 'commentsPhotos/' . $newPhoto->hashName();

        $FormDataWithPhoto = array_replace($this->baseFormData, [
            'form.photo' => $newPhoto,
            'form.message' => null,
        ]);

        Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set($FormDataWithPhoto)
            ->call('submit');

        $this->assertDatabaseHas('comments', [
            'message' => $FormDataWithPhoto['form.message'],
            'photo' => $newPhotoPath,
            'commentable_id' => $this->targetUser->id,
            'commentable_type' => User::class,
            'user_id' => $this->loggedInUser->id,
        ]);

        $this->assertTrue(Storage::disk('public')->exists($newPhotoPath));
    }

    #[Test]
    public function it_inserts_comment_too_many_characters()
    {
        $invalidMessageData = array_replace($this->baseFormData, [
            'form.message' => Str::random(301),
        ]);

        Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set($invalidMessageData)
            ->call('submit')
            ->assertHasErrors([
                'form.message' => 'max',
            ]);
    }

    #[Test]
    public function it_dispatches_warning_modal_when_invalid_mimes_is_uploaded()
    {
        $photo = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set('form.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.";
            });
    }

    #[Test]
    public function it_dispatches_warning_modal_when_file_exceeds_max_size()
    {
        $photo = UploadedFile::fake()->create('large-image.jpg', 10241, 'image/jpeg');

        Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set('form.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "The file size is too large. Maximum size is 10MB.";
            });
    }

    #[Test]
    public function it_updates_sorting_when_sort_by_field_is_changed_to_newest()
    {
        $comment1 = Comment::factory()->create([
            'created_at' => now()->subMinute(),
            'commentable_id' => $this->targetUser->id,
            'user_id' => $this->loggedInUser->id,
        ]);

        $comment2 = Comment::factory()->create([
            'created_at' => now(),
            'commentable_id' => $this->targetUser->id,
            'user_id' => $this->loggedInUser->id,
        ]);

        $commentList = Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set('form.sortBy', 'created_at')->viewData('commentsList');

        $this->assertSame($comment2->id, $commentList[0]->id);
        $this->assertSame($comment1->id, $commentList[1]->id);
    }


    #[Test]
    public function it_updates_sorting_when_sort_by_field_is_changed_to_most_likes()
    {
        Comment::factory()->create([
            'commentable_id' => $this->targetUser->id,
            'user_id' => $this->loggedInUser->id,
        ]);

        $comment = Comment::factory()->create([
            'commentable_id' => $this->targetUser->id,
            'user_id' => $this->loggedInUser->id,
        ]);

        Reaction::factory()->create([
            'reactionable_type' => Comment::class,
            'reactionable_id' => $comment->id,
            'user_id' => $this->targetUser->id,
            'type' => 'like',
        ]);

        $commentList = Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->set('form.sortBy', 'likes_count')->viewData('commentsList');

        $this->assertSame($comment->id, $commentList[0]->id);
    }

    #[Test]
    public function it_delete_reply()
    {
        $parentComment = Comment::factory()->create();
        $childComment = Comment::factory()->create([
            'parent_id' => $parentComment->id,
        ]);

        Livewire::test(Comments::class, ['id' => $this->targetUser->id])
            ->call('deleteComment', $childComment->id)
            ->assertDispatched("childCommentDeleted.{$parentComment->id}");

        $this->assertDatabaseMissing('comments', [
            'id' => $childComment->id,
        ]);
    }
}
