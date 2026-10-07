<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicInvitationController extends Controller
{
    public function show(Invitation $invitation, string $token): View
    {
        abort_unless($invitation->is_published && (! $invitation->expires_at || $invitation->expires_at->isFuture()), 404);
        $guest = $this->guestForToken($invitation, $token);
        $invitation->load([
            'events',
            'gifts',
            'wishes' => fn ($query) => $query->where('is_approved', true)->with('guest')->latest(),
        ]);
        $invitation->loadCount([
            'guests as attending_guests_count' => fn ($query) => $query->where('rsvp_status', 'attending'),
            'guests as declined_guests_count' => fn ($query) => $query->where('rsvp_status', 'declined'),
        ]);

        return view('invitations.public', compact('invitation', 'guest'));
    }

    public function rsvp(Request $request, Invitation $invitation, string $token): RedirectResponse
    {
        abort_unless($invitation->is_published && (! $invitation->expires_at || $invitation->expires_at->isFuture()), 404);
        $guest = $this->guestForToken($invitation, $token);
        $data = $request->validate([
            'rsvp_status' => ['required', 'in:attending,declined'],
            'party_size' => ['required_if:rsvp_status,attending', 'nullable', 'integer', 'min:1', 'max:10'],
        ]);

        $guest->update([
            'rsvp_status' => $data['rsvp_status'],
            'party_size' => $data['rsvp_status'] === 'attending' ? (int) $data['party_size'] : null,
            'responded_at' => now(),
        ]);

        return back()->with('rsvp_status', 'Jawaban kehadiran berhasil disimpan. Terima kasih.');
    }

    private function guestForToken(Invitation $invitation, string $token): InvitationGuest
    {
        return $invitation->guests()->where('token', $token)->firstOrFail();
    }
}
