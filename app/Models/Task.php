<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assignees() {
        return $this->belongsToMany(User::class, 'task_assignees');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
