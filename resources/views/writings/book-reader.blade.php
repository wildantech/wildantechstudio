<section class="book-reader {{ $isBoundBook ? 'book-reader-bound' : '' }}" data-book-reader data-book-kind="{{ $attachmentExtension }}" data-book-url="{{ $attachmentUrl }}" data-book-title="{{ $writing->title }}" data-book-has-cover="{{ $isBoundBook ? 'true' : 'false' }}">
    @unless ($isBoundBook)
        <div class="book-reader-heading">
            <div><p class="eyebrow">Pratinjau naskah</p><h2>{{ $writing->attachment_name }}</h2></div>
            <a class="book-download" href="{{ $attachmentUrl }}" target="_blank" rel="noopener noreferrer">{{ $attachmentExtension === 'pdf' ? 'Buka PDF di tab baru' : 'Buka berkas asli' }} ↗</a>
        </div>
    @endunless
    <div class="book-stage {{ $isBoundBook ? 'has-volume-cover' : '' }}" data-book-stage>
        @if ($attachmentExtension === 'pdf')
            <div class="book-pdf-frame">
                <iframe data-book-pdf title="Baca {{ $writing->title }}" src="{{ $attachmentUrl }}#toolbar=0&navpanes=0&page=1"></iframe>
                <div class="book-turn-sheet" data-book-turn aria-hidden="true"></div>
                <div class="book-gesture-layer" data-book-gesture aria-hidden="true"></div>
            </div>
        @elseif (in_array($attachmentExtension, ['docx', 'txt'], true))
            <div class="book-spread" data-book-spread aria-live="polite">
                <article class="book-page book-page-left">
                    <span class="book-running-head">{{ $writing->title }}</span>
                    <div class="book-page-content" data-book-left-content></div>
                    <span class="book-page-number" data-book-left-number></span>
                </article>
                <article class="book-page book-page-right">
                    <span class="book-running-head">{{ $writing->title }}</span>
                    <div class="book-page-content" data-book-right-content>
                        <p class="book-loading">Menyiapkan halaman naskah…</p>
                    </div>
                    <span class="book-page-number" data-book-right-number></span>
                </article>
                <div class="book-turn-sheet" data-book-turn aria-hidden="true"></div>
            </div>
            @if ($isBoundBook)
                <button class="book-volume-cover" data-book-cover type="button" aria-label="Geser atau ketuk untuk membuka buku">
                    @if ($coverUrl)
                        <img src="{{ $coverUrl }}" alt="">
                    @else
                        <span class="book-volume-cover-mark" aria-hidden="true">B</span>
                    @endif
                    <span class="book-volume-cover-shade" aria-hidden="true"></span>
                    <span class="book-volume-cover-copy">
                        <span class="writing-type reading-article-type">Buku</span>
                        <strong>{{ $writing->title }}</strong>
                        <span>{{ $writing->author->name }}</span>
                        @if ($writing->excerpt)<span class="book-volume-cover-excerpt">{{ $writing->excerpt }}</span>@endif
                        <small>Geser atau ketuk untuk membaca</small>
                    </span>
                </button>
            @endif
        @else
            <div class="book-unsupported">
                <span class="book-unsupported-mark" aria-hidden="true">W</span>
                <h3>Naskah siap dibuka</h3>
                <p>Pratinjau halaman tersedia untuk PDF, DOCX, dan TXT. Berkas Word lama tetap bisa diunduh untuk dibaca.</p>
                <a class="button" href="{{ $attachmentUrl }}" target="_blank" rel="noopener noreferrer">Buka naskah</a>
            </div>
        @endif
        <div class="book-reader-error" data-book-error hidden></div>
    </div>
    @if (in_array($attachmentExtension, ['pdf', 'docx', 'txt'], true))
        <div class="book-controls" aria-live="polite">
            <span data-book-page-label>{{ $isBoundBook ? 'Geser sampul ke kiri untuk membuka' : 'Memuat naskah…' }}</span>
            <span class="book-swipe-hint">{{ $isBoundBook ? 'Geser sampul ke kiri untuk membaca' : 'Geser ke kiri untuk lanjut · ke kanan untuk kembali' }}</span>
        </div>
    @endif
</section>
