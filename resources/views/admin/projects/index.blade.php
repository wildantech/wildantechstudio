@extends('layouts.app')

@section('title', 'Karya studio - WildanTech')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head"><div><p class="eyebrow">Admin studio</p><h1>Karya</h1><p>Atur proyek yang tampil pada halaman publik.</p></div><a class="button" href="{{ route('dashboard.admin.projects.create') }}">Tambah karya</a></div>
        <nav class="dashboard-links"><a class="button-quiet button-small" href="{{ route('dashboard.index') }}">Dashboard</a><a class="button-quiet button-small" href="{{ route('dashboard.admin.services.index') }}">Layanan</a></nav>
        <div class="surface">
            @if ($projects->isEmpty())<div class="empty-state">Belum ada karya.</div>@else
                <div class="guest-table-wrap"><table class="table"><thead><tr><th>Proyek</th><th>Kategori</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
                    @foreach ($projects as $project)
                        <tr><td><strong>{{ $project->title }}</strong><br><span class="quiet">{{ $project->summary }}</span></td><td>{{ $project->category }}</td><td>{{ $project->sort_order }}</td><td>{{ $project->is_published ? 'Tampil' : 'Draf' }}</td><td><div class="admin-actions"><a class="button-quiet button-small" href="{{ route('dashboard.admin.projects.edit', $project) }}">Edit</a><form method="POST" action="{{ route('dashboard.admin.projects.destroy', $project) }}" onsubmit="return confirm('Hapus karya ini?')">@csrf @method('DELETE')<button class="button-danger button-small" type="submit">Hapus</button></form></div></td></tr>
                    @endforeach
                </tbody></table></div>
                @if ($projects->hasPages())<div class="pagination">{{ $projects->links() }}</div>@endif
            @endif
        </div>
    </section>
@endsection
