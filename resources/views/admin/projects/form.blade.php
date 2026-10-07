@extends('layouts.app')

@section('title', ($project->exists ? 'Edit karya' : 'Tambah karya').' - WildanTech')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head"><div><p class="eyebrow">Admin studio</p><h1>{{ $project->exists ? 'Edit karya' : 'Tambah karya' }}</h1></div></div>
        <form class="surface" method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route('dashboard.admin.projects.update', $project) : route('dashboard.admin.projects.store') }}">
            @csrf
            @if ($project->exists) @method('PUT') @endif
            <div class="form-grid">
                <div class="field"><label for="title">Nama proyek</label><input id="title" name="title" value="{{ old('title', $project->title) }}" required></div>
                <div class="field"><label for="category">Kategori / konteks</label><input id="category" name="category" value="{{ old('category', $project->category) }}" placeholder="Proyek mandiri, magang, skripsi" required></div>
                <div class="field full"><label for="summary">Ringkasan singkat</label><input id="summary" name="summary" value="{{ old('summary', $project->summary) }}" maxlength="240" required></div>
                <div class="field full"><label for="description">Deskripsi dan kontribusi</label><textarea id="description" name="description" required>{{ old('description', $project->description) }}</textarea></div>
                <div class="field full"><label for="technology_stack">Teknologi</label><input id="technology_stack" name="technology_stack" value="{{ old('technology_stack', implode(', ', $project->technology_stack ?? [])) }}"><small>Pisahkan dengan koma.</small></div>
                <div class="field"><label for="cover_image">Gambar sampul</label><input id="cover_image" type="file" name="cover_image" accept="image/jpeg,image/png,image/webp"><small>JPG, PNG, atau WebP. Maksimal 4 MB.</small></div>
                <div class="field"><label for="sort_order">Urutan tampil</label><input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}"></div>
                @if ($project->coverImageUrl())<div class="field full"><img src="{{ $project->coverImageUrl() }}" alt="Gambar {{ $project->title }} saat ini" style="max-height:200px;width:auto;border-radius:5px"></div>@endif
                <label class="checkbox-field"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))><span>Tandai sebagai karya pilihan</span></label>
                <label class="checkbox-field"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $project->is_published ?? true))><span>Tampilkan di halaman publik</span></label>
            </div>
            <div class="form-actions"><button class="button" type="submit">Simpan karya</button><a class="button-quiet" href="{{ route('dashboard.admin.projects.index') }}">Batal</a></div>
        </form>
    </section>
@endsection
