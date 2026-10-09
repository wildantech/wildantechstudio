@extends('layouts.app')

@section('title', 'Dashboard - WildanTech Studio')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head">
            <div><p class="eyebrow">Workspace</p><h1>Halo, {{ auth()->user()->name }}.</h1><p>Semua undangan dan pembaruan acara ada di sini.</p></div>
            <div class="dashboard-head-actions">
                @if (auth()->user()->is_writer)
                    <a class="button-quiet" href="{{ route('dashboard.writings.index') }}">Studio Tulisan ↗</a>
                @else
                    <a class="button-quiet" href="{{ route('writers.register') }}">Buka Ruang Tulis ↗</a>
                @endif
                <a class="button" href="{{ route('dashboard.invitations.create') }}" style="display:inline-flex;align-items:center;gap:6px;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                    <span>Buat Undangan</span>
                </a>
            </div>
        </div>

        @if (auth()->user()->is_admin)
            <nav class="dashboard-links" aria-label="Pengelolaan studio">
                <a class="button-quiet button-small" href="{{ route('dashboard.admin.projects.index') }}">Kelola Karya Studio</a>
                <a class="button-quiet button-small" href="{{ route('dashboard.admin.services.index') }}">Kelola Layanan Studio</a>
            </nav>
            <div class="stat-row">
                <div class="stat"><small>Undangan Pelanggan</small><strong>{{ $invitations->total() }}</strong></div>
                <div class="stat"><small>Proyek Studio</small><strong>{{ $projectCount }}</strong></div>
                <div class="stat"><small>Layanan Studio</small><strong>{{ $serviceCount }}</strong></div>
            </div>
        @endif

        <div class="surface">
            <div class="surface-head">
                <h2>Daftar Undangan</h2>
                <span class="quiet">{{ $invitations->total() }} total</span>
            </div>
            @forelse ($invitations as $invitation)
                <article class="invitation-row">
                    <div>
                        <h3>{{ $invitation->title }}</h3>
                        <p>{{ $invitation->host_names }}@if (auth()->user()->is_admin) · {{ $invitation->user->name }}@endif · {{ $invitation->guests_count }} tamu · {{ $invitation->responded_guests_count }} RSVP</p>
                    </div>
                    <span class="status-pill {{ $invitation->is_published ? '' : 'draft' }}">{{ $invitation->is_published ? 'Terbit' : 'Draf' }}</span>
                    <a class="button-quiet button-small" href="{{ route('dashboard.invitations.show', $invitation) }}">Kelola Acara</a>
                </article>
            @empty
                <div style="text-align: center; padding: 48px 20px; display: grid; justify-items: center; gap: 12px;">
                    <div style="width: 48px; height: 48px; border-radius: 50%; background: rgba(197, 243, 107, 0.1); border: 1px solid rgba(197, 243, 107, 0.25); color: var(--accent); display: grid; place-items: center; font-size: 20px;">✉</div>
                    <h3 style="margin: 0; font-size: 18px; color: #ffffff;">Belum ada undangan digital</h3>
                    <p style="margin: 0; color: #94a597; font-size: 13px; max-width: 420px; line-height: 1.6;">Pilih salah satu dari 5 tema eksklusif kami dan atur detail acara pernikahan serta daftar tamu secara praktis.</p>
                    <a class="button" href="{{ route('studio.invitations') }}" style="margin-top: 8px;">Pilih Tema & Buat Undangan ↗</a>
                </div>
            @endforelse
            @if ($invitations->hasPages())<div class="pagination">{{ $invitations->links() }}</div>@endif
        </div>
        <form class="form-actions" method="POST" action="{{ route('dashboard.logout') }}">@csrf<button class="button-quiet button-small" type="submit">Keluar</button></form>
    </section>
@endsection
