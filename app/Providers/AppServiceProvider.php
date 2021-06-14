<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\Builder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (app()->isLocal()) {
            app()->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));

        Builder::macro('with', function (array $p) {
            $this->model->withRelations($p);
            return $this;
        });

        Validator::extend('alpha_spaces', function ($attribute, $value) {
            return preg_match('/^[\pL\s.]+$/u', $value);
        }, trans('messages.alpha_spaces-rule'));

        Validator::extend('url_not_allowed', function ($attribute, $value) {
            return preg_match('/(?:(?:https?|ftp):\/\/|\b(?:[a-z\d]+\.))(?:(?:[^\s()<>]+|\((?:[^\s()<>]+|(?:\([^\s()<>]+\)))?\))+(?:\((?:[^\s()<>]+|(?:\(?:[^\s()<>]+\)))?\)|[^\s\`!()\[\]{};:\'".,<>?«»“”‘’]))?/i', $value) === 0;
        }, trans('messages.nourl-rule'));
    }
}
