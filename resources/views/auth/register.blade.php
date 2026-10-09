@extends('layouts.app')

@section('title', 'Buat akun - WildanTech Studio')

@section('content')
    <section class="container auth-wrap">
        <div class="auth-panel">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <img src="{{ asset('images/logo.png') }}" alt="WildanTech" width="30" height="30" style="width:30px;height:30px;border-radius:50%;object-fit:contain;background:#ffffff;padding:2px;">
                <span style="font-size:12px;font-weight:800;letter-spacing:0.06em;color:#ffffff;">WILDANTECH</span>
            </div>
            <p class="eyebrow">Mulai undanganmu</p>
            <h1>Buat akun pelanggan.</h1>
            <p>Kelola detail acara dan kirim undangan personal dari satu dashboard.</p>
            @include('partials.flash')
            <form class="auth-fields" method="POST" action="{{ route('register.store') }}">
                @csrf
                <div class="field"><label for="name">Nama</label><input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required></div>
                <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required></div>
                <div class="field"><label for="password">Kata sandi</label><input id="password" name="password" type="password" autocomplete="new-password" required><small>Minimal 10 karakter.</small></div>
                <div class="field"><label for="password_confirmation">Ulangi kata sandi</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required></div>
                <label class="checkbox-field"><input type="checkbox" name="terms" value="1" required><span>Saya memahami bahwa data daftar tamu hanya digunakan untuk mengelola undangan ini.</span></label>
                <button class="button" type="submit">Buat akun</button>
            </form>
            <p class="auth-links">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </div>
    </section>
@endsection
