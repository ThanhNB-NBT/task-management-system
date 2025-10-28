<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'leader_id',
    ];

    /**
     * Lấy leader (User) của dự án.
     */
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    /**
     * Lấy tất cả tasks của dự án.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Lấy tất cả thành viên (Users) tham gia dự án.
     */
    public function members()
    {
        // Quan hệ nhiều-nhiều, thông qua bảng 'project_members'
        return $this->belongsToMany(User::class, 'project_members');
    }

    /**
     * Lấy các bản ghi project_member (pivot model)
     */
    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class);
    }
}
