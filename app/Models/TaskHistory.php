<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $task_id
 * @property int $user_id
 * @property string $action
 * @property array<array-key, mixed>|null $old_value
 * @property array<array-key, mixed>|null $new_value
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\Task $task
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\TaskHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereNewValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereOldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskHistory whereUserId($value)
 * @mixin \Eloquent
 */
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

    protected $casts = [
        'old_value' => 'array',
        'new_value' => 'array',
        'created_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
