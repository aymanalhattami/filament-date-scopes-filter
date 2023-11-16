<?php

namespace AymanAlhattami\FilamentApproval\Filament\Resources;

use Approval\Models\Approval;
use AymanAlhattami\FilamentApproval\Filament\Resources\ApprovalResource\Pages\ManageApprovals;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ApprovalResource extends Resource
{
    protected static ?string $model = Approval::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __(config('filament-approval.approvalNavigationGroup', 'Modifications'));
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-approval.approvalNavigationSort', 2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('modification_id')
                    ->searchable()
                    ->translateLabel()
                    ->sortable(),
                TextColumn::make('approver_type')
                    ->searchable()
                    ->translateLabel(),
                TextColumn::make('approver_id')
                    ->searchable()
                    ->translateLabel(),
                TextColumn::make('reason')
                    ->translateLabel()
                    ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageApprovals::route('/'),
        ];
    }
}
