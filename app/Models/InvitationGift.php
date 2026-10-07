<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['invitation_id', 'provider', 'account_name', 'account_number', 'sort_order'])]
class InvitationGift extends Model
{
    public function invitation(): BelongsTo
    {
        return $this->belongsTo(Invitation::class);
    }
}
