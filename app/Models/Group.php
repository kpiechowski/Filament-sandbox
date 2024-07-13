<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Forms;

class Group extends Model
{
    use HasFactory;

    use IsKanbanStatus;
    
    protected $guarded = [];

    public static function getGroupStatuses() {
        return collect(Group::all())->map(function ($group) {
            return [
                'id' => $group->id,
                'title' => $group->title,
            ];
        });
    }

    public static function getForm(): array {
        return [
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function createEnum() {

    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user');
    }
}
