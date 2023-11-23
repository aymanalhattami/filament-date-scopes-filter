# Filament Date Scopes Filter

[![Latest Version on Packagist](https://img.shields.io/packagist/v/aymanalhattami/filament-approval.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-date-scopes-filter)
[![Total Downloads](https://img.shields.io/packagist/dt/aymanalhattami/filament-date-scopes-filter.svg?style=flat-square)](https://packagist.org/packages/aymanalhattami/filament-date-scopes-filter)

Provide a filter by seconds, minutes, hours, days, weeks, months, quarter, years, decades and millenniums for table. 

![filament-page-with-sidebar](https://raw.githubusercontent.com/aymanalhattami/filament-date-scopes-filter/main/images/filament-date-scopes-filter.png){.filament-hidden}

## Installation

At first, this package depends on [laravel date scops](https://github.com/laracraft-tech/laravel-date-scopes). Please read the [laravel date scops](https://github.com/laracraft-tech/laravel-date-scopes) document and prepare your model(s) to be filtered by date scopes.

You can install the package via composer:

```bash
composer require aymanalhattami/filament-date-scopes-filter
```

## Usage



```php
use AymanAlahttami\FilamentDateScopesFIlter\DateScopeFilter;

// ...
public static function table(Table $table): Table
{
    return $table
        ->filters([
            DateScopeFilter::make('created_at'),
        ]))
    // ...
}
// ...
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
