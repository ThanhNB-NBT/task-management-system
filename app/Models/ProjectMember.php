<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property string $role_in_project
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\ProjectMemberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereRoleInProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectMember whereUserId($value)
 * @mixin \Eloquent
 */
class ProjectMember extends Model
{
    use HasFactory;

    /**
     * Tên bảng mà model này quản lý.
     *
     * @var string
     */
    protected $table = 'project_members';

    /**
     * Bảng này không dùng timestamps (created_at, updated_at).
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'role_in_project',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
