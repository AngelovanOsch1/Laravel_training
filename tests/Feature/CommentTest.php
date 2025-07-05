<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use PHPUnit\Framework\Attributes\Test;
use App\Models\Comment as CommentModel;
use App\Models\Reaction;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private array $baseFormDataUpdatedComment;
    private array $baseFormDataReply;
    private User $loggedInUser;
    private User $targetUser;
    private CommentModel $comment;
    private string $existingPhotoPath;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->loggedInUser = User::factory()->create();
        $this->actingAs($this->loggedInUser);

        $this->targetUser = User::factory()->create();

        $existingPhoto = UploadedFile::fake()->create('image.jpg', 100, 'image/jpeg');
        $this->existingPhotoPath = Storage::disk('public')->putFile('commentsPhotos/', $existingPhoto);

        $this->comment = CommentModel::factory()->create(
            ['photo' => $this->existingPhotoPath]
        );

        $this->baseFormDataUpdatedComment = [
            'updateCommentform.message' => fake()->sentence(),
            'updateCommentform.photo' => null,
        ];

        $this->baseFormDataReply = [
            'replyForm.message' => fake()->sentence(),
            'replyForm.photo' => null,
        ];
    }

    #[Test]
    public function it_update_comment_on_user_page_text()
    {
        Livewire::test(Comment::class, ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set($this->baseFormDataUpdatedComment)
            ->call('updateComment');

        $this->comment->refresh();

        $this->assertEquals($this->baseFormDataUpdatedComment['updateCommentform.message'], $this->comment->message);
        $this->assertEquals($this->existingPhotoPath, $this->comment->photo);
    }

    #[Test]
    public function it_update_comment_on_user_page_photo()
    {
        $newPhoto = UploadedFile::fake()->create('image.jpg', 100, 'image/jpeg');
        $newPhotoPath = 'commentsPhotos/' . $newPhoto->hashName();

        $FormDataWithPhoto = array_replace($this->baseFormDataUpdatedComment, [
            'updateCommentform.photo' => $newPhoto,
            'updateCommentform.message' => null,
        ]);

        Livewire::test(Comment::class, ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set($FormDataWithPhoto)
            ->call('updateComment');

        $this->assertTrue(Storage::disk('public')->exists($newPhotoPath));
        $this->assertFalse(Storage::disk('public')->exists($this->existingPhotoPath));

        $this->comment->refresh();

        $this->assertEquals($FormDataWithPhoto['updateCommentform.message'], $this->comment->message);
        $this->assertEquals($newPhotoPath, $this->comment->photo);
    }

    #[Test]
    public function it_inserts_comment_too_many_characters_updated_comment()
    {
        $invalidMessageData = array_replace($this->baseFormDataUpdatedComment, [
            'updateCommentform.message' => Str::random(301),
        ]);

        Livewire::test(Comment::class, ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set($invalidMessageData)
            ->call('updateComment')
            ->assertHasErrors([
                'updateCommentform.message' => 'max',
            ]);
    }

    #[Test]
    public function it_dispatches_warning_modal_when_invalid_mimes_is_uploaded_updated_comment()
    {
        $photo = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set('updateCommentform.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.";
            });
    }

    #[Test]
    public function it_dispatches_warning_modal_when_file_exceeds_max_size_updated_comment()
    {
        $photo = UploadedFile::fake()->create('large-image.jpg', 10241, 'image/jpeg');

        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set('updateCommentform.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "The file size is too large. Maximum size is 10MB.";
            });
    }


    #[Test]
    public function it_reply_comment__on_user_page_text()
    {
        Livewire::test(Comment::class, ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set($this->baseFormDataReply)
            ->call('submitReply');

        $this->assertDatabaseHas('comments', [
            'parent_id' => $this->comment->id,
            'message' => $this->baseFormDataReply['replyForm.message'],
            'photo' => $this->baseFormDataReply['replyForm.photo'],
            'commentable_id' => $this->comment->commentable_id,
            'commentable_type' => User::class,
            'user_id' => $this->loggedInUser->id,
        ]);
    }

    #[Test]
    public function it_reply_comment_on_user_page_photo()
    {
        $newPhoto = UploadedFile::fake()->create('image.jpg', 100, 'image/jpeg');
        $newPhotoPath = 'commentsPhotos/' . $newPhoto->hashName();

        $FormDataWithPhoto = array_replace($this->baseFormDataReply, [
            'replyForm.photo' => $newPhoto,
            'replyForm.message' => null,
        ]);

        Livewire::test(Comment::class, ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set($FormDataWithPhoto)
            ->call('submitReply');

        $this->assertTrue(Storage::disk('public')->exists($newPhotoPath));

        $this->assertDatabaseHas('comments', [
            'parent_id' => $this->comment->id,
            'message' => $FormDataWithPhoto['replyForm.message'],
            'photo' => $newPhotoPath,
            'commentable_id' => $this->comment->commentable_id,
            'commentable_type' => User::class,
            'user_id' => $this->loggedInUser->id,
        ]);
    }

    #[Test]
    public function it_inserts_comment_too_many_characters_reply_comment()
    {
        $invalidMessageData = array_replace($this->baseFormDataReply, [
            'replyForm.message' => Str::random(301),
        ]);

        Livewire::test(Comment::class, ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set($invalidMessageData)
            ->call('submitReply')
            ->assertHasErrors([
                'replyForm.message' => 'max',
            ]);
    }

    #[Test]
    public function it_dispatches_warning_modal_when_invalid_mimes_is_reply_comment()
    {
        $photo = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set('replyForm.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "Unsupported file format. Only JPEG, PNG, WEBP and JPG formats are supported.";
            });
    }

    #[Test]
    public function it_dispatches_warning_modal_when_file_exceeds_max_size_reply_comment()
    {
        $photo = UploadedFile::fake()->create('large-image.jpg', 10241, 'image/jpeg');

        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->set('replyForm.photo', $photo)
            ->assertDispatched('openWarningModal', function ($event, $param) {
                return $param[0]['body'] === "The file size is too large. Maximum size is 10MB.";
            });
    }

    #[Test]
    public function it_toggle_reaction_on_comment_like()
    {
        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->call('toggleReaction', 'like');

        $this->assertDatabaseHas('reactions', [
            'user_id' => $this->loggedInUser->id,
            'reactionable_id' => $this->comment->id,
            'reactionable_type' => CommentModel::class,
            'type' => 'like',
        ]);
    }

    #[Test]
    public function it_toggle_reaction_on_comment_dislike()
    {
        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->call('toggleReaction', 'dislike');

        $this->assertDatabaseHas('reactions', [
            'user_id' => $this->loggedInUser->id,
            'reactionable_id' => $this->comment->id,
            'reactionable_type' => CommentModel::class,
            'type' => 'dislike',
        ]);
    }


    #[Test]
    public function it_toggle_reaction_on_comment_remove_like()
    {
        $existingReaction = Reaction::factory()->create(
            [
                'user_id' => $this->loggedInUser->id,
                'reactionable_id' => $this->comment->id,
                'reactionable_type' => CommentModel::class,
                'type' => 'like',
            ]
        );

        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->call('toggleReaction', 'dislike');

        $this->assertDatabaseMissing('reactions', [
            'user_id' => $existingReaction->user_id,
            'reactionable_id' => $existingReaction->reactionable_id,
            'reactionable_type' => $existingReaction->reactionable_type,
            'type' => $existingReaction->type,
        ]);
    }

    #[Test]
    public function it_toggle_reaction_on_comment_remove_dislike()
    {
        $existingReaction = Reaction::factory()->create(
            [
                'user_id' => $this->loggedInUser->id,
                'reactionable_id' => $this->comment->id,
                'reactionable_type' => CommentModel::class,
                'type' => 'dislike',
            ]
        );

        Livewire::test(Comment::class,  ['comment' => $this->comment, 'user' => $this->targetUser, 'loggedInUser' => $this->loggedInUser])
            ->call('toggleReaction', 'like');

        $this->assertDatabaseMissing('reactions', [
            'user_id' => $existingReaction->user_id,
            'reactionable_id' => $existingReaction->reactionable_id,
            'reactionable_type' => $existingReaction->reactionable_type,
            'type' => $existingReaction->type,
        ]);
    }
}
