<?php

namespace App;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum TaskStatus : string
{
    //

    use IsKanbanStatus;

    case TO_DO = 'To Do';
    case IN_PROGRESS = 'In Progress';
    case REVIEW = 'Review';
    case DONE = 'Done';
    case CANCELED = 'Canceled';


    public static function toArray(): array
    {
        return array_column(TaskStatus::cases(), 'value');
    }  
}
