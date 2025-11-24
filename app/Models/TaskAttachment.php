<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $task_id
 * @property int|null $user_id
 * @property string $path
 * @property string $original_name
 * @property string|null $mime_type
 * @property int|null $size
 * @property string $created_at
 * @property-read \App\Models\Task $task
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereTaskId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TaskAttachment whereUserId($value)
 * @mixin \Eloquent
 */
class TaskAttachment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'task_id',
        'user_id',
        'path',
        'original_name',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
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
