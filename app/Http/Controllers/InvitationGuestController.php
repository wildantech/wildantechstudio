<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvitationGuestRequest;
use App\Http\Requests\UpdateInvitationGuestRequest;
use App\Models\Invitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class InvitationGuestController extends Controller
{
    public function store(StoreInvitationGuestRequest $request, Invitation $invitation): RedirectResponse
    {
        $data = $request->validated();
        $data['phone'] = $this->normalizePhone($data['phone']);
        $data['token'] = Str::random(40);

        $invitation->guests()->create($data);

        return back()->with('status', 'Tamu ditambahkan. Tautan WhatsApp personalnya sudah siap.');
    }

    public function update(UpdateInvitationGuestRequest $request, Invitation $invitation, int $guest): RedirectResponse
    {
        $guestRecord = $invitation->guests()->findOrFail($guest);
        $data = $request->validated();
        $data['phone'] = $this->normalizePhone($data['phone']);
        $guestRecord->update($data);

        return back()->with('status', 'Data tamu diperbarui.');
    }

    public function destroy(Invitation $invitation, int $guest): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $invitation->guests()->findOrFail($guest)->delete();

        return back()->with('status', 'Tamu dihapus.');
    }

    public function markSent(Invitation $invitation, int $guest): RedirectResponse
    {
        $this->authorize('update', $invitation);
        $invitation->guests()->findOrFail($guest)->update(['marked_sent_at' => now()]);

        return back()->with('status', 'Status ditandai sudah dikirim.');
    }

    private function normalizePhone(string $phone): string
    {
        $digits = preg_replace('/\D+/', '', $phone) ?? '';

        if (str_starts_with($digits, '0')) {
            return '62'.substr($digits, 1);
        }

        return str_starts_with($digits, '62') ? $digits : '62'.$digits;
    }
}
