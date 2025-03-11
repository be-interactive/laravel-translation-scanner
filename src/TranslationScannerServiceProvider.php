<?php

namespace BeInteractive\TranslationScanner;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class TranslationScannerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('translation-scanner')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_translation_scanner_table');
    }
}
