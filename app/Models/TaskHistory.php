<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
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
        'action',
        'old_value',
        'new_value',
    ];

    public $timestamps = false;

    // Dùng json cast để tự động chuyển đổi giữa mảng và chuỗi JSON
    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
    ];

    /**
     * Lấy task mà lịch sử này thuộc về.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Lấy user (người tạo ra thay đổi).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
