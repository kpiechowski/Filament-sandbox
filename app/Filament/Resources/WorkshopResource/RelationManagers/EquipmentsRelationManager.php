<?php

namespace App\Filament\Resources\WorkshopResource\RelationManagers;

use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'equipments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quantity')
                    ->integer()->required()
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('brand'),
                Tables\Columns\TextColumn::make('model'),
                Tables\Columns\TextColumn::make('quantity_taken'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make()->slideOver(),

                Tables\Actions\AttachAction::make()
                    ->form(fn(Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect()
                            ->afterStateUpdated(function ($state, $set) {
                                $equipment = Equipment::find($state);
                                if (!$equipment) {
                                    $set('equipment_selected', false);
                                    return;
                                }

                                $set('equipment_selected', true);
                                $remainingQuantity = $equipment->quantity - $equipment->workshops()->sum('quantity_taken');
                                $set('quantity_taken_max', $remainingQuantity);
                            })
                            ->live()
                            ->label('Select equipment to attach'),



                        Forms\Components\TextInput::make('quantity_taken')
                            ->integer()
                            ->live()
                            ->visible(function ($get) {
                                return $get('equipment_selected'); 
                            })
                            ->minValue(1)
                            ->maxValue(fn ($get) => $get('quantity_taken_max') )
                            ->suffix(fn ($get) => "/" . $get('quantity_taken_max') . " dostępnych" )
                            ->required(),
                    ])
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\DetachAction::make(),
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
