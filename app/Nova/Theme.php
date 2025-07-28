<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Audio;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Theme extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Theme>
     */
    public static $model = \App\Models\Theme::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'title',
        'artist',
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

            Text::make('title')
                ->sortable()
                ->rules('required'),

            Text::make('artist')
                ->sortable()
                ->rules('required'),

            Audio::make('audio_url')
                ->creationRules('required', 'mimetypes:audio/mpeg,audio/wav', 'ends_with:.mp3,.wav')
                ->updateRules('mimetypes:audio/mpeg,audio/wav', 'ends_with:.mp3,.wav')
                ->disk('public')
                ->path('themes')
                ->preview(fn($value) => $value ? "/storage/{$value}" : null)
                ->hideFromIndex(),

            Select::make('Type')
                ->options([
                    'opening' => 'opening',
                    'ending' => 'ending',
                ])
                ->displayUsingLabels()
                ->sortable()
                ->rules('required'),
        ];
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
