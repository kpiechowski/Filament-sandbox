<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
        'email',
        'password',
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
