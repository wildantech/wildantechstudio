@extends('layouts.app')

@section('title', 'WildanTech Studio - Karya dan produk digital')

@section('content')
    <section class="container hero reveal" id="tentang">
        <div class="hero-copy">
            <p class="eyebrow">Studio teknologi · Wonosobo / Yogyakarta</p>
            <h1>Ide nyata.<br><span>Sistem yang bekerja.</span></h1>
            <p class="hero-lead">WildanTech adalah studio teknologi personal untuk membangun aplikasi, prototipe IoT, otomasi, dan produk digital yang dekat dengan kebutuhan penggunanya.</p>
            <div class="hero-actions">
                <a class="button" href="#karya">Jelajahi karya</a>
                <a class="button-quiet" href="{{ route('studio.invitations') }}">Lihat undangan digital</a>
            </div>
            <p class="hero-note">Studio kecil. Rasa ingin tahu besar. Dikerjakan langsung oleh Wildan.</p>
        </div>
        <div class="hero-media" aria-label="Wildan Ulul Aufa, pendiri WildanTech">
            <div class="hero-orbit">
                <img src="{{ asset('images/wildan-portrait.jpeg') }}" alt="Wildan Ulul Aufa">
            </div>
            <span class="orbit-label one">Aplikasi & web</span>
            <span class="orbit-label two">IoT & perangkat</span>
            <span class="orbit-label three">Produk digital</span>
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
