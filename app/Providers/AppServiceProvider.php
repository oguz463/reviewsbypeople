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
            // Explicit URL schemes or a "www." host.
            if (preg_match('~\b(?:https?|ftp)://~i', $value) || preg_match('~\bwww\.[a-z0-9-]~i', $value)) {
                return false;
            }
            // Bare domain (example.com, foo.co.uk/path) with a real-looking TLD.
            // Deliberately narrow so ordinary sentences that end "word." pass.
            $tlds = 'com|net|org|io|co|info|biz|edu|gov|mil|dev|app|xyz|shop|store|online|site|club|top|link|'
                . 'click|live|life|art|beauty|icu|cyou|pro|me|tv|cc|us|uk|de|ru|fr|nl|in|ca|au|es|it|pl|br|tr|eu';
            if (preg_match('~\b[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.(?:' . $tlds . ')\b(?:[/?#]\S*)?~i', $value)) {
                return false;
            }
            return true;
        }, trans('messages.nourl-rule'));
    }
}
