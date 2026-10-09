@extends('layouts.app')

@section('title', 'WildanTech Studio - Karya dan produk digital')

@section('content')
    <section class="hero-section reveal" id="beranda">
        <div class="container hero-container">
            <div class="hero-grid">
                <div class="hero-content">
                    <div class="hero-eyebrow">
                        <span class="hero-eyebrow-bar"></span>
                        <span class="hero-eyebrow-text">STUDIO TEKNOLOGI</span>
                    </div>

                    <h1 class="hero-headline">
                        Ide nyata.<br>
                        Sistem yang<br>
                        <span class="headline-lime">bekerja.<svg class="headline-dashes" viewBox="0 0 46 22" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M4 18L16 4M20 18L32 4" stroke="#c5f36b" stroke-width="4.5" stroke-linecap="round"/></svg></span>
                    </h1>

                    <p class="hero-description">
                        WildanTech adalah studio teknologi personal untuk membangun aplikasi, prototipe IoT, otomasi, dan produk digital yang dekat dengan kebutuhan penggunanya.
                    </p>

                    <div class="hero-cta-group">
                        <a class="hero-cta-primary" href="#karya">
                            <span>Jelajahi karya</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a class="hero-cta-secondary" href="{{ route('studio.invitations') }}">
                            <span>Lihat undangan digital</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
                        </a>
                    </div>

                    <div class="hero-proof">
                        <div class="proof-avatars" aria-hidden="true">
                            <img src="{{ asset('images/clients/client-1.svg') }}" alt="Klien WildanTech" width="34" height="34" loading="lazy">
                            <img src="{{ asset('images/clients/client-2.svg') }}" alt="Klien WildanTech" width="34" height="34" loading="lazy">
                            <img src="{{ asset('images/clients/client-3.svg') }}" alt="Klien WildanTech" width="34" height="34" loading="lazy">
                        </div>
                        <div class="proof-copy">
                            <strong class="proof-title">Dipercaya oleh banyak klien</strong>
                            <span class="proof-sub">Dari UMKM hingga brand besar.</span>
                        </div>
                    </div>
                </div>

                <div class="hero-visual" aria-label="Wildan Ulul Alfa - WildanTech Studio">
                    <div class="hero-stage">
                        <!-- Forest green organic blob backdrop -->
                        <div class="stage-blob" aria-hidden="true"></div>

                        <!-- Neon lime tilted orbits -->
                        <div class="stage-orbit orbit-primary" aria-hidden="true"></div>
                        <div class="stage-orbit orbit-secondary" aria-hidden="true"></div>

                        <!-- Floating doodle crown -->
                        <div class="stage-doodle-crown" aria-hidden="true">
                            <svg viewBox="0 0 54 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 28L10 10L23 20L36 6L44 26L4 28Z" stroke="#c5f36b" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="10" cy="8" r="2.5" fill="#c5f36b"/>
                                <circle cx="23" cy="18" r="2.5" fill="#c5f36b"/>
                                <circle cx="36" cy="4" r="2.5" fill="#c5f36b"/>
                            </svg>
                        </div>

                        <!-- Main character portrait illustration -->
                        <img class="hero-character-photo" src="{{ asset('images/wildan-hero.png') }}" alt="Wildan Ulul Alfa">

                        <!-- 4 Floating Badge Pills -->
                        <div class="floating-pill pill-dev">
                            <div class="floating-icon" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                            </div>
                            <div class="floating-copy">
                                <strong>Web &amp; App</strong>
                                <small>Development</small>
                            </div>
                        </div>

                        <div class="floating-pill pill-cloud">
                            <div class="floating-icon" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/></svg>
                            </div>
                            <div class="floating-copy">
                                <strong>Cloud &amp; Server</strong>
                                <small>Solution</small>
                            </div>
                        </div>

                        <div class="floating-pill pill-iot">
                            <div class="floating-icon" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><path d="M15 2v2M9 2v2M15 20v2M9 20v2M2 15h2M2 9h2M20 15h2M20 9h2"/></svg>
                            </div>
                            <div class="floating-copy">
                                <strong>IoT &amp; Automation</strong>
                                <small>System</small>
                            </div>
                        </div>

                        <div class="floating-pill pill-design">
                            <div class="floating-icon" aria-hidden="true">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="m18 2 4 4-14 14H4v-4L18 2z"/><path d="m14.5 5.5 4 4"/></svg>
                            </div>
                            <div class="floating-copy">
                                <strong>Design &amp; UI/UX</strong>
                                <small>Creative</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Hero Bar -->
            <div class="hero-bottom-bar">
                <a class="scroll-pill" href="#karya">
                    <span class="scroll-mouse-icon" aria-hidden="true"><span class="scroll-mouse-dot"></span></span>
                    <span>Scroll untuk jelajahi</span>
                </a>
                <div class="hero-socials" aria-label="Media sosial WildanTech">
                    <a href="https://instagram.com/wildan.tech" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </a>
                    <a href="https://youtube.com/@wildantech" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/></svg>
                    </a>
                    <a href="https://github.com/wildantech" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"/><path d="M9 18c-4.51 2-5-2-7-2"/></svg>
                    </a>
                    <a href="https://linkedin.com/in/wildanulul" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
                    </a>
                    <a href="https://x.com/wildantech" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4l11.733 16h4.267l-11.733 -16z"/><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="karya">
        <div class="container">
            <div class="section-heading">
                <div><p class="eyebrow">Case studies</p><h2>Karya pilihan</h2></div>
                <p>Proyek skripsi, magang, mandiri, dan eksperimen yang menunjukkan proses membangun dari kebutuhan sampai solusi.</p>
            </div>
            <div class="project-grid">
                @forelse ($projects as $project)
                    <a class="project-card" href="{{ route('projects.show', $project) }}">
                        <div class="project-image">
                            @if ($project->coverImageUrl())
                                <img src="{{ $project->coverImageUrl() }}" alt="Pratinjau {{ $project->title }}" loading="lazy">
                            @else
                                <span class="project-placeholder">WT / LAB</span>
                            @endif
                        </div>
                        <div class="project-copy">
                            <div class="project-meta"><span>{{ $project->category }}</span>@if ($project->is_featured)<span>Pilihan</span>@endif</div>
                            <h3>{{ $project->title }}</h3>
                            <p>{{ $project->summary }}</p>
                            <ul class="stack-list">
                                @foreach (array_slice($project->technology_stack ?? [], 0, 4) as $technology)
                                    <li>{{ $technology }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </a>
                @empty
                    <p class="empty-state">Karya sedang disiapkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section" id="layanan">
        <div class="container">
            <div class="section-heading">
                <div><p class="eyebrow">What we build</p><h2>Ruang kerja WildanTech</h2></div>
                <p>Dari ide awal dan prototipe sampai aplikasi kecil yang siap dipakai dan dikembangkan.</p>
            </div>
            <div class="service-list">
                @forelse ($services as $service)
                    <article class="service-item">
                        <p class="eyebrow">{{ $service->category }}</p>
                        <h3>{{ $service->title }}</h3>
                        <p>{{ $service->summary }}</p>
                    </article>
                @empty
                    <p class="empty-state">Layanan sedang disiapkan.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container callout">
            <div>
                <p class="eyebrow">Produk WildanTech</p>
                <h2>Undangan digital yang lebih personal.</h2>
                <p>Kelola daftar tamu, bagikan tautan undangan tiap orang lewat WhatsApp, dan pantau konfirmasi kehadiran dari satu halaman.</p>
            </div>
            <a class="button" href="{{ route('studio.invitations') }}">Jelajahi produknya</a>
        </div>
    </section>

    <section class="section" id="kontak">
        <div class="container callout">
            <div>
                <p class="eyebrow">Mulai percakapan</p>
                <h2>Punya ide yang ingin diwujudkan?</h2>
                <p>Hubungi WildanTech untuk membahas kebutuhan produk, aplikasi, atau prototipe.</p>
            </div>
            <a class="button" href="https://wa.me/6281215430648?text=Halo%20WildanTech%2C%20saya%20ingin%20berdiskusi%20tentang%20sebuah%20proyek." target="_blank" rel="noopener noreferrer">Diskusikan proyek</a>
        </div>
    </section>
@endsection
