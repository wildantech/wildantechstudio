@extends('layouts.app')

@section('title', $project->title.' - WildanTech Studio')

@section('content')
    <section class="container page-intro">
        <p class="eyebrow">{{ $project->category }}</p>
        <h1 class="page-title">{{ $project->title }}</h1>
        <p>{{ $project->summary }}</p>
        <ul class="stack-list">
            @foreach ($project->technology_stack ?? [] as $technology)
                <li>{{ $technology }}</li>
            @endforeach
        </ul>
    </section>
    @if ($project->coverImageUrl())
        <div class="container project-detail-image"><img src="{{ $project->coverImageUrl() }}" alt="Pratinjau {{ $project->title }}"></div>
    @endif
    <section class="container section">
        <div class="prose-block"><p>{{ $project->description }}</p></div>
        <a class="button-quiet" href="{{ route('home') }}#karya">Kembali ke karya</a>
    </section>
@endsection
