<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;

namespace App\Nova\Metrics;

use App\Models\User;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Http\Requests\NovaRequest;

class UsersWithAndWithoutSeries extends Partition
{
    public function calculate(NovaRequest $request)
    {
        $withSeries = User::has('series')->count();
        $withoutSeries = User::doesntHave('series')->count();

        return $this->result([
            'With Series' => $withSeries,
            'Without Series' => $withoutSeries,
        ]);
    }

    public function name()
    {
        return 'Users Watching Series';
    }
}
