<?php

namespace App\Providers;

use App\Nova\Role;
use App\Nova\User;
use App\Nova\Theme;
use App\Nova\Gender;
use App\Nova\Series;
use App\Nova\Studio;
use App\Nova\Country;
use Laravel\Nova\Nova;
use App\Nova\SeriesUser;
use App\Nova\SeriesStatus;
use Laravel\Fortify\Features;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Dashboards\Main;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        Nova::mainMenu(function () {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('Resources', [
                    MenuItem::resource(User::class),
                    MenuItem::resource(Country::class),
                    MenuItem::resource(Gender::class),
                    MenuItem::resource(Role::class),
                    MenuItem::resource(Series::class),
                    MenuItem::resource(SeriesStatus::class),
                    MenuItem::resource(SeriesUser::class),
                    MenuItem::resource(Studio::class),
                    MenuItem::resource(Theme::class),
                ])->icon('user')->collapsable(),

                MenuSection::make('API Docs', [
                    MenuItem::externalLink('Swagger Documentation', url('/api/documentation'))
                        ->openInNewTab(),
                ]),
            ];
        });
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function (User $user) {
            return in_array($user->email, [
                'angelo.van.osch@hotmail.com',
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Dashboard>
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Tool>
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        //
    }
}
