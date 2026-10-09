@extends('layouts.app')

@section('title', $project->title.' - WildanTech Studio')

@section('content')
    <section class="container page-intro">
        <a class="button-quiet button-small" href="{{ route('home') }}#karya" style="margin-bottom: 20px; display: inline-flex; align-items: center; gap: 6px;">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
            <span>Kembali ke Karya</span>
        </a>
        <p class="eyebrow">{{ $project->category }}</p>
        <h1 class="page-title">{{ $project->title }}</h1>
        <p style="font-size: 15px; line-height: 1.7; color: #a4b4a6; max-width: 720px; margin-top: 12px;">{{ $project->summary }}</p>
        <ul class="stack-list">
            @foreach ($project->technology_stack ?? [] as $technology)
                <li>{{ $technology }}</li>
            @endforeach
        </ul>
    </section>
    @if ($project->coverImageUrl())
        <div class="container project-detail-image" style="margin-top: 24px;"><img src="{{ $project->coverImageUrl() }}" alt="Pratinjau {{ $project->title }}"></div>
    @endif
    <section class="container section">
        <div class="surface" style="max-width: 840px;">
            <div class="prose-block" style="font-size: 14.5px; line-height: 1.8; color: #d6e0d8;">
                <p>{{ $project->description }}</p>
            </div>
            <div style="margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <a class="button-quiet" href="{{ route('home') }}#karya">← Lihat Karya Lainnya</a>
                <a class="button" href="https://wa.me/6281215430648?text={{ urlencode('Halo Mas Wildan, saya tertarik berdiskusi tentang proyek seperti: '.$project->title) }}" target="_blank" rel="noopener noreferrer">Konsultasikan Proyek Serupa ↗</a>
            </div>
        </div>
    </section>
@endsection
