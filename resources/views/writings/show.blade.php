@extends('layouts.app')

@section('writing_mode', true)
@section('title', $writing->title.' - Ruang Baca')

@section('content')
    <article class="container reading-article">
        @if (in_array($writing->type, ['article', 'poem'], true) && filled($writing->body))
            <section class="poem-volume" data-poem-volume aria-label="Buku {{ strtolower($types[$writing->type] ?? 'tulisan') }} {{ $writing->title }}">
                <div class="poem-volume-stack" data-poem-stack>
                    <article class="book-page poem-book-page" data-poem-page aria-live="polite">
                        <span class="book-running-head">{{ $writing->title }}</span>
                        <div class="book-page-content book-poem-content" data-poem-page-content>
                            <p class="book-loading">Menyiapkan halaman puisi…</p>
                        </div>
                        <span class="book-page-number" data-poem-page-number></span>
                    </article>
                    <button class="poem-volume-cover" data-poem-cover type="button" aria-label="Geser atau ketuk untuk membuka puisi">
                        @if ($writing->cover_path)
                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($writing->cover_path) }}" alt="">
                        @else
                            <span class="poem-volume-cover-mark" aria-hidden="true">“</span>
                        @endif
                        <span class="poem-volume-cover-shade" aria-hidden="true"></span>
                        <span class="poem-volume-cover-copy">
                            <span class="writing-type reading-article-type">{{ $types[$writing->type] ?? 'Puisi' }}</span>
                            <strong>{{ $writing->title }}</strong>
                            <span>{{ $writing->author->name }}</span>
                            @if ($writing->excerpt)<span class="poem-volume-cover-excerpt">{{ $writing->excerpt }}</span>@endif
                            <small>Geser atau ketuk untuk membaca</small>
                        </span>
                    </button>
                </div>
                <div class="poem-volume-controls" aria-live="polite">
                    <span data-poem-page-label>Geser sampul ke kiri untuk membuka</span>
                    <span class="book-swipe-hint" data-poem-swipe-hint>Geser sampul ke kiri untuk membaca</span>
                </div>
                <div class="poem-volume-source" data-poem-source hidden>{!! $writing->body !!}</div>
            </section>
        @elseif (! ($writing->type === 'book' && $writing->attachment_path && in_array(strtolower(pathinfo($writing->attachment_name, PATHINFO_EXTENSION)), ['docx', 'txt'], true)))
            @if ($writing->cover_path)
                <figure class="reading-cover reading-cover-hero">
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($writing->cover_path) }}" alt="Sampul {{ $writing->title }}">
                    <figcaption class="reading-cover-caption">
                        <span class="writing-type reading-article-type">{{ $types[$writing->type] ?? 'Tulisan' }}</span>
                        <h1>{{ $writing->title }}</h1>
                        @if ($writing->excerpt)<p class="reading-deck">{{ $writing->excerpt }}</p>@endif
                    </figcaption>
                </figure>
            @else
                <header class="reading-article-head reading-article-head-no-cover">
                    <span class="writing-type reading-article-type">{{ $types[$writing->type] ?? 'Tulisan' }}</span>
                    <h1>{{ $writing->title }}</h1>
                    @if ($writing->excerpt)<p class="reading-deck">{{ $writing->excerpt }}</p>@endif
                </header>
            @endif

            <header class="reading-article-head reading-article-byline-head">
                <div class="reading-author">
                    <span class="author-monogram" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($writing->author->name, 0, 1)) }}</span>
                    <div><strong>{{ $writing->author->name }}</strong><small>{{ $writing->author->bio ?: 'Penulis di Ruang Baca' }}</small></div>
                    <time>{{ optional($writing->published_at)->translatedFormat('d F Y') ?? 'Terbit' }}</time>
                </div>
            </header>

            @if (filled($writing->body))
                <div class="reading-body">{!! $writing->body !!}</div>
            @endif
        @endif

        @if ($writing->attachment_path)
            @include('writings.book-reader', [
                'writing' => $writing,
                'attachmentUrl' => \Illuminate\Support\Facades\Storage::disk('public')->url($writing->attachment_path),
                'attachmentExtension' => strtolower(pathinfo($writing->attachment_name, PATHINFO_EXTENSION)),
                'isBoundBook' => $writing->type === 'book' && in_array(strtolower(pathinfo($writing->attachment_name, PATHINFO_EXTENSION)), ['docx', 'txt'], true),
                'coverUrl' => $writing->cover_path ? \Illuminate\Support\Facades\Storage::disk('public')->url($writing->cover_path) : null,
            ])
        @endif

        <footer class="reading-author-note">
            <span class="author-monogram" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($writing->author->name, 0, 1)) }}</span>
            <div><p class="eyebrow">Tentang penulis</p><h2>{{ $writing->author->name }}</h2><p>{{ $writing->author->bio ?: 'Penulis yang berbagi karya di Ruang Baca.' }}</p></div>
        </footer>
    </article>
@endsection
