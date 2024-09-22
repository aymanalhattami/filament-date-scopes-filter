<?php

namespace AymanAlhattami\FilamentDateScopesFilter\Tests;

use AymanAlhattami\FilamentDateScopesFilter\FilamentDateScopesFilterServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            FilamentDateScopesFilterServiceProvider::class,
        ];
    }
}
