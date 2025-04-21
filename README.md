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

This package uses `spatie/laravel-translation-loader`, this means you will need to publish both their migrations and ours, in that order:
```bash
# In this order
php artisan vendor:publish --provider="Spatie\TranslationLoader\TranslationServiceProvider" --tag="translation-loader-migrations"
php artisan vendor:publish --provider="BeInteractive\TranslationScanner\TranslationScannerServiceProvider" --tag="translation-scanner-migrations"
```

After this you can run the migration:
```bash
php artisan migrate
```

## Usage
This package implements a bridge-like architecture to scan your projects for translations.
We do this by using `Scanners`, each of these have their own logic to scan for translations.

### Default scanners
By default, we ship with the following `Scanners`:

- Laravel translation files (scans in the laravel `lang` folder).
- Laravel scanner (scans for `trans` and `__` translations).
- Filament scanner (scans for everything within `make::` functions).
- Regex scanner (allows you to implement a custom regex to scan your projects).

### Basic Implementation
Actual usage of these looks like this:
```php
\BeInteractive\TranslationScanner\Facades\TranslationScanner::laravel()
    ->filament()
    ->regex('/test/')
    // This stores all language lines
    ->store();
```

You can add options to further improve your scan based on your needs:
```php
\BeInteractive\TranslationScanner\Facades\TranslationScanner::filament()->scanFiles();
```

### Store without deleting
By default, the `store()` function will also delete records from the language_lines table that were not found during that scan.
This might not be what you want so you can disble it:

```php
\BeInteractive\TranslationScanner\TranslationScanner::laravel()
    ->store(deleteLinesThatWereNotScanned: false);
```

### Only fetching the results
Sometimes you may want to execute your very own logic in handling the scanned language lines.
To do this you can do the following:

```php
\BeInteractive\TranslationScanner\TranslationScanner::laravel()
    ->getLanguageLines(); // Returns an array of all scanned translations
```

### Custom scanners
You can also create your own scanners to use your own scanning logic. A scanner might look something like this:

```php
use BeInteractive\TranslationScanner\Contracts\Scanner;

class MyCustomScanner implements Scanner
{
    /**
     * @return array{group: string, key: string, text: array{string, string}}
     */
    public function getLanguageLines(): array
    {
        return [
            [ 'group' => 'attributes', 'key' => 'name', 'text' => [ 'en' => 'Name' ] ],
        ];
    }
}
```

And then you can simply implement it using the facade.
```php
\BeInteractive\TranslationScanner\TranslationScanner::laravel()
    ->with(new MyCustomScanner())
    ->store();

// Or only use a custom scanner
\BeInteractive\TranslationScanner\TranslationScanner::with(new MyCustomScanner())
    ->store();
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits
- [Martijn Laffort](https://github.com/martijnlaffort)
- [Timo de Winter](https://github.com/timo-de-winter)
- [All Contributors](../../contributors)

## License
Please see [License File](LICENSE.md) for more information.
