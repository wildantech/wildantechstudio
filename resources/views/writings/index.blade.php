@extends('layouts.app')

@section('writing_mode', true)
@section('title', 'Ruang Baca - WildanTech Studio')
@section('description', 'Ruang untuk artikel, buku, dan puisi pilihan dari para penulis.')

@section('content')
    <section class="writing-hero">
        <div class="container writing-hero-inner">
            <div class="writing-hero-content">
                <p class="eyebrow">WildanTech · Ruang Baca</p>
                <h1>Ruang<br><em>Baca.</em></h1>
                <p class="writing-hero-copy">Temukan artikel, buku, dan puisi dari para penulis. Pilih bacaan, lalu nikmati ceritanya.</p>
                <div class="writing-hero-actions">
                    <a class="button" href="#koleksi">Jelajahi tulisan <span aria-hidden="true">↓</span></a>
                    <a class="button-quiet" href="{{ route('writers.register') }}">Ruang untuk penulis <span aria-hidden="true">↗</span></a>
                </div>
            </div>
            <div class="writing-hero-stat" aria-label="{{ number_format($publishedCount) }} karya telah dibagikan">
                <strong>{{ number_format($publishedCount) }}</strong>
                <span>Karya<br>dibagikan</span>
            </div>
        </div>
    </section>

    <section class="container writing-library" id="koleksi">
        <div class="writing-section-head">
            <div><p class="eyebrow">Koleksi terbaru</p><h2>Temukan bacaanmu.</h2></div>
            <p>Artikel untuk dipikirkan, buku untuk ditinggali, puisi untuk dirasakan.</p>
        </div>

        <nav class="writing-filters" aria-label="Filter jenis karya">
            <a class="{{ $selectedType === 'all' ? 'is-active' : '' }}" href="{{ route('readings.index') }}">Semua</a>
            @foreach ($types as $key => $label)
                <a class="{{ $selectedType === $key ? 'is-active' : '' }}" href="{{ route('readings.index', ['jenis' => $key]) }}">{{ $label }}</a>
            @endforeach
        </nav>

        @if ($writings->isNotEmpty())
            <div class="writing-grid">
                @foreach ($writings as $writing)
                    <article class="writing-card">
                        <a class="writing-card-cover {{ $writing->type === 'poem' ? 'is-poem' : '' }}" href="{{ route('readings.show', $writing) }}" aria-label="Baca {{ $writing->title }}">
                            @if ($writing->cover_path)
                                <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($writing->cover_path) }}" alt="Sampul {{ $writing->title }}" loading="lazy">
                            @else
                                <span class="writing-cover-letter" aria-hidden="true">{{ $writing->type === 'poem' ? '“' : 'W' }}</span>
                                <span class="writing-cover-caption">{{ $types[$writing->type] ?? 'Tulisan' }}</span>
                            @endif
                            <span class="writing-type">{{ $types[$writing->type] ?? 'Tulisan' }}</span>
                        </a>
                        <div class="writing-card-copy">
                            <p class="writing-byline">{{ $writing->author->name }} <span>·</span> {{ optional($writing->published_at)->translatedFormat('d M Y') ?? 'Terbit' }}</p>
                            <h3><a href="{{ route('readings.show', $writing) }}">{{ $writing->title }}</a></h3>
                            <p class="writing-excerpt">{{ $writing->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($writing->body), 150) }}</p>
                            <a class="writing-read-link" href="{{ route('readings.show', $writing) }}">Baca karya <span aria-hidden="true">↗</span></a>
                        </div>
                    </article>
                @endforeach
            </div>
            @if ($writings->hasPages())<div class="pagination writing-pagination">{{ $writings->links() }}</div>@endif
        @else
            <div class="writing-empty">
                <span class="writing-empty-mark" aria-hidden="true">✳</span>
                <p class="eyebrow">Ruang masih lapang</p>
                <h3>Tulisan pertama sedang menunggu.</h3>
                <p>Segera kembali untuk menemukan artikel, buku, dan puisi dari ruang ini.</p>
                <a class="button" href="{{ route('writers.register') }}">Mulai sebagai penulis</a>
            </div>
        @endif
    </section>

    <section class="writing-author-invite">
        <div class="container writing-author-invite-inner">
            <div><p class="eyebrow">Untuk para perangkai kata</p><h2>Punya sesuatu<br>yang ingin dibagikan?</h2></div>
            <a class="button writing-button-light" href="{{ route('writers.register') }}">Buka ruang tulismu <span aria-hidden="true">↗</span></a>
        </div>
    </section>
@endsection
