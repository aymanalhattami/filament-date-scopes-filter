<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentDateScopesFilterServiceProvider extends PackageServiceProvider
{
    protected string $name = 'filament-date-scopes-filter';

    public function configurePackage(Package $package): void
    {
        $package
            ->name($this->name)
            ->hasTranslations();
    }
}
