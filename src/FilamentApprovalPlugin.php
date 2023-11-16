<?php

namespace AymanAlhattami\FilamentApproval;

use AymanAlhattami\FilamentApproval\Filament\Pages\ListModificationRelationMedia;
use AymanAlhattami\FilamentApproval\Filament\Resources\ApprovalResource;
use AymanAlhattami\FilamentApproval\Filament\Resources\DisapprovalResource;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource;
use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentApprovalPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-approval';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                ModificationResource::class,
                ApprovalResource::class,
                DisapprovalResource::class
            ])
            ->pages([
                ListModificationRelationMedia::class,
            ]);
    }

    public function boot(Panel $panel): void
    {

    }

    public static function make(): static
    {
        return app(static::class);
    }
}
