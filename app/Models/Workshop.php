<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
    use HasFactory;

    public function equipments() {
        return $this->belongsToMany(Equipment::class)->withPivot(['quantity_taken'])->withTimestamps();
    }
}
