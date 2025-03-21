# Laravel Translation Scanner
This package scans your projects for translations and integrates them into spatie translation loader.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/be-interactive/translation-scanner.svg?style=flat-square)](https://packagist.org/packages/be-interactive/translation-scanner)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/be-interactive/translation-scanner/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/be-interactive/translation-scanner/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/be-interactive/translation-scanner/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/be-interactive/translation-scanner/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/be-interactive/translation-scanner.svg?style=flat-square)](https://packagist.org/packages/be-interactive/translation-scanner)


## Installation

You can install the package via composer:
```bash
composer require be-interactive/laravel-translation-scanner
```

This package uses `spatie/laravel-translation-loader`, publish their migration file using:
```bash
php artisan vendor:publish --provider="Spatie\TranslationLoader\TranslationServiceProvider" --tag="migrations"
```

You have to update the migration file to the following:
```php
Schema::create('language_lines', function (Blueprint $table) {
    $table->bigIncrements('id');
    $table->string('group')->index();
    $table->text('key');
    $table->json('text');
    $table->timestamps();
});
```

After this you can run the migration:
```bash
php artisan migrate
```

If you don't already have a `lang` directory in your repository, create the directory.

## Usage
Using the scanFiles() function, the package will scan all php files and add the basic translations to the language_lines database table.
```php
\BeInteractive\TranslationScanner\Facades\TranslationScanner::scanFiles();
```

You can add options to further improve your scan based on your needs:
```php
\BeInteractive\TranslationScanner\Facades\TranslationScanner::filament->scanFiles();
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities
Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- [Martijn Laffort](https://github.com/martijnlaffort)
- [Timo de Winter](https://github.com/timo-de-winter)
- [All Contributors](../../contributors)

## License
Please see [License File](LICENSE.md) for more information.
