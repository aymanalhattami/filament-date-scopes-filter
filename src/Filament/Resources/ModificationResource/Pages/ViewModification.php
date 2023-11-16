<?php

namespace AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages;

use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\ViewRecord;

class ViewModification extends ViewRecord
{
    use HasPageSidebar;

    protected static string $resource = ModificationResource::class;
}
