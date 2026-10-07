@extends('layouts.app')

@section('title', ($service->exists ? 'Edit layanan' : 'Tambah layanan').' - WildanTech')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head"><div><p class="eyebrow">Admin studio</p><h1>{{ $service->exists ? 'Edit layanan' : 'Tambah layanan' }}</h1></div></div>
        <form class="surface" method="POST" action="{{ $service->exists ? route('dashboard.admin.services.update', $service) : route('dashboard.admin.services.store') }}">
            @csrf
            @if ($service->exists) @method('PUT') @endif
            <div class="form-grid">
                <div class="field"><label for="title">Nama layanan</label><input id="title" name="title" value="{{ old('title', $service->title) }}" required></div>
                <div class="field"><label for="category">Kategori</label><input id="category" name="category" value="{{ old('category', $service->category) }}" required></div>
                <div class="field full"><label for="summary">Ringkasan</label><input id="summary" name="summary" value="{{ old('summary', $service->summary) }}" required></div>
                <div class="field full"><label for="description">Deskripsi</label><textarea id="description" name="description" required>{{ old('description', $service->description) }}</textarea></div>
                <div class="field"><label for="icon">Penanda</label><select id="icon" name="icon"><option value="spark" @selected(old('icon', $service->icon) === 'spark')>Produk</option><option value="code" @selected(old('icon', $service->icon) === 'code')>Aplikasi</option><option value="cpu" @selected(old('icon', $service->icon) === 'cpu')>IoT</option><option value="server" @selected(old('icon', $service->icon) === 'server')>Server</option></select></div>
                <div class="field"><label for="sort_order">Urutan tampil</label><input id="sort_order" type="number" min="0" name="sort_order" value="{{ old('sort_order', $service->sort_order ?? 0) }}"></div>
                <label class="checkbox-field"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service->is_active ?? true))><span>Tampilkan di halaman publik</span></label>
            </div>
            <div class="form-actions"><button class="button" type="submit">Simpan layanan</button><a class="button-quiet" href="{{ route('dashboard.admin.services.index') }}">Batal</a></div>
        </form>
    </section>
@endsection
