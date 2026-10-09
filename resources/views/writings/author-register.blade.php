@extends('layouts.app')

@section('writing_mode', true)
@section('title', 'Buka Ruang Tulis - WildanTech Studio')

@section('content')
    <section class="container author-onboarding">
        <div class="author-onboarding-aside"><p class="eyebrow">Selamat datang, penulis</p><h1>Karyamu layak<br>punya <em>ruang.</em></h1><p>Tuliskan siapa dirimu, lalu bagikan artikel, buku, atau puisi dengan caramu sendiri.</p><div class="author-profile-preview"><span class="author-monogram">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(old('name', 'P'), 0, 1)) }}</span><div><strong>{{ old('name', 'Nama penulis') }}</strong><small>{{ old('bio', 'Biografi singkatmu akan tampil bersama karya.') }}</small></div></div></div>
        <div class="author-onboarding-form">
            <p class="eyebrow">Profil penulis</p><h2>Buka ruang tulismu.</h2><p>Profil ini akan menemani setiap karya yang kamu terbitkan.</p>
            <form class="writing-form" method="POST" action="{{ route('writers.register.store') }}">
                @csrf
                <div class="field"><label for="author-name">Nama yang ditampilkan</label><input id="author-name" name="name" value="{{ old('name') }}" maxlength="120" autocomplete="name" required>@error('name')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="author-email">Email</label><input id="author-email" name="email" type="email" value="{{ old('email') }}" maxlength="190" autocomplete="email" required>@error('email')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="author-bio">Biografi</label><textarea id="author-bio" name="bio" maxlength="1200" rows="4" placeholder="Ceritakan sedikit tentang dirimu dan hal yang kamu tulis..." required>{{ old('bio') }}</textarea><small>Biografi ini ditampilkan di halaman karya.</small>@error('bio')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="form-grid">
                    <div class="field"><label for="author-password">Kata sandi</label><input id="author-password" name="password" type="password" autocomplete="new-password" required><small>Minimal 10 karakter.</small>@error('password')<small class="field-error">{{ $message }}</small>@enderror</div>
                    <div class="field"><label for="author-password-confirmation">Ulangi kata sandi</label><input id="author-password-confirmation" name="password_confirmation" type="password" autocomplete="new-password" required></div>
                </div>
                <button class="button" type="submit">Buat ruang penulis <span aria-hidden="true">↗</span></button>
            </form>
            <p class="auth-links">Sudah punya akun? <a href="{{ route('writers.login') }}">Masuk sebagai penulis</a></p>
        </div>
    </section>
@endsection
