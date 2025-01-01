<?php

declare(strict_types=1);

namespace RichanFongdasen\Blueprint;

use RichanFongdasen\Blueprint\Commands\ValidateBlueprintCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BlueprintServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('blueprint')
            ->hasConfigFile()
            ->hasCommand(ValidateBlueprintCommand::class);
    }
}
