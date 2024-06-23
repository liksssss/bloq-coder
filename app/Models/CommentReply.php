<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReply extends Model
{
    use HasFactory;
    protected $fillable = [
        'email', // Tambahkan properti email ke dalam fillable
        'comment_id',
        'reply',
    ];

    // Relasi dengan model Comment
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
