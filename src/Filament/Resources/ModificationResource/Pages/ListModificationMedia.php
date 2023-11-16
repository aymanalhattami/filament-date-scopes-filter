<?php

namespace AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages;

use Approval\Models\Modification;
use Approval\Models\ModificationMedia;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ListModificationMedia extends Page implements HasTable
{
    use HasPageSidebar, InteractsWithTable;

    protected static string $resource = ModificationResource::class;

    protected static string $view = 'filament-approval::filament.resources.modification-resource.pages.list-modification-media';

    public Modification $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return ModificationMedia::query()
                    ->where('model_type', $this->record::class)
                    ->where('model_id', $this->record->id);
            })
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('media')
                    ->state(function ($record) {
                        return Media::find($record->media_id)->getFullUrl();
                    }),
                TextColumn::make('action')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc');
    }
}
