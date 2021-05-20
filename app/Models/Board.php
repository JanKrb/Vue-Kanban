<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
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
        static::created(function ($board) {
            // Create default statuses
            $board->statuses()->createMany([
                [
                    'title' => 'Backlog',
                    'order' => 1,
                    'board_id' => $board->id,
                    'user_id' => $board->user->id
                ],
                [
                    'title' => 'Up Next',
                    'order' => 2,
                    'board_id' => $board->id,
                    'user_id' => $board->user->id
                ],
                [
                    'title' => 'In Progress',
                    'order' => 3,
                    'board_id' => $board->id,
                    'user_id' => $board->user->id
                ],
                [
                    'title' => 'Done',
                    'order' => 4,
                    'board_id' => $board->id,
                    'user_id' => $board->user->id
                ]
            ]);
        });
    }
}
