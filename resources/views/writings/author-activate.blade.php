@extends('layouts.app')

@section('writing_mode', true)
@section('title', 'Aktifkan Ruang Tulis - WildanTech Studio')

@section('content')
    <section class="container author-onboarding">
        <div class="author-onboarding-aside">
            <p class="eyebrow">Ruang Baca · Penulis</p>
            <h1>Karyamu layak<br>punya <em>ruang.</em></h1>
            <p>Akunmu sudah siap. Lengkapi profil penulis untuk mulai membagikan artikel, buku, atau puisi.</p>
            <div class="author-profile-preview">
                <span class="author-monogram">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(old('name', $existingAccount->name), 0, 1)) }}</span>
                <div>
                    <strong>{{ old('name', $existingAccount->name) }}</strong>
                    <small>{{ old('bio', $existingAccount->bio ?: 'Biografi singkatmu akan tampil bersama karya.') }}</small>
                </div>
            </div>
        </div>
        <div class="author-onboarding-form">
            <p class="eyebrow">Profil penulis</p>
            <h2>Aktifkan ruang tulismu.</h2>
            <p>Gunakan akun yang sedang kamu pakai. Tidak perlu membuat akun baru.</p>
            <form class="writing-form" method="POST" action="{{ route('writers.register.store') }}">
                @csrf
                <div class="field">
                    <label for="author-name">Nama yang ditampilkan</label>
                    <input id="author-name" name="name" value="{{ old('name', $existingAccount->name) }}" maxlength="120" autocomplete="name" required>
                    @error('name')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <div class="field">
                    <label for="author-bio">Biografi penulis</label>
                    <textarea id="author-bio" name="bio" maxlength="1200" rows="5" placeholder="Ceritakan sedikit tentang dirimu dan hal yang kamu tulis..." required>{{ old('bio', $existingAccount->bio) }}</textarea>
                    <small>Biografi ini akan tampil bersama karya-karyamu.</small>
                    @error('bio')<small class="field-error">{{ $message }}</small>@enderror
                </div>
                <button class="button" type="submit">Aktifkan ruang tulis <span aria-hidden="true">↗</span></button>
            </form>
            <p class="auth-links"><a href="{{ route('dashboard.index') }}">← Kembali ke dashboard utama</a></p>
        </div>
    </section>
@endsection
