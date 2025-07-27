<?php

namespace App\Nova\Actions;

use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class BlockUsers extends Action
{
    public $name = 'Block Selected Users';

    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $user) {
            $user->update(['is_blocked' => true]);
        }

        return Action::message('Selected users have been blocked.');
    }
}
