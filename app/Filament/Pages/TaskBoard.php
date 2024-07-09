<?php

namespace App\Filament\Pages;

use App\TaskStatus;
use App\UserStatus;
use App\Models\Task;
use App\Models\User;
use App\Models\Worker;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

use Filament\Forms;

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
        // User::find($recordId)->update(['status' => $status]);
        // User::setNewOrder($toOrderedIds);
    }

    protected function getEditModalFormSchema(null|int $recordId): array
    {

        $task = null;
        

        // dd($task);
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\RichEditor::make('description')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('status')
                ->options(TaskStatus::toArray())
                ->label('Task Status')
                ->selectablePlaceholder(false)
                ->required(),


            Forms\Components\Fieldset::make('Created by')
                ->schema([

                    //         Forms\Components\Placeholder::make('created')
                    // 
                    // ->label('Created by')

                    Forms\Components\Placeholder::make('creator_name')
                    ->label('')
                    ->content(function () use ($recordId) {
                            if($recordId){
                                
                                 return Task::with('creator')->find($recordId)->creator->name ?? '';
                            }

                        })
                    ]),

                

                Forms\Components\Select::make('assignees')
                    ->multiple()
                    ->relationship(titleAttribute: 'name')
                    ->options(function () {
                        return User::whereHas('worker')->pluck('name', 'id');
                    })
                    ->label('Asigners')
                    ->preload()
                    ->selectablePlaceholder(false)
                    ->required(),

                // Forms\Components\Repeater::make('assignees')
                //     ->relationship('assignees')
                //     ->schema([
                //         Forms\Components\Select::make('user_id')
                //         ->label('Assignee')
                //         ->options(Worker::all()->pluck('surname'))
                //         ->searchable()
                //         ->required()
                //     ])
                //     ->reorderable(false),
                

            ];;
    }
}
