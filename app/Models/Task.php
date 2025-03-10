<?php

namespace App\Models;

use App\TaskStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getForm() {
        return;
    }

    public function assignees() {
        return $this->belongsToMany(User::class, 'task_assignees');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
