@extends('layouts.app')

@section('title', $invitation->title.' - Dashboard WildanTech')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head">
            <div><p class="eyebrow">Kelola undangan</p><h1>{{ $invitation->title }}</h1><p>{{ $invitation->host_names }} · {{ $guestCount }} tamu · {{ $respondedCount }} sudah mengisi RSVP</p></div>
            <div class="form-actions" style="display:flex;gap:8px;align-items:center;flex-wrap:wrap;">
                <a class="button-quiet button-small" href="{{ route('studio.invitations.preview', $invitation->theme) }}" target="_blank">Lihat Pratinjau Tema ↗</a>
                <a class="button-quiet button-small" href="{{ route('dashboard.invitations.edit', $invitation) }}">Edit Acara</a>
                <span class="status-pill {{ $invitation->is_published ? '' : 'draft' }}">{{ $invitation->is_published ? 'Terbit' : 'Draf' }}</span>
            </div>
        </div>
        <nav class="dashboard-links" aria-label="Navigasi dashboard"><a class="button-quiet button-small" href="{{ route('dashboard.index') }}">← Kembali ke Dashboard</a>@if ($invitation->is_published)<span class="quiet" style="font-size:11px;margin-left:8px;">Tautan publik dibuat otomatis per tamu personal di bawah.</span>@endif</nav>
        @if ($invitation->is_published && $invitation->expires_at)<p class="retention-note">Undangan ini dijadwalkan dihapus permanen pada <strong>{{ $invitation->expires_at->translatedFormat('d F Y, H:i') }}</strong>, termasuk daftar tamu, RSVP, ucapan, dan foto.</p>@endif

        <div class="stat-row">
            <div class="stat"><small>Total tamu</small><strong>{{ $guestCount }}</strong></div>
            <div class="stat"><small>Hadir</small><strong>{{ $invitation->guests()->where('rsvp_status', 'attending')->count() }}</strong></div>
            <div class="stat"><small>Menunggu RSVP</small><strong>{{ $guestCount - $respondedCount }}</strong></div>
        </div>

        <section class="surface">
            <div class="surface-head"><h2>Tambah tamu</h2><span class="quiet">Nomor WhatsApp Indonesia</span></div>
            <form class="guest-form" method="POST" action="{{ route('dashboard.guests.store', $invitation) }}">
                @csrf
                <div class="field"><label for="guest-name">Nama tamu</label><input id="guest-name" name="name" value="{{ old('name') }}" maxlength="160" required></div>
                <div class="field"><label for="guest-phone">WhatsApp</label><input id="guest-phone" name="phone" inputmode="tel" placeholder="0812... atau +62812..." value="{{ old('phone') }}" required></div>
                <div class="field"><label for="guest-group">Kelompok (opsional)</label><input id="guest-group" name="group_name" value="{{ old('group_name') }}" maxlength="100" placeholder="Keluarga / teman"></div>
                <button class="button" type="submit">Tambah</button>
            </form>
        </section>

        <section class="surface">
            <div class="surface-head"><h2>Daftar tamu</h2><span class="quiet">Bagikan satu per satu</span></div>
            @if ($guests->isEmpty())
                <div class="empty-state">Belum ada tamu. Tambahkan nama dan nomor WhatsApp di atas.</div>
            @else
                <div class="guest-table-wrap">
                    <table class="guest-table">
                        <thead><tr><th>Tamu</th><th>RSVP</th><th>Tautan WhatsApp personal</th><th>Sudah ditandai dikirim?</th><th>Aksi</th></tr></thead>
                        <tbody>
                            @foreach ($guests as $guest)
                                <tr>
                                    <td>
                                        <form class="inline-edit" method="POST" action="{{ route('dashboard.guests.update', [$invitation, $guest->id]) }}">
                                            @csrf @method('PUT')
                                            <input name="name" aria-label="Nama {{ $guest->name }}" value="{{ $guest->name }}" required>
                                            <input name="phone" aria-label="WhatsApp {{ $guest->name }}" value="{{ $guest->phone }}" required>
                                            <input name="group_name" aria-label="Kelompok {{ $guest->name }}" value="{{ $guest->group_name }}" placeholder="Kelompok">
                                            <button class="button-quiet button-small" type="submit">Simpan</button>
                                        </form>
                                    </td>
                                    <td>@if ($guest->rsvp_status === 'attending')Hadir · {{ $guest->party_size }}@elseif ($guest->rsvp_status === 'declined')Tidak hadir@else<span class="quiet">Menunggu</span>@endif</td>
                                    <td>
                                        <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                                            <a class="button-quiet button-small" href="{{ $guest->whatsappUrl() }}" target="_blank" rel="noopener noreferrer">Buka WhatsApp</a>
                                            <button type="button" class="button-quiet button-small" data-copy-link="{{ route('invitations.public.show', [$invitation->slug, $guest->token]) }}" title="Salin tautan personal">Salin Tautan</button>
                                        </div>
                                    </td>
                                    <td>@if ($guest->marked_sent_at){{ $guest->marked_sent_at->format('d M Y H:i') }}@else<span class="quiet">Belum ditandai</span>@endif</td>
                                    <td><div class="guest-actions">
                                        @if (! $guest->marked_sent_at)
                                            <form method="POST" action="{{ route('dashboard.guests.mark-sent', [$invitation, $guest->id]) }}">@csrf<button class="button button-small" type="submit">Tandai terkirim</button></form>
                                        @endif
                                        <form method="POST" action="{{ route('dashboard.guests.destroy', [$invitation, $guest->id]) }}" onsubmit="return confirm('Hapus tamu ini dari daftar?')">@csrf @method('DELETE')<button class="button-danger button-small" type="submit">Hapus</button></form>
                                    </div></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($guests->hasPages())<div class="pagination">{{ $guests->links() }}</div>@endif
            @endif
        </section>

        <section class="surface">
            <div class="surface-head"><h2>Ucapan</h2><span class="quiet">Ucapan baru perlu disetujui sebelum tampil</span></div>
            @forelse ($wishes as $wish)
                <article class="wish-item">
                    <div><strong>{{ $wish->guest->name }}</strong><p>{{ $wish->message }}</p><small class="quiet">{{ $wish->created_at->format('d M Y H:i') }} · {{ $wish->is_approved ? 'Tampil' : 'Menunggu persetujuan' }}</small></div>
                    <div style="display:flex;gap:6px;align-items:center;">
                        @unless ($wish->is_approved)
                            <form method="POST" action="{{ route('dashboard.wishes.approve', [$invitation, $wish->id]) }}">@csrf<button class="button-quiet button-small" type="submit">Setujui</button></form>
                        @endunless
                        <form method="POST" action="{{ route('dashboard.wishes.destroy', [$invitation, $wish->id]) }}" onsubmit="return confirm('Hapus ucapan ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="button-danger button-small" type="submit">Hapus</button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="empty-state">Belum ada ucapan.</div>
            @endforelse
        </section>

        <div class="form-actions"><form method="POST" action="{{ route('dashboard.invitations.destroy', $invitation) }}" onsubmit="return confirm('Hapus undangan beserta daftar tamu dan RSVP-nya?')">@csrf @method('DELETE')<button class="button-danger button-small" type="submit">Hapus undangan</button></form></div>
    </section>
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-copy-link]').forEach(button => {
    button.addEventListener('click', async () => {
        const link = button.dataset.copyLink;
        try {
            await navigator.clipboard.writeText(link);
            const originalText = button.textContent;
            button.textContent = '✓ Tersalin';
            setTimeout(() => { button.textContent = originalText; }, 2000);
        } catch {
            prompt('Salin tautan undangan:', link);
        }
    });
});
</script>
@endpush
