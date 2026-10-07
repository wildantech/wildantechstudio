<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationWishController extends Controller
{
    public function store(Request $request, Invitation $invitation, string $token): RedirectResponse
    {
        abort_unless($invitation->is_published && (! $invitation->expires_at || $invitation->expires_at->isFuture()), 404);
        $guest = $invitation->guests()->where('token', $token)->firstOrFail();
        $data = $request->validate(['message' => ['required', 'string', 'min:2', 'max:600']]);

        $invitation->wishes()->create([
            'invitation_guest_id' => $guest->id,
            'message' => $data['message'],
            'is_approved' => false,
        ]);

        return back()->with('wish_status', 'Ucapan tersimpan dan akan tampil setelah disetujui.');
    }

    public function approve(Invitation $invitation, int $wish): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $invitation->wishes()->findOrFail($wish)->update(['is_approved' => true]);

        return back()->with('status', 'Ucapan ditampilkan pada halaman undangan.');
    }
}
