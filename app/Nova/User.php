<?php

namespace App\Nova;

use Carbon\Carbon;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use App\Nova\Actions\BlockUsers;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\BelongsTo;
use App\Nova\Filters\UsersWithSeries;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Auth\PasswordValidationRules;
use App\Nova\Metrics\UsersWithAndWithoutSeries;

class User extends Resource
{
    use PasswordValidationRules;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\User>
     */
    public static $model = \App\Models\User::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'first_name',
        'last_name',
        'email',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @return array<int, \Laravel\Nova\Fields\Field|\Laravel\Nova\Panel|\Laravel\Nova\ResourceTool|\Illuminate\Http\Resources\MergeValue>
     */
    public function fields(NovaRequest $request): array
    {
        $fields = [
            ID::make()->sortable(),

            Image::make('profile_photo')
                ->rules('required')
                ->disk('public')
                ->path('photos')
                ->creationRules('mimes:jpeg,png,webp,jpg', 'max:10240')
                ->preview(fn($value) => $value ? "/storage/{$value}" : null)
                ->thumbnail(fn($value) => $value ? "/storage/{$value}" : null),

            BelongsTo::make('role')
                ->sortable()
                ->rules('required')
                ->default(1),

            Text::make('first_name')
                ->sortable()
                ->rules('required'),

            Text::make('last_name')
                ->sortable()
                ->rules('required'),

            Text::make('email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            BelongsTo::make('gender')
                ->sortable()
                ->rules('required')
                ->hideFromIndex(),

            Date::make('date_of_birth')
                ->sortable()
                ->rules('required', 'date')
                ->hideFromIndex(),

            BelongsTo::make('country')
                ->sortable()
                ->rules('required')
                ->hideFromIndex(),

            Password::make('password')
                ->onlyOnForms()
                ->creationRules($this->passwordRules())
                ->updateRules($this->optionalPasswordRules()),

            Boolean::make('is_blocked')->sortable(),

            HasMany::make('Series Progress', 'seriesProgress', SeriesUser::class)
        ];

        if ($request->isResourceDetailRequest()) {
            $seriesCollection = $this->resource->series()->withPivot([
                'id',
                'start_date',
                'end_date',
                'episode_count',
                'score',
                'series_status_id',
            ])->get();

            foreach ($seriesCollection as $index => $series) {
                $fields[] = new Panel("Series #" . ($index + 1) . ": {$series->title}", [
                    Text::make('Title', fn() => $series->title),
                    Text::make('Status', fn() => $series->pivot->seriesStatus->name),
                    Text::make(
                        'Start - End',
                        fn() =>
                        Carbon::parse($series->pivot->start_date)->format('M Y') . ' - ' .
                            Carbon::parse($series->pivot->end_date)->format('M Y')
                    ),
                    Text::make('Episodes', fn() => $series->pivot->episode_count),
                    Text::make('Score', fn() => $series->pivot->score),
                ]);
            }
        }

        return $fields;
    }

    /**
     * Get the cards available for the request.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(NovaRequest $request): array
    {
        return [
            new UsersWithAndWithoutSeries(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @return array<int, \Laravel\Nova\Filters\Filter>
     */
    public function filters(NovaRequest $request): array
    {
        return [
            new UsersWithSeries(),
        ];
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
        return [
            new BlockUsers,
        ];
    }
}
