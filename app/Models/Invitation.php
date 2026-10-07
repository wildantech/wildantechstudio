<?php

namespace App\Models;

use Database\Factories\InvitationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'title', 'slug', 'host_names', 'bride_name', 'bride_nickname', 'bride_father', 'bride_mother', 'bride_child_order', 'bride_instagram', 'groom_name', 'groom_nickname', 'groom_father', 'groom_mother', 'groom_child_order', 'groom_instagram', 'theme', 'cover_image', 'bride_photo', 'groom_photo', 'gallery_images', 'music_file', 'opening_text', 'closing_text', 'love_story', 'livestream_url', 'gift_delivery_address', 'gift_bank_name', 'gift_account_name', 'gift_account_number', 'is_published', 'published_at', 'expires_at'])]
class Invitation extends Model
{
    /** @use HasFactory<InvitationFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
            'expires_at' => 'datetime',
            'gallery_images' => 'array',
            'love_story' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(InvitationEvent::class)->orderBy('sort_order');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(InvitationGuest::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(InvitationWish::class);
    }

    public function gifts(): HasMany
    {
        return $this->hasMany(InvitationGift::class)->orderBy('sort_order');
    }

    /** @return list<string> */
    public function mediaPaths(): array
    {
        return array_values(array_filter([
            $this->cover_image,
            $this->bride_photo,
            $this->groom_photo,
            $this->music_file,
            ...($this->gallery_images ?? []),
        ]));
    }
}
