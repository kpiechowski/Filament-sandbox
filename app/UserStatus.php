<?php

namespace App;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum UserStatus : string
{
    //
    use IsKanbanStatus;
    case USER = "User";
    case ADMIN = "Admin";
}
