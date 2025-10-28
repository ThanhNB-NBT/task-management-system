<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'message',
        'is_read',
    ];

    public $timestamps = false;

    /**
     * LSấy user (người nhận) của thông báo.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
