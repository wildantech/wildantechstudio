@extends('layouts.app')

@section('writing_mode', true)
@php($isEditing = $writing->exists)
@section('title', ($isEditing ? 'Edit Karya' : 'Tulis Karya').' - Studio Tulisan')

@section('content')
    <section class="container writing-editor-page">
        <a class="reading-back" href="{{ route('dashboard.writings.index') }}">← Kembali ke meja tulis</a>
        <header class="writing-editor-heading"><p class="eyebrow">{{ $isEditing ? 'Lanjutkan karyamu' : 'Lembar baru' }}</p><h1>{{ $isEditing ? 'Setiap kata bisa tumbuh.' : 'Mulai dari satu kalimat.' }}</h1><p>Tulis langsung di sini atau lampirkan naskah. Kamu yang menentukan kapan karya siap dibagikan.</p></header>
        <form class="writing-editor" method="POST" enctype="multipart/form-data" action="{{ $isEditing ? route('dashboard.writings.update', $writing) : route('dashboard.writings.store') }}">
            @csrf
            @if ($isEditing)@method('PUT')@endif
            <div class="writing-editor-main">
                <div class="field"><label for="writing-title">Judul karya</label><input id="writing-title" name="title" value="{{ old('title', $writing->title) }}" maxlength="180" placeholder="Beri nama pada karyamu..." required>@error('title')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="writing-excerpt">Pengantar singkat <span>(opsional)</span></label><textarea id="writing-excerpt" name="excerpt" maxlength="360" rows="3" placeholder="Kalimat yang mengundang pembaca masuk...">{{ old('excerpt', $writing->excerpt) }}</textarea>@error('excerpt')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field writing-body-field">
                    <label for="writing-body-editor">Isi karya</label>
                    <div class="rich-editor-shell" data-rich-editor-shell>
                        <div class="rich-editor-toolbar" data-rich-editor-toolbar role="toolbar" aria-label="Pemformatan tulisan">
                            <select data-rich-format aria-label="Gaya paragraf">
                                <option value="P">Paragraf</option>
                                <option value="H2">Judul</option>
                                <option value="H3">Subjudul</option>
                                <option value="BLOCKQUOTE">Kutipan</option>
                            </select>
                            <span class="rich-toolbar-divider" aria-hidden="true"></span>
                            <button type="button" data-rich-command="bold" aria-label="Tebalkan" title="Tebalkan"><strong>B</strong></button>
                            <button type="button" data-rich-command="italic" aria-label="Miring" title="Miring"><em>I</em></button>
                            <button type="button" data-rich-command="underline" aria-label="Garis bawah" title="Garis bawah"><u>U</u></button>
                            <span class="rich-toolbar-divider" aria-hidden="true"></span>
                            <button type="button" data-rich-command="insertUnorderedList" aria-label="Daftar titik" title="Daftar titik">• List</button>
                            <button type="button" data-rich-command="insertOrderedList" aria-label="Daftar angka" title="Daftar angka">1. List</button>
                        </div>
                        <div id="writing-body-editor" class="rich-editor-content" data-rich-editor-content contenteditable="true" role="textbox" aria-multiline="true" aria-label="Isi karya" data-placeholder="Tuangkan kata-katamu di sini..."></div>
                        <textarea id="writing-body" class="rich-editor-source" name="body" rows="20" placeholder="Tuangkan kata-katamu di sini...">{{ old('body', $writing->body) }}</textarea>
                    </div>
                    <small>Baris baru dan gaya tulisan akan ikut tersimpan.</small>
                    @error('body')<small class="field-error">{{ $message }}</small>@enderror
                </div>
            </div>
            <aside class="writing-editor-side">
                <div class="editor-side-card"><p class="eyebrow">Pengaturan karya</p>
                    <div class="field"><label for="writing-type">Jenis</label><select id="writing-type" name="type" required>@foreach ($types as $key => $label)<option value="{{ $key }}" @selected(old('type', $writing->type ?: 'article') === $key)>{{ $label }}</option>@endforeach</select>@error('type')<small class="field-error">{{ $message }}</small>@enderror</div>
                    <div class="field">
                        <label for="writing-cover">Sampul <span>(opsional)</span></label>
                        <input id="writing-cover" name="cover" type="file" accept="image/jpeg,image/png,image/webp">
                        <small>JPG, PNG, atau WebP · maks. 5 MB</small>
                        @if ($writing->cover_path)
                            <img class="editor-cover-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($writing->cover_path) }}" alt="Sampul saat ini">
                            <label class="checkbox-field"><input type="checkbox" name="remove_cover" value="1"><span>Hapus sampul ini</span></label>
                        @endif
                        @error('cover')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                    <div class="field">
                        <label for="writing-attachment">Lampiran naskah <span>(opsional)</span></label>
                        <input id="writing-attachment" name="attachment" type="file" accept=".pdf,.doc,.docx,.txt">
                        <small>PDF, DOC, DOCX, atau TXT · maks. 30 MB. Lampiran akan tersedia untuk pembaca.</small>
                        @if ($writing->attachment_name)
                            <small>Terpasang: {{ $writing->attachment_name }}</small>
                            <label class="checkbox-field"><input type="checkbox" name="remove_attachment" value="1"><span>Hapus lampiran ini</span></label>
                        @endif
                        @error('attachment')<small class="field-error">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="editor-side-note"><span aria-hidden="true">✳</span><p>Tidak ada proses persetujuan. Saat kamu klik Terbitkan, karya langsung muncul di Ruang Baca.</p></div>
                <div class="writing-editor-actions"><button class="button-quiet" type="submit" name="status" value="draft">Simpan draf</button><button class="button" type="submit" name="status" value="published">{{ $isEditing && $writing->status === 'published' ? 'Simpan & terbitkan' : 'Terbitkan karya' }} <span aria-hidden="true">↗</span></button></div>
            </aside>
        </form>
    </section>
@endsection
