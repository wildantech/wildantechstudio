@extends('layouts.app')

@if ($writerLogin)
    @section('writing_mode', true)
    @section('title', 'Masuk Penulis - Ruang Baca')
@else
    @section('title', 'Masuk - WildanTech Studio')
@endif

@section('content')
    <section class="container auth-wrap">
        <div class="auth-panel">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <img src="{{ asset('images/logo.png') }}" alt="WildanTech" width="30" height="30" style="width:30px;height:30px;border-radius:50%;object-fit:contain;background:#ffffff;padding:2px;">
                <span style="font-size:12px;font-weight:800;letter-spacing:0.06em;color:#ffffff;">WILDANTECH</span>
            </div>
            <p class="eyebrow">{{ $writerLogin ? 'Ruang Baca · Area Penulis' : 'Area pelanggan' }}</p>
            <h1>{{ $writerLogin ? 'Lanjutkan ceritamu.' : 'Selamat datang kembali.' }}</h1>
            <p>{{ $writerLogin ? 'Masuk untuk mengelola draf dan menerbitkan tulisanmu.' : 'Masuk untuk mengelola undangan dan daftar tamumu.' }}</p>
            @include('partials.flash')
            <form class="auth-fields" method="POST" action="{{ route('login.store', $writerLogin ? ['area' => 'writer'] : []) }}">
                @csrf
                <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus></div>
                <div class="field"><label for="password">Kata sandi</label><input id="password" name="password" type="password" autocomplete="current-password" required></div>
                <label class="checkbox-field"><input type="checkbox" name="remember" value="1"><span>Ingat saya di perangkat ini</span></label>
                <button class="button" type="submit">{{ $writerLogin ? 'Masuk ke Studio Tulisan' : 'Masuk ke dashboard' }}</button>
            </form>
            @if ($writerLogin)
                <p class="auth-links">Belum punya ruang tulis? <a href="{{ route('writers.register') }}">Daftar sebagai penulis</a></p>
                <p class="auth-links"><a href="{{ route('readings.index') }}">← Kembali ke Ruang Baca</a></p>
            @else
                <p class="auth-links">Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai pelanggan</a></p>
                <p class="auth-links">Penulis? <a href="{{ route('writers.login') }}">Masuk ke Studio Tulisan</a></p>
            @endif
        </div>
    </section>
@endsection
