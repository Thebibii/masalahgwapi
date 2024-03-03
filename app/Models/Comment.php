<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'id_post', 'id_user', 'content'
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'id_post');
    }

    public function notification(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}
