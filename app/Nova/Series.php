<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;
use Illuminate\Contracts\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Builder as ConcreteBuilder;


class Series extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Series>
     */
    public static $model = \App\Models\Series::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field>
     */
    public function fields(NovaRequest $request): array
    {
        return [
            ID::make()->sortable(),

            Image::make('cover_image')
                ->disk('public')
                ->path('series')
                ->creationRules('required', 'mimes:jpeg,png,webp,jpg', 'max:10240')
                ->updateRules('mimes:jpeg,png,webp,jpg', 'max:10240')
                ->preview(fn($value) => $value ? "/storage/{$value}" : null)
                ->thumbnail(fn($value) => $value ? "/storage/{$value}" : null),


            Text::make('title')
                ->sortable()
                ->rules('required'),

            Text::make('type')
                ->sortable()
                ->rules('required'),

            BelongsToMany::make('Genres'),

            Number::make('episode_count')
                ->sortable()
                ->rules('required'),

            Number::make('minutes_per_episode')
                ->rules('required')
                ->hideFromIndex()
                ->displayUsing(function ($value) {
                    $hours = floor($value / 60);
                    $minutes = $value % 60;

                    if ($hours > 0) {
                        return "{$hours}h {$minutes}m";
                    }

                    return "{$minutes}m";
                })
                ->sortable(),

            Number::make('score')
                ->sortable()
                ->default(0),

            Hidden::make('owner_id')
                ->default(fn($request) => $request->user()->id),

            Text::make('video')
                ->rules('required')
                ->hideFromIndex(),

            Date::make('aired_start_date')
                ->sortable()
                ->rules('required', 'date')
                ->hideFromIndex(),

            Date::make('aired_end_date')
                ->sortable()
                ->rules('required', 'date')
                ->hideFromIndex(),

            BelongsToMany::make('studios'),

            Textarea::make('synopsis')
                ->hideFromIndex()
                ->rules('required'),

            HasMany::make('Themes'),
        ];
    }

    public static function indexQuery(NovaRequest $request, EloquentBuilder $query): EloquentBuilder
    {
        /** @var ConcreteBuilder $query */
        if ($request->user()->email === 'Angelo.van.Osch@hotmail.com') {
            return $query;
        }

        return $query->where('owner_id', $request->user()->id);
    }

    /**
     * Get the cards available for the resource.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @return array<int, \Laravel\Nova\Lenses\Lens>
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @return array<int, \Laravel\Nova\Actions\Action>
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }
}
