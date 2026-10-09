@extends('layouts.app')

@section('title', 'Undangan Digital - WildanTech Studio')
@section('description', 'Pilih tema undangan digital eksklusif dari WildanTech Studio: Niku Story, Midnight Moon, Jawa Heritage, Netflix, dan Indigo.')

@section('content')
    <!-- Hero Greeting & Workflow -->
    <section class="hero-section reveal">
        <div class="container hero-container">
            <div class="hero-content" style="max-width: 680px;">
                <div class="hero-eyebrow">
                    <span class="hero-eyebrow-bar"></span>
                    <span class="hero-eyebrow-text">STUDIO UNDANGAN DIGITAL PERSONAL</span>
                </div>

                <h1 class="hero-headline">
                    Pilih tema favorit.<br>
                    Bercerita dengan<br>
                    <span class="headline-lime">gayamu.<svg class="headline-dashes" viewBox="0 0 46 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 18L16 4M20 18L32 4" stroke="#c5f36b" stroke-width="4.5" stroke-linecap="round"/></svg></span>
                </h1>

                <p class="hero-description" style="font-size: 15px;">
                    Selamat datang di koleksi tema undangan digital WildanTech Studio. Setiap tema dirancang dengan karakter visual mendalam dan interaktivitas mulus. Cek preview tema di bawah, pilih yang paling cocok, lalu mulai lengkapi data acaramu.
                </p>

                <!-- Step flow helper -->
                <div class="theme-flow-guide">
                    <div class="flow-step is-active">
                        <span class="flow-num">1</span>
                        <div class="flow-info">
                            <strong>Pilih Tema</strong>
                            <small>Pilih gaya favorit</small>
                        </div>
                    </div>
                    <div class="flow-arrow" aria-hidden="true">→</div>
                    <div class="flow-step">
                        <span class="flow-num">2</span>
                        <div class="flow-info">
                            <strong>Cek Preview</strong>
                            <small>Lihat demo langsung</small>
                        </div>
                    </div>
                    <div class="flow-arrow" aria-hidden="true">→</div>
                    <div class="flow-step">
                        <span class="flow-num">3</span>
                        <div class="flow-info">
                            <strong>Isi Data</strong>
                            <small>Cerita &amp; acara</small>
                        </div>
                    </div>
                    <div class="flow-arrow" aria-hidden="true">→</div>
                    <div class="flow-step">
                        <span class="flow-num">4</span>
                        <div class="flow-info">
                            <strong>Sebar Tamu</strong>
                            <small>Tautan personal</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theme Showcase Grid -->
    <section class="container section" id="koleksi-tema">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Koleksi Pilihan</p>
                <h2>5 Tema Undangan Unggulan</h2>
            </div>
            <p>Klik tombol preview untuk melihat simulasi interaktif, atau pilih tema untuk langsung mengisi data undangan Anda.</p>
        </div>

        <div class="theme-catalog-grid">
            <!-- 1. Niku Story -->
            <article class="theme-catalog-card theme-card-niku">
                <div class="theme-card-banner">
                    <div class="theme-badge">Minimalis Editorial</div>
                    <div class="theme-preview-visual niku-visual">
                        <span class="theme-watermark">NIKU</span>
                        <div class="theme-mini-frame">
                            <span class="mini-title">The Wedding of</span>
                            <strong class="mini-names">Alya &amp; Raka</strong>
                            <small class="mini-tagline">Floral Editorial · Modern</small>
                        </div>
                    </div>
                </div>
                <div class="theme-card-body">
                    <div class="theme-header">
                        <h3>Niku Story</h3>
                        <p class="theme-vibe">Nuansa tenang berestetika majalah editorial dengan tipografi anggun dan tata letak modern.</p>
                    </div>
                    <ul class="theme-features-pills">
                        <li><span>✦</span> Audio Autoplay</li>
                        <li><span>✦</span> Galeri Foto Interaktif</li>
                        <li><span>✦</span> Love Story Timeline</li>
                        <li><span>✦</span> Hitung Mundur &amp; RSVP</li>
                    </ul>
                    <div class="theme-card-actions">
                        <a class="button-preview" href="{{ route('studio.invitations.preview', 'niku-story') }}" target="_blank" rel="noopener noreferrer">
                            <span>Lihat Preview</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                        <a class="button-choose" href="{{ route('dashboard.invitations.create', ['theme' => 'niku-story']) }}">
                            <span>Pilih Tema Ini</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- 2. Midnight Moon -->
            <article class="theme-catalog-card theme-card-midnight">
                <div class="theme-card-banner">
                    <div class="theme-badge">Dark Romance</div>
                    <div class="theme-preview-visual midnight-visual">
                        <span class="theme-watermark">MOON</span>
                        <div class="theme-mini-frame">
                            <div class="mini-moon-circle" aria-hidden="true"></div>
                            <span class="mini-title">Under The Stars</span>
                            <strong class="mini-names">Alya &amp; Raka</strong>
                            <small class="mini-tagline">3D Rotating Moon &amp; Starfield</small>
                        </div>
                    </div>
                </div>
                <div class="theme-card-body">
                    <div class="theme-header">
                        <h3>Midnight Moon</h3>
                        <p class="theme-vibe">Suasana malam syahdu dengan animasi rotasi bulan 3D realistis dan alunan biola romantis.</p>
                    </div>
                    <ul class="theme-features-pills">
                        <li><span>✦</span> Rotasi Bulan 3D Realtime</li>
                        <li><span>✦</span> Efek Bintang Bergerak</li>
                        <li><span>✦</span> Musik Violin Cover</li>
                        <li><span>✦</span> Dark Mode Premium</li>
                    </ul>
                    <div class="theme-card-actions">
                        <a class="button-preview" href="{{ route('studio.invitations.preview', 'midnight-moon') }}" target="_blank" rel="noopener noreferrer">
                            <span>Lihat Preview</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                        <a class="button-choose" href="{{ route('dashboard.invitations.create', ['theme' => 'midnight-moon']) }}">
                            <span>Pilih Tema Ini</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- 3. Jawa Heritage -->
            <article class="theme-catalog-card theme-card-jawa">
                <div class="theme-card-banner">
                    <div class="theme-badge">Adat Tradisional</div>
                    <div class="theme-preview-visual jawa-visual">
                        <span class="theme-watermark">JAWA</span>
                        <div class="theme-mini-frame">
                            <span class="mini-title">Pawiwahan Ageng</span>
                            <strong class="mini-names">Alya &amp; Raka</strong>
                            <small class="mini-tagline">Wayang Motion &amp; Gunungan Emas</small>
                        </div>
                    </div>
                </div>
                <div class="theme-card-body">
                    <div class="theme-header">
                        <h3>Jawa Heritage</h3>
                        <p class="theme-vibe">Kemegahan budaya Jawa klasik dengan video wayang motion, ornamen gunungan, dan gamelan.</p>
                    </div>
                    <ul class="theme-features-pills">
                        <li><span>✦</span> Animasi Wayang Motion</li>
                        <li><span>✦</span> Ornamen Gunungan &amp; Batik</li>
                        <li><span>✦</span> Musik Campursari / Gamelan</li>
                        <li><span>✦</span> Salin Rekening &amp; Amplop</li>
                    </ul>
                    <div class="theme-card-actions">
                        <a class="button-preview" href="{{ route('studio.invitations.preview', 'jawa') }}" target="_blank" rel="noopener noreferrer">
                            <span>Lihat Preview</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                        <a class="button-choose" href="{{ route('dashboard.invitations.create', ['theme' => 'jawa']) }}">
                            <span>Pilih Tema Ini</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- 4. Netflix -->
            <article class="theme-catalog-card theme-card-netflix">
                <div class="theme-card-banner">
                    <div class="theme-badge">Cinematic Streaming</div>
                    <div class="theme-preview-visual netflix-visual">
                        <span class="theme-watermark">SERIES</span>
                        <div class="theme-mini-frame">
                            <span class="mini-red-pill">ORIGINAL</span>
                            <strong class="mini-names">Alya &amp; Raka</strong>
                            <small class="mini-tagline">Episode: Menuju Hari Bahagia</small>
                        </div>
                    </div>
                </div>
                <div class="theme-card-body">
                    <div class="theme-header">
                        <h3>Netflix Style</h3>
                        <p class="theme-vibe">Konsep kreatif ala platform streaming, mengemas kisah cinta bagaikan serial tayangan favorit.</p>
                    </div>
                    <ul class="theme-features-pills">
                        <li><span>✦</span> Intro Card Gaya Netflix</li>
                        <li><span>✦</span> Match Episode &amp; Season</li>
                        <li><span>✦</span> Video Teaser Sinematik</li>
                        <li><span>✦</span> RSVP &amp; Kolom Ucapan</li>
                    </ul>
                    <div class="theme-card-actions">
                        <a class="button-preview" href="{{ route('studio.invitations.preview', 'netflix') }}" target="_blank" rel="noopener noreferrer">
                            <span>Lihat Preview</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                        <a class="button-choose" href="{{ route('dashboard.invitations.create', ['theme' => 'netflix']) }}">
                            <span>Pilih Tema Ini</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>

            <!-- 5. Indigo -->
            <article class="theme-catalog-card theme-card-indigo">
                <div class="theme-card-banner">
                    <div class="theme-badge">Deep Velvet Floral</div>
                    <div class="theme-preview-visual indigo-visual">
                        <span class="theme-watermark">INDIGO</span>
                        <div class="theme-mini-frame">
                            <span class="mini-title">Walimatul Ursy</span>
                            <strong class="mini-names">Alya &amp; Raka</strong>
                            <small class="mini-tagline">Indigo Floral &amp; Timeless Romance</small>
                        </div>
                    </div>
                </div>
                <div class="theme-card-body">
                    <div class="theme-header">
                        <h3>Indigo Night</h3>
                        <p class="theme-vibe">Pesona velvet biru gelap berhias ilustrasi floral anggun untuk perayaan khidmat dan berkelas.</p>
                    </div>
                    <ul class="theme-features-pills">
                        <li><span>✦</span> Ilustrasi Gapura &amp; Bunga</li>
                        <li><span>✦</span> Rangkaian Acara Lengkap</li>
                        <li><span>✦</span> Buku Tamu &amp; Konfirmasi</li>
                        <li><span>✦</span> Navigasi Google Maps</li>
                    </ul>
                    <div class="theme-card-actions">
                        <a class="button-preview" href="{{ route('studio.invitations.preview', 'indigo') }}" target="_blank" rel="noopener noreferrer">
                            <span>Lihat Preview</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                        <a class="button-choose" href="{{ route('dashboard.invitations.create', ['theme' => 'indigo']) }}">
                            <span>Pilih Tema Ini</span>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- Cara Kerja Singkat -->
    <section class="container section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Alur Kerja</p>
                <h2>Mudah, Cepat, dan Personal.</h2>
            </div>
            <p>Dari pemilihan tema hingga pembagian tautan ke setiap tamu terdaftar.</p>
        </div>
        <div class="service-list">
            <article class="service-item">
                <p class="eyebrow">01 · Tentukan Gaya</p>
                <h3>Pilih tema favorit</h3>
                <p>Mulai dengan memilih salah satu dari 5 tema visual yang paling sesuai dengan impian pernikahanmu.</p>
            </article>
            <article class="service-item">
                <p class="eyebrow">02 · Lengkapi Acara</p>
                <h3>Isi data &amp; pasangan</h3>
                <p>Tuliskan nama kedua mempelai, orang tua, tanggal akad &amp; resepsi, lokasi maps, serta rekening hadiah.</p>
            </article>
            <article class="service-item">
                <p class="eyebrow">03 · Atur Tamu</p>
                <h3>Generate tautan privat</h3>
                <p>Tambah daftar tamu dan nomor WhatsApp. Sistem otomatis membuat link unik untuk setiap nama tamu.</p>
            </article>
            <article class="service-item">
                <p class="eyebrow">04 · Kirim &amp; Pantau</p>
                <h3>Bagikan via WhatsApp</h3>
                <p>Kirim langsung dengan template pesan personal, dan pantau respons RSVP serta ucapan doa secara realtime.</p>
            </article>
        </div>
    </section>

    <!-- Consultation Callout -->
    <section class="container section">
        <div class="callout">
            <div>
                <p class="eyebrow">Layanan Pendampingan</p>
                <h2>Ingin dibantu pengisian data atau kustomisasi khusus?</h2>
                <p>Tim WildanTech siap membantu input data awal, pemilihan musik, atau penyesuaian teks agar undanganmu siap disebar tanpa repot.</p>
            </div>
            <a class="button" href="https://wa.me/6281215430648?text=Halo%20WildanTech%2C%20saya%20ingin%20berkonsultasi%20tentang%20undangan%20digital." target="_blank" rel="noopener noreferrer">Konsultasi via WhatsApp</a>
        </div>
    </section>
@endsection
