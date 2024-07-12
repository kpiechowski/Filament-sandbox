<?php

namespace App;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum UserStatus : string
{
    //
    use IsKanbanStatus;
    case ADMIN = "Admin";
    case USER = "User";
    case WORKER = "Worker";

    public function isAllowed(array $allowedStatuses): bool
    {
        return in_array($this, $allowedStatuses, true);
    }

    public static function toArray(): array
    {
        return array_column(UserStatus::cases(), 'value');
    }  
}
