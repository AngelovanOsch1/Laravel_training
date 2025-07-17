<?php

use App\Models\Contact;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{contactId}', function ($user, $contactId) {
    return Contact::where('id', $contactId)
        ->where(function ($q) use ($user) {
            $q->where('user_one_id', $user->id)
                ->orWhere('user_two_id', $user->id);
        })->exists();
});
