<?php

namespace App\Models;

use Filament\Forms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Worker extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function getForm() {
        return [
            Forms\Components\FileUpload::make('profile_picture')
                ->label('Profile Photo')
                ->image()
                ->avatar()
                ->directory('profile-photos')
                ->maxSize(1024)
                ->getUploadedFileUsing(function ($record) {
                    // Check if the path is an external URL
                    if (filter_var($record->profile_picture, FILTER_VALIDATE_URL)) {
                        return $record->profile_picture;
                    }
                    // Otherwise, return the local storage path
                    return Storage::url($record->profile_picture);
                }),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('surname')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('phone')
                ->tel()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('user_id')
                ->required()
                ->numeric()
                ->hidden(),
        ];
    }

    public static function createFromUser(User $user){
        return Worker::create([
            'name' => $user->name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'user_id' => $user->id,
        ]);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
