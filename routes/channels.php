<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{receiverId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});
