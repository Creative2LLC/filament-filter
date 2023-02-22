<?php

namespace Creative2LLC\FilamentFilter;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Creative2LLC\FilamentFilter\Http\Livewire\QueryBuilder;
use Creative2LLC\FilamentFilter\Commands\FilamentFilterCommand;

class FilamentFilterServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-filter')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_filament-filter_table')
            ->hasCommand(FilamentFilterCommand::class);
    }



    public function bootingPackage()
    {
        Livewire::component('query-builder', QueryBuilder::class);
    }
}
