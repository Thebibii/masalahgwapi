<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'posts';
    protected $fillable = [
        'content', 'id_user', 'anonymous'
    ];

    public function isAnonymous()
    {
        if ($this->anonymous) {
            return true;
        }
        return false;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class, 'id_post');
    }

    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
