<?php

namespace App\Filament\Pages;

use App\TaskStatus;
use App\UserStatus;
use App\Models\User;
use App\Models\Group;
use Filament\Actions\CreateAction;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class GroupsBoard extends KanbanBoard
{
    protected static string $model = User::class;
    // protected static string $statusEnum = UserStatus::class;
    protected static string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Users';

    protected static ?string $slug = 'users-groups-board';

    protected static ?string $navigationIcon = null;

    protected static ?string $title = 'Groups board';

    protected ?string $heading = 'Subscription groups Board';

    protected ?string $subheading = 'Custom Page Subheading';

    public bool $disableEditModal = false;
    protected bool $editModalSlideOver = true;


    public static function canAccess(): bool
    {
        return auth()->user()->status == UserStatus::ADMIN->value;
    }

    public function getHeaderActions(): array
    {
        return [
            CreateAction::make('Create Group')
            ->model(Group::class)
            ->label('Create new group')
            ->form(Group::getForm())
            ->successNotification(
                Notification::make()
                     ->success()
                     ->title('New group added')
                     ->body('Refresh page to attach user to new group.')
                     ,
             ),
        ];
    }

    
    protected function statuses(): Collection
    {
        return Group::getGroupStatuses();
    }

    protected function getViewData(): array
    {
        $statuses = $this->statuses()
            ->map(function ($status) {

                $group = Group::find($status['id']);
                $status['records'] = $group ? $group->users()->get()->all() : [];

                return $status;
            });

        return [
            'statuses' => $statuses,
        ];
    }


    public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
    {

        $group = Group::find($status);
        $user = User::find($recordId);

        if(!$group || !$user) {
            Notification::make()
                ->title('An Error has occur, try again')
                ->danger()
                ->send();
            return;
        }

        if($group->users()->where('user_id', $user->id)->exists()){

            Notification::make()
                ->title('User is already in that group')
                ->warning()
                ->send();
            return;
        }

        $group->users()->attach($user->id);

        Notification::make()
        ->title('Group successfully changed')
        ->success()
        ->send();

    }
    
}
