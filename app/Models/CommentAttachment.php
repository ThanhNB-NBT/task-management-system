<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $comment_id
 * @property int|null $user_id
 * @property string $path
 * @property string $original_name
 * @property string|null $mime_type
 * @property int|null $size
 * @property string $created_at
 * @property-read \App\Models\TaskComment $comment
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CommentAttachment whereUserId($value)
 * @mixin \Eloquent
 */
class CommentAttachment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'comment_id',
        'user_id',
        'path',
        'original_name',
        'mime_type',
        'size',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function comment()
    {
        return $this->belongsTo(TaskComment::class, 'comment_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
