<?php

namespace App\Models;

use Database\Factories\InvitationWishFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['invitation_id', 'invitation_guest_id', 'message', 'is_approved'])]
class InvitationWish extends Model
{
    /** @use HasFactory<InvitationWishFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['is_approved' => 'boolean'];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function guest(): BelongsTo
    {
        return $this->belongsTo(InvitationGuest::class, 'invitation_guest_id');
    }
}
