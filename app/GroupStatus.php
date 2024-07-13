<?php

namespace App;

use App\Models\Group;
use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum GroupStatus : string
{
    //

    use IsKanbanStatus;

    // Group::createEnum();


    // public static function toArray(): array
    // {
    //     return array_column(TaskStatus::cases(), 'value');
    // }  
}
