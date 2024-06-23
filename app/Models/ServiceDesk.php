<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ServiceDesk extends Model
{
    use HasFactory;
    protected $fillable = ['email', 'name', 'phone', 'question', 'helpful'];

    public function helpfulGivenByUser($userId)
    {
        return $this->helpfulUsers()->where('user_id', $userId)->exists();
    }

    public function helpfulUsers()
    {
        return $this->belongsToMany(User::class, 'helpful_votes')->withTimestamps();
    }

    public function replies()
    {
        return $this->hasMany(ServiceDeskReply::class);
    }
}