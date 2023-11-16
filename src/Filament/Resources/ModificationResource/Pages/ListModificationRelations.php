<?php

namespace AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource\Pages;

use Approval\Models\Modification;
use Approval\Models\ModificationRelation;
use AymanAlhattami\FilamentApproval\Filament\Resources\ModificationResource;
use AymanAlhattami\FilamentApproval\Infolists\Components\JsonEntry;
use AymanAlhattami\FilamentPageWithSidebar\Traits\HasPageSidebar;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ListModificationRelations extends Page implements HasTable
{
    use HasPageSidebar,
        InteractsWithTable;

    protected static string $resource = ModificationResource::class;

    protected static string $view = 'filament-approval::filament.resources.modification-resource.pages.list-modification-relations';

    public Modification $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(function () {
                return ModificationRelation::query()->where('modification_id', $this->record->id);
            })
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('model')
                    ->translateLabel()
                    ->searchable(),
                TextColumn::make('action')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('has_media')
                    ->translateLabel()
                    ->state(function ($record) {
                        return $record->modificationMedias()->exists();
                    })
                    ->boolean(),
                TextColumn::make('created_at')
                    ->searchable()
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->actions([
                ViewAction::make()
                    ->infolist([
                        Grid::make(2)->schema([
                            TextEntry::make('id'),
                            TextEntry::make('model')
                                ->translateLabel(),
                            TextEntry::make('action')
                                ->translateLabel(),
                            TextEntry::make('created_at'),
                            JsonEntry::make('modifications')
                                ->translateLabel()
                                ->columnSpanFull(),
                        ]),
                    ]),
                Action::make('media')
                    ->modalContent(function ($record) {
                        return view('filament-approval::modification-relation-media')
                            ->with(['record' => $record]);
                    })
                    ->modalHeading('')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close'),
            ]);
    }
}
