<?php

namespace App\Filament\Resources\EquipmentResource\Pages;

use Filament\Actions;
use App\Models\Equipment;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EquipmentResource;

class ListEquipment extends ListRecords
{
    protected static string $resource = EquipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'full' => Tab::make("Rented")
                ->modifyQueryUsing(function (Builder $query) {

                    // $query->whereRaw('quantity - (SELECT SUM(quantity_taken) FROM equipment_workshop  WHERE equipment_workshop.equipment_id = equipment.id) = 0');
                    $query->whereRaw('quantity - (SELECT SUM(quantity_taken) FROM equipment_workshop WHERE equipment_workshop.equipment_id = equipment.id) = 0');
                }),
            'empty' => Tab::make("Empty")
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereRaw('equipment.quantity - (SELECT SUM(quantity_taken) FROM equipment_workshop WHERE equipment_workshop.equipment_id = equipment.id) = 0');
                }),
        ];
    }
}
