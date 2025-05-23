<?php

namespace Ameth\Diamanka\Providers;

use Illuminate\Support\ServiceProvider;

class DiamankaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!class_exists(\Spatie\Permission\PermissionServiceProvider::class)) {
            throw new \RuntimeException(
                'Le package spatie/laravel-permissions doit être installé. ' .
                'Exécutez : composer require spatie/laravel-permission'
            );
        }
        // Publier les fichiers de configuration
        $this->publishes([
            __DIR__.'/../../config/diamanka.php' => config_path('diamanka.php'),
        ], 'config');

         $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/diamanka'),
        ], 'views');


        // // Charger les migrations
        // $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        // Charger les vues
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'diamanka');

        // Charger les routes
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php');
    }

    public function register()
    {
        // Fusionner la configuration
        $this->mergeConfigFrom(
            __DIR__.'/../../config/diamanka.php', 'diamanka'
        );
    }
}