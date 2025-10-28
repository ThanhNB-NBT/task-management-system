<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function scopeLeaders($query)
    {
        return $query->where('role', 'leader');
    }
    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    // ===============================================
    // THÊM CÁC HÀM QUAN HỆ VÀO ĐÂY
    // ===============================================

    /**
     * Các dự án mà User này làm leader.
     */
    public function ledProjects()
    {
        return $this->hasMany(Project::class, 'leader_id');
    }

    /**
     * Các dự án mà User này tham gia (với tư cách member).
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_members');
    }

    /**
     * Các task được gán cho User này.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    /**
     * Các bình luận mà User này đã viết.
     */
    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    /**
     * Các thông báo của User này.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
