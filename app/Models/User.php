<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function boards() {
        return $this->hasMany(Board::class)->orderBy('order');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    public function statuses()
    {
        return $this->hasMany(Status::class)->orderBy('order');
    }

    protected static function booted()
    {
        static::created(function ($user) {
            // Create default statuses
            $user->boards()->create([
                'title' => 'Welcome to Kanban',
                'order' => 0,
                'user_id' => $user->id
            ]);
        });
    }
}
