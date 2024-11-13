# Filament Date Scopes Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aymanalhattami/filament-date-scopes-filter.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-date-scopes-filter)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/aymanalhattami/filament-date-scopes-filter/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/aymanalhattami/filament-date-scopes-filter/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/aymanalhattami/filament-date-scopes-filter.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-date-scopes-filter)

Provide a filter by seconds, minutes, hours, days, weeks, months, quarter, years, decades and millenniums for table. 

<img src="https://raw.githubusercontent.com/aymanalhattami/filament-date-scopes-filter/main/images/filament-date-scopes-filter.png" class="filament-hidden">

## Installation

At first, this package depends on [laravel date scops](https://github.com/laracraft-tech/laravel-date-scopes). Please read the [laravel date scops](https://github.com/laracraft-tech/laravel-date-scopes) document and prepare your model(s) to be filtered by date scopes.

You can install the package via composer:

```bash
composer require aymanalhattami/filament-date-scopes-filter
```

## Usage



```php
use AymanAlhattami\FilamentDateScopesFIlter\DateScopeFilter;

// ...
public static function table(Table $table): Table
{
    return $table
        ->filters([
            DateScopeFilter::make('created_at'),
        ])
    // ...
}
// ...
```

#### Translations

Publish the translations using:

```bash
php artisan vendor:publish --tag="filament-date-scopes-filter-translations"
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email ayman.m.alhattami@gmail.com instead of using the issue tracker.

## Credits

-   [Ayman Alhattami](https://github.com/aymanalhattami)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
