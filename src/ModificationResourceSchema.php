<?php

namespace AymanAlhattami\FilamentApproval;

use Approval\Enums\ActionEnum;
use Approval\Enums\ModificationStatusEnum;
use Approval\Models\Modification;
use AymanAlhattami\FilamentApproval\Infolists\Components\JsonEntry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Components\Tab;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ModificationResourceSchema
{
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->translateLabel()
                ->sortable()
                ->searchable(),
            TextColumn::make('modifiable_type')
                ->label('Modifiable')
                ->description(fn (Modification $record) => $record->modifiable_id)
                ->translateLabel()
                ->sortable()
                ->searchable(),
            TextColumn::make('modifier_type')
                ->label('Modifier')
                ->description(fn (Modification $record) => $record->modifier_id)
                ->translateLabel()
                ->sortable()
                ->searchable(),
            TextColumn::make('action')
                ->badge()
                ->color(function ($state){
                    return match ($state) {
                        ActionEnum::Create => 'gray',
                        ActionEnum::Update => 'success',
                        ActionEnum::Delete => 'warning',
                    };
                })
                ->translateLabel()
                ->sortable()
                ->searchable(),
            TextColumn::make('status')
                ->badge()
                ->badge()
                ->color(function ($state){
                    return match ($state) {
                        ModificationStatusEnum::Pending => 'gray',
                        ModificationStatusEnum::Approved => 'success',
                        ModificationStatusEnum::Disapproved => 'warning',
                    };
                })
                ->translateLabel()
                ->sortable()
                ->searchable(),
            IconColumn::make('has_relation')
                ->translateLabel()
                ->state(function ($record) {
                    return $record->modificationRelations()->exists();
                })
                ->boolean(),
            IconColumn::make('has_media')
                ->translateLabel()
                ->state(function ($record) {
                    return $record->modificationMedias()->exists();
                })
                ->boolean(),
            TextColumn::make('created_at')
                ->searchable(),
        ];
    }

    public static function getInfolist(): array
    {
        return [
                Section::make()
                    ->schema([
                        Fieldset::make('Modifier')
                            ->schema([
                                TextEntry::make('modifier_type')
                                    ->label('Type')
                                    ->translateLabel(),
                                TextEntry::make('modifier_id')
                                    ->label('Id')
                                    ->translateLabel(),
                            ]),
                        Fieldset::make('Modifiable')->schema([
                            TextEntry::make('modifiable_type')
                                ->label('Type')
                                ->translateLabel(),
                            TextEntry::make('modifiable_id')
                                ->label('Id')
                                ->translateLabel(),
                        ]),
                        TextEntry::make('action')->translateLabel(),
                        TextEntry::make('status')->translateLabel(),
                        TextEntry::make('approvers_required')->translateLabel(),
                        TextEntry::make('disapprovers_required')->translateLabel(),
                        TextEntry::make('created_at')->translateLabel(),
                        JsonEntry::make('modifications')
                            ->translateLabel()
                            ->columnSpanFull(),
                    ])->columns(2),
            ];
    }

    public static function getTableActions(): array
    {
        return [
            ActionGroup::make([
                ViewAction::make('view')
                    ->translateLabel(),
                Action::make('approve')
                    ->translateLabel()
                    ->form([
                        Textarea::make('reason')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->action(function ($record, $data) {
                        Auth::user()->approve($record, $data['reason']);
                    })
                    ->icon('heroicon-m-check')
                    ->requiresConfirmation()
                    ->visible(function ($record) {
                        return $record->status == ModificationStatusEnum::Pending;
                    }),
                Action::make('disapprove')
                    ->translateLabel()
                    ->form([
                        Textarea::make('reason')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->action(function ($record, $data) {
                        Auth::user()->disapprove($record, $data['reason']);
                    })
                    ->icon('heroicon-m-x-mark')
                    ->requiresConfirmation()
                    ->visible(function ($record) {
                        return $record->status == ModificationStatusEnum::Pending;
                    }),
            ]),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
        ];
    }

    /**
     * @throws \Exception
     */
    public static function getTableFilter(): array
    {
        return [
            SelectFilter::make('modifiable_type')
                ->options(function () {
                    return Modification::query()
                        ->distinct()->pluck('modifiable_type', 'modifiable_type');
                })
                ->searchable()
                ->multiple(),
            SelectFilter::make('modifier_type')
                ->options(function () {
                    return Modification::query()
                        ->distinct()->pluck('modifier_type', 'modifier_type');
                })
                ->searchable()
                ->multiple(),
            SelectFilter::make('action')
                ->options(ActionEnum::toArray())
                ->searchable()
                ->multiple(),
            SelectFilter::make('status')
                ->options(ModificationStatusEnum::toArray())
                ->searchable()
                ->multiple(),
            Filter::make('created_at')
                ->columnSpanFull()
                ->form([
                    Grid::make(2)->schema([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until')->default(now()),
                    ])
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                }),
        ];
    }

    public static function getTableDefaultSortColumn(): string
    {
        return 'id';
    }

    public static function getTableDefaultSortDirection(): string
    {
        return 'desc';
    }

    public static function getFiltersFormWidth(): string
    {
        return '2xl';
    }

    public static function getFilterFormColumns(): string
    {
        return 2;
    }

    public static function getTabs(): array
    {
        return [
            'all' => Tab::make('All')
                ->modifyQueryUsing(function ($query) {
                    return $query;
                }),
            'pending' => Tab::make('Pending')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', ModificationStatusEnum::Pending);
                }),
            'approved' => Tab::make('Approved')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', ModificationStatusEnum::Approved);
                })
                ->icon('heroicon-o-check'),
            'disapproved' => Tab::make('Disapproved')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', ModificationStatusEnum::Disapproved);
                })
                ->icon('heroicon-o-x-mark'),
            'create' => Tab::make('Creations')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('action', ActionEnum::Create);
                })
                ->icon('heroicon-o-plus'),
            'update' => Tab::make('Update')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('action', ActionEnum::Update);
                })
                ->icon('heroicon-o-pencil'),
            'deletion' => Tab::make('Deletion')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('action', ActionEnum::Delete);
                })
                ->icon('heroicon-o-trash'),
        ];
    }
}
