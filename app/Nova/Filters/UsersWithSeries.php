<?php

namespace App\Nova\Filters;

use Illuminate\Http\Request;
use Laravel\Nova\Filters\BooleanFilter;

class UsersWithSeries extends BooleanFilter
{
    public $name = 'Series Watched';

    /**
     * Apply the filter to the given query.
     */
    public function apply(Request $request, $query, $value)
    {
        if ($value['with_series']) {
            return $query->has('series');
        }

        if ($value['without_series']) {
            return $query->doesntHave('series');
        }

        return $query;
    }

    /**
     * The filter options.
     */
    public function options(Request $request)
    {
        return [
            'With Series' => 'with_series',
            'Without Series' => 'without_series',
        ];
    }
}
