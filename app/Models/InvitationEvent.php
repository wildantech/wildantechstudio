<?php

namespace App\Models;

use Database\Factories\InvitationEventFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['invitation_id', 'title', 'starts_at', 'ends_at', 'venue_name', 'address', 'maps_url', 'sort_order'])]
class InvitationEvent extends Model
{
    /** @use HasFactory<InvitationEventFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['starts_at' => 'datetime', 'ends_at' => 'datetime'];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
