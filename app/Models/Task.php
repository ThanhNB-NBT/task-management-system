<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',
        'priority',
        'assignee_id',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    /**
     * Lấy dự án mà task này thuộc về.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Lấy người được gán (assignee) task.
     */
    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    /**
     * Lấy tất cả bình luận của task.
     */
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    /**
     * Lấy tất cả lịch sử thay đổi của task.
     */
    public function histories()
    {
        return $this->hasMany(TaskHistory::class);
    }
}
