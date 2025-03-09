<?php

namespace Martijn Laffort\TranslationScanner;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TranslationScannerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('translation-scanner')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_translation_scanner_table');
    }
}
