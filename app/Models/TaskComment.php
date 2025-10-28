<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'task_id',
        'user_id',
        'content',
    ];

    /**
     * Lấy task mà bình luận này thuộc về.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Lấy user (tác giả) của bình luận.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
