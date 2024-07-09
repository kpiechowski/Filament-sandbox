<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Equipment;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EquipmentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EquipmentResource\RelationManagers;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    // protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationGroup = 'Shops';


    public static function form(Form $form): Form
    {
        return $form
            ->schema(Equipment::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity_overview')
                    ->badge()
                    ->label('Quantity')
                    ->getStateUsing(function($record) {
                        $quantityLeft = $record->quantity - $record->workshops()->sum('quantity_taken');
                        $quantityAll = $record->quantity;
                        return "$quantityLeft / $quantityAll";
                    })
                    ->colors([
                        'danger' => fn ($state) => explode(' / ', $state)[0] == 0,
                        'warning' => fn ($state) => explode(' / ', $state)[0] < (explode(' / ', $state)[1] / 2),
                        'success' => fn ($state) => explode(' / ', $state)[0] >= (explode(' / ', $state)[1] / 2),
                    ]),

                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                
                // Tables\Filters\TernaryFilter::make('ocuppied')
                // ->attribute('workshop_id')
                // ->nullable(),
                // Tables\Filters\SelectFilter::make('workshop')
                //     ->relationship('workshop', 'name')
                //     ->multiple()
                //     ->searchable()
                //     ->preload(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Info')
                    ->description('Basic info')
                    ->schema([
                        Infolists\Components\TextEntry::make('name'),
                        Infolists\Components\TextEntry::make('brand'),
                        Infolists\Components\TextEntry::make('model'),
                        Infolists\Components\TextEntry::make('description')
                            ->columnSpanFull()
                    ])->columns(3),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'view' => Pages\ViewRquipment::route('/{record}'),
            // 'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }
}
