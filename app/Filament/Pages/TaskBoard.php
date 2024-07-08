<?php

namespace App\Filament\Pages;

use App\TaskStatus;
use App\UserStatus;
use App\Models\Task;
use App\Models\User;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class TaskBoard extends KanbanBoard
{
    protected static string $model = Task::class;
    protected static string $statusEnum = TaskStatus::class;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $recordTitleAttribute = 'title';

    public bool $disableEditModal = false;
    protected bool $editModalSlideOver = true;


    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {
        User::find($recordId)->update(['status' => $status]);
        User::setNewOrder($toOrderedIds);
    }

}
