<?php

namespace AymanAlhattami\FilamentApproval\Filament\Pages;

use Approval\Models\ModificationMedia;
use Approval\Models\ModificationRelation;
use Filament\Pages\Page;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ListModificationRelationMedia extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-approval::filament.pages.list-modification-relation-media';

    protected static bool $shouldRegisterNavigation = false;

    public ModificationRelation $record;

    public function mount($record): void
    {
        $this->record = $record;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return ModificationMedia::query()
                    ->where('model_type', $this->record::class)
                    ->where('model_id', $this->record->id);
            })
            ->columns([
                TextColumn::make('id'),
                ImageColumn::make('media')
                    ->state(function ($record) {
                        return Media::find($record->media_id)->getFullUrl();
                    }),
                TextColumn::make('action'),
                TextColumn::make('created_at'),
            ])
            ->defaultSort('id', 'desc');
    }
}
