<?php

namespace AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages;

use Approval\Enums\ActionEnum;
use Approval\Enums\ModificationStatusEnum;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource;
use AymanAlhattami\FilamentApproval\ModificationResourceSchema;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListModifications extends ListRecords
{
    protected static string $resource = ModificationResource::class;

    public function getTabs(): array
    {
        return ModificationResourceSchema::getTabs();
    }
}
