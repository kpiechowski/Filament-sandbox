<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workshops() {
        return $this->belongsToMany(Workshop::class)->withPivot('quantity_taken')->withTimestamps();
    }

    public static function getForm() {

        return
        [
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('brand')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('model')
                ->required()
                ->maxLength(255),
            Forms\Components\Textarea::make('description')
                ->required()
                ->columnSpanFull(),
        ];
        
    }
}
