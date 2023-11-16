<?php

namespace AymanAlhattami\FilamentDateScopesFilter;

use AymanAlhattami\FilamentApproval\Filament\Pages\ListModificationRelationMedia;
use AymanAlhattami\FilamentApproval\Filament\Resources\ApprovalResource;
use AymanAlhattami\FilamentApproval\Filament\Resources\DisapprovalResource;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentDateScopesFilterPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-date-scopes-filter';
    }

    public function register(Panel $panel): void
    {

    }

    public function boot(Panel $panel): void
    {

    }

    public static function make(): static
    {
        return app(static::class);
    }
}
