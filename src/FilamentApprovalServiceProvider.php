<?php

namespace AymanAlhattami\FilamentApproval;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentApprovalServiceProvider extends PackageServiceProvider
{
    protected string $name = 'filament-approval';

    public function configurePackage(Package $package): void
    {
        $package
            ->name($this->name)
            ->hasConfigFile()
            ->hasViews();
    }
}
