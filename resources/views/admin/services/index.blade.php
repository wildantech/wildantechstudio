@extends('layouts.app')

@section('title', 'Layanan studio - WildanTech')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head"><div><p class="eyebrow">Admin studio</p><h1>Layanan</h1><p>Atur layanan dan produk yang tampil di situs publik.</p></div><a class="button" href="{{ route('dashboard.admin.services.create') }}">Tambah layanan</a></div>
        <nav class="dashboard-links"><a class="button-quiet button-small" href="{{ route('dashboard.index') }}">Dashboard</a><a class="button-quiet button-small" href="{{ route('dashboard.admin.projects.index') }}">Karya</a></nav>
        <div class="surface">
            @if ($services->isEmpty())<div class="empty-state">Belum ada layanan.</div>@else
                <div class="guest-table-wrap"><table class="table"><thead><tr><th>Layanan</th><th>Kategori</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
                    @foreach ($services as $service)
                        <tr><td><strong>{{ $service->title }}</strong><br><span class="quiet">{{ $service->summary }}</span></td><td>{{ $service->category }}</td><td>{{ $service->sort_order }}</td><td>{{ $service->is_active ? 'Aktif' : 'Disembunyikan' }}</td><td><div class="admin-actions"><a class="button-quiet button-small" href="{{ route('dashboard.admin.services.edit', $service) }}">Edit</a><form method="POST" action="{{ route('dashboard.admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini?')">@csrf @method('DELETE')<button class="button-danger button-small" type="submit">Hapus</button></form></div></td></tr>
                    @endforeach
                </tbody></table></div>
                @if ($services->hasPages())<div class="pagination">{{ $services->links() }}</div>@endif
            @endif
        </div>
    </section>
@endsection
