<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'order',
        'board_id',
        'user_id'
    ];

    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order');
    }

    public function board() {
        return $this->belongsTo(Board::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
