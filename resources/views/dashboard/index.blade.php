@extends('layouts.app')

@section('title', 'Dashboard - WildanTech Studio')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head">
            <div><p class="eyebrow">Workspace</p><h1>Halo, {{ auth()->user()->name }}.</h1><p>Semua undangan dan pembaruan acara ada di sini.</p></div>
            <div class="dashboard-head-actions">
                @if (auth()->user()->is_writer)
                    <a class="button-quiet" href="{{ route('dashboard.writings.index') }}">Masuk ke Studio Tulisan</a>
                @else
                    <a class="button-quiet" href="{{ route('writers.register') }}">Buka Ruang Tulis</a>
                @endif
                <a class="button" href="{{ route('dashboard.invitations.create') }}">Buat undangan</a>
            </div>
        </div>

        @if (auth()->user()->is_admin)
            <nav class="dashboard-links" aria-label="Pengelolaan studio">
                <a class="button-quiet button-small" href="{{ route('dashboard.admin.projects.index') }}">Kelola karya</a>
                <a class="button-quiet button-small" href="{{ route('dashboard.admin.services.index') }}">Kelola layanan</a>
            </nav>
            <div class="stat-row">
                <div class="stat"><small>Undangan pelanggan</small><strong>{{ $invitations->total() }}</strong></div>
                <div class="stat"><small>Proyek studio</small><strong>{{ $projectCount }}</strong></div>
                <div class="stat"><small>Layanan studio</small><strong>{{ $serviceCount }}</strong></div>
            </div>
        @endif

        <div class="surface">
            <div class="surface-head"><h2>Undangan</h2><span class="quiet">{{ $invitations->total() }} total</span></div>
            @forelse ($invitations as $invitation)
                <article class="invitation-row">
                    <div><h3>{{ $invitation->title }}</h3><p>{{ $invitation->host_names }}@if (auth()->user()->is_admin) · {{ $invitation->user->name }}@endif · {{ $invitation->guests_count }} tamu · {{ $invitation->responded_guests_count }} RSVP</p></div>
                    <span class="status-pill {{ $invitation->is_published ? '' : 'draft' }}">{{ $invitation->is_published ? 'Terbit' : 'Draf' }}</span>
                    <a class="button-quiet button-small" href="{{ route('dashboard.invitations.show', $invitation) }}">Kelola</a>
                </article>
            @empty
                <div class="empty-state">Belum ada undangan. Buat satu untuk mulai mengatur acara dan daftar tamu.</div>
            @endforelse
            @if ($invitations->hasPages())<div class="pagination">{{ $invitations->links() }}</div>@endif
        </div>
        <form class="form-actions" method="POST" action="{{ route('dashboard.logout') }}">@csrf<button class="button-quiet button-small" type="submit">Keluar</button></form>
    </section>
@endsection
