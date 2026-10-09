<?php

namespace App\Models;

use Database\Factories\WritingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Writing extends Model
{
    /** @use HasFactory<WritingFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'slug', 'type', 'excerpt', 'body', 'cover_path',
        'attachment_path', 'attachment_name', 'status', 'published_at',
    ];

    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
