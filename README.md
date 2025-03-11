# A package that scans you repo for translations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/martijnlaffort/translation-scanner.svg?style=flat-square)](https://packagist.org/packages/martijnlaffort/translation-scanner)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/martijnlaffort/translation-scanner/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/martijnlaffort/translation-scanner/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/martijnlaffort/translation-scanner/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/martijnlaffort/translation-scanner/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/martijnlaffort/translation-scanner.svg?style=flat-square)](https://packagist.org/packages/martijnlaffort/translation-scanner)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.
## Installation

You can install the package via composer:
```bash
composer require martijnlaffort/translation-scanner
```

You can publish and run the migrations with:
```bash
php artisan vendor:publish --tag="translation-scanner-migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --tag="translation-scanner-config"
```

This is the contents of the published config file:
```php
return [
];
```

Optionally, you can publish the views using
```bash
php artisan vendor:publish --tag="translation-scanner-views"
```

## Usage
```php
$translationScanner = new MartijnLaffort\TranslationScanner();
echo $translationScanner->echoPhrase('Hello, Martijn Laffort!');
```

## Testing
```bash
composer test
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities
Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits
- [Martijn Laffort](https://github.com/martijnlaffort)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
