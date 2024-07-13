<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\Worker;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;


    protected function afterCreate(): void
    {
        dd($this->record);
        if ($this->record && $this->record->status === 'Worker') {
            dump('elo');
            Worker::createFromUser($this->record);
        }
    }
}
