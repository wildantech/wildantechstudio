<?php

namespace App\Models;

use Database\Factories\InvitationGuestFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['invitation_id', 'name', 'phone', 'group_name', 'token', 'rsvp_status', 'party_size', 'responded_at', 'marked_sent_at'])]
class InvitationGuest extends Model
{
    /** @use HasFactory<InvitationGuestFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return ['responded_at' => 'datetime', 'marked_sent_at' => 'datetime', 'party_size' => 'integer'];
    }

    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }

    public function wishes(): HasMany
    {
        return $this->hasMany(InvitationWish::class);
    }

    public function whatsappUrl(): string
    {
        $phone = preg_replace('/\\D+/', '', $this->phone) ?? '';
        if (str_starts_with($phone, '0')) {
            $phone = '62'.substr($phone, 1);
        } elseif (! str_starts_with($phone, '62')) {
            $phone = '62'.$phone;
        }

        $message = 'Halo '.$this->name.', kami mengundang Anda. Silakan lihat undangan: '
            .route('invitations.public.show', ['invitation' => $this->invitation->slug, 'token' => $this->token]);

        return 'https://wa.me/'.$phone.'?text='.urlencode($message);
    }
}
