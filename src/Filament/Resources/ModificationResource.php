<?php

namespace AymanAlhattami\FilamentApproval\Filament\Resources;

use Approval\Enums\ModificationStatusEnum;
use Approval\Models\Modification;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages\ListModificationMedia;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages\ListModificationRelations;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages\ListModifications;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages\ViewModification;
use AymanAlhattami\FilamentApproval\Infolists\Components\JsonEntry;
use AymanAlhattami\FilamentApproval\ModificationResourceSchema;
use AymanAlhattami\FilamentPageWithSidebar\FilamentPageSidebar;
use AymanAlhattami\FilamentPageWithSidebar\PageNavigationItem;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ModificationResource extends Resource
{
    protected static ?string $model = Modification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-approval.navigationGroup', 'Modifications'));
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-approval.navigationSort', 1);
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make(static::getNavigationLabel())
                ->group(static::getNavigationGroup())
                ->icon(static::getNavigationIcon())
                ->activeIcon(static::getActiveNavigationIcon())
                ->isActiveWhen(function () {
                    return request()->routeIs(static::getRouteBaseName().'.index')
                        || request()->routeIs(static::getRouteBaseName().'.view')
                        || request()->routeIs(static::getRouteBaseName().'.relations')
                        || request()->routeIs(static::getRouteBaseName().'.media');
                })
                ->badge(static::getNavigationBadge(), color: static::getNavigationBadgeColor())
                ->sort(static::getNavigationSort())
                ->url(static::getNavigationUrl()),
        ];
    }

    public static function sidebar(Modification $record): FilamentPageSidebar
    {
        return FilamentPageSidebar::make()
            ->setTitle($record->modifiable_type)
            ->setDescription(__('Id').':'.$record->id)
            ->setNavigationItems([
                PageNavigationItem::make(__('View'))
                    ->url(function () use ($record) {
                        return ViewModification::getUrl(['record' => $record->id]);
                    })->icon('heroicon-o-rectangle-stack')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName().'.view');
                    })->visible(true),
                PageNavigationItem::make(__('Relations'))
                    ->url(function () use ($record) {
                        return ListModificationRelations::getUrl(['record' => $record->id]);
                    })->icon('heroicon-o-rectangle-stack')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName().'.relations');
                    })->visible(true),
                PageNavigationItem::make(__('Media'))
                    ->url(function () use ($record) {
                        return ListModificationMedia::getUrl(['record' => $record->id]);
                    })->icon('heroicon-o-rectangle-stack')
                    ->isActiveWhen(function () {
                        return request()->routeIs(static::getRouteBaseName().'.media');
                    })->visible(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(ModificationResourceSchema::getTableColumns())
            ->defaultSort(ModificationResourceSchema::getTableDefaultSortColumn(), ModificationResourceSchema::getTableDefaultSortDirection())
            ->filters(ModificationResourceSchema::getTableFilter())
            ->actions(ModificationResourceSchema::getTableActions())
            ->bulkActions(ModificationResourceSchema::getTableBulkActions());
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make()
                ->schema(ModificationResourceSchema::getInfolist())->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListModifications::route('/'),
            'view' => ViewModification::route('/{record}/view'),
            'relations' => ListModificationRelations::route('/{record}/relations'),
            'media' => ListModificationMedia::route('/{record}/media'),
        ];
    }
}
