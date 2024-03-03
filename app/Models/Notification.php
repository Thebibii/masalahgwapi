<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        "id_user", "id_post",  "is_seen", 'id_comment'
    ];

    public function posts(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'id_post');
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'id_comment');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
