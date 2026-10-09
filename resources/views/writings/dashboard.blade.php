@extends('layouts.app')

@section('writing_mode', true)
@section('title', 'Studio Tulisan - WildanTech')

@section('content')
    <section class="container writing-dashboard">
        <div class="writing-dashboard-top"><a class="reading-back" href="{{ route('readings.index') }}">← Lihat Ruang Baca</a><span class="writing-dashboard-label"><span></span> Studio Penulis</span></div>
        <header class="writing-dashboard-head">
            <div class="reading-author writing-dashboard-author"><span class="author-monogram">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(auth()->user()->name, 0, 1)) }}</span><div><p class="eyebrow">Ruang pribadimu</p><h1>{{ auth()->user()->name }}</h1><p>{{ auth()->user()->bio }}</p></div></div>
            <a class="button" href="{{ route('dashboard.writings.create') }}"><span aria-hidden="true">＋</span> Tulis karya baru</a>
        </header>
        <div class="writing-dashboard-stats">
            <div><small>Semua karya</small><strong>{{ $writings->total() }}</strong></div>
            <div><small>Telah terbit</small><strong>{{ $publishedCount }}</strong></div>
            <div><small>Masih draf</small><strong>{{ $draftCount }}</strong></div>
        </div>
        <section class="writing-manuscripts">
            <div class="writing-section-head"><div><p class="eyebrow">Meja tulis</p><h2>Karya-karyamu.</h2></div><a class="writing-read-link" href="{{ route('dashboard.writings.create') }}">Mulai yang baru ↗</a></div>
            @forelse ($writings as $writing)
                <article class="manuscript-row">
                    <div class="manuscript-mark {{ $writing->type === 'poem' ? 'is-poem' : '' }}">{{ $writing->type === 'poem' ? '“' : 'W' }}</div>
                    <div class="manuscript-copy"><span>{{ $types[$writing->type] ?? 'Tulisan' }} <i>·</i> Diperbarui {{ $writing->updated_at->diffForHumans() }}</span><h3>{{ $writing->title }}</h3><p>{{ $writing->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($writing->body), 120) }}</p></div>
                    <span class="status-pill {{ $writing->status === 'draft' ? 'draft' : '' }}">{{ $writing->status === 'draft' ? 'Draf' : 'Terbit' }}</span>
                    <div class="manuscript-actions"><a class="button-quiet button-small" href="{{ route('dashboard.writings.edit', $writing) }}">Edit</a>@if ($writing->status === 'published')<a class="button-quiet button-small" href="{{ route('readings.show', $writing) }}" target="_blank" rel="noopener noreferrer">Lihat</a>@endif</div>
                </article>
            @empty
                <div class="writing-empty writing-empty-dashboard"><span class="writing-empty-mark">✳</span><h3>Halaman pertamamu masih kosong.</h3><p>Mulai dari ide kecil. Kamu bisa menyimpan draf atau menerbitkannya kapan saja.</p><a class="button" href="{{ route('dashboard.writings.create') }}">Tulis karya pertama</a></div>
            @endforelse
            @if ($writings->hasPages())<div class="pagination writing-pagination">{{ $writings->links() }}</div>@endif
        </section>
        <form class="writer-logout" method="POST" action="{{ route('dashboard.logout') }}">@csrf<button type="submit">Keluar dari akun</button></form>
    </section>
@endsection
