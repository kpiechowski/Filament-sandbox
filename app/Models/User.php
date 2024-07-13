<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\UserStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted() // doesnt work
    {
        static::created(function ($user) {
            if ($user->status === 'Worker') {
                Worker::createFromUser($user);
            }
        });

        static::updated(function ($user) {
            if ($user->status === 'Worker' && !$user->worker) {
                Worker::createFromUser($user);
            }
        });
    }


    public static function getForm(): array {
        return [

            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->unique()
                ->validationMessages([
                    'unique' => 'The :attribute has already been registered.',
                ])
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('password')
                ->password()
                ->required()
                ->revealable()
                ->maxLength(255)
                ->confirmed(),
            Forms\Components\TextInput::make('password_confirmation')
                ->password()
                ->required()
                ->revealable(),
            Forms\Components\Select::make('status')
                ->prefixIcon('heroicon-m-user')
                ->options(UserStatus::toArray())
                ->required()
                ->native(false),
        ];

              // Shout::make('warn-price')
                //     ->visible(function (Forms\Get $get) {
                //         return $get('ticket_cost') > 500;
                //     })
                //     ->columnSpanFull()
                //     ->type('warning')
                //     ->content(function (Forms\Get $get) {
                //         $price = $get('ticket_cost');
                //         return 'This is ' . $price - 500 . ' more than the average ticket price';
                //     }),
    }


    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function assignedTasks()
    {
        return $this->belongsToMany(Task::class, 'task_assignees');
    }

    public function worker()
    {
        return $this->hasOne(Worker::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user');
    }
}
