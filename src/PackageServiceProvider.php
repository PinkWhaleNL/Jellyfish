<?php

namespace Pinkwhale\Jellyfish;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class PackageServiceProvider extends ServiceProvider
{

    /**
     * @var string
     */
    protected $packageName = 'jf';

    /**
     * @var array
     */
    protected $commands = [
        //FooCommand::class;
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        // Load needed data.
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', $this->packageName);
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadTranslationsFrom(__DIR__.'/lang', $this->packageName);

        // Publish data into right folder.
        $this->publishes([__DIR__.'/lang' => resource_path('lang/vendor/'. $this->packageName)]);
        $this->publishes([__DIR__.'/assets/builds' => public_path('vendor/jellyfish')], 'public');
        $this->publishes([__DIR__.'/assets/fonts' => public_path('fonts')], 'public');
        $this->publishes([__DIR__.'/config/config.php' => config_path($this->packageName.'.php')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('GrahamCampbell\Markdown\MarkdownServiceProvider');

        AliasLoader::getInstance()->alias('Trans', 'Pinkwhale\Jellyfish\Models\Translations');
        AliasLoader::getInstance()->alias('Jelly', 'Pinkwhale\Jellyfish\Models\Content');
        AliasLoader::getInstance()->alias('JellyAuth', 'Pinkwhale\Jellyfish\Models\Users');
        AliasLoader::getInstance()->alias('JellyForms', 'Pinkwhale\Jellyfish\Models\Forms');
        AliasLoader::getInstance()->alias('JellyPreferences', 'Pinkwhale\Jellyfish\Models\Preferences');
        AliasLoader::getInstance()->alias('Image', 'Intervention\Image\Facades\Image');
        AliasLoader::getInstance()->alias('Carbon', 'Carbon\Carbon');
        AliasLoader::getInstance()->alias('Markdown', 'GrahamCampbell\Markdown\Facades\Markdown');

        $this->mergeConfigFrom(
            __DIR__.'/config/config.php',
            $this->packageName
        );
    }
}
