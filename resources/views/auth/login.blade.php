@extends('layouts.app')

@section('title', 'Masuk - WildanTech Studio')

@section('content')
    <section class="container auth-wrap">
        <div class="auth-panel">
            <p class="eyebrow">Area pelanggan</p>
            <h1>Selamat datang kembali.</h1>
            <p>Masuk untuk mengelola undangan dan daftar tamumu.</p>
            @include('partials.flash')
            <form class="auth-fields" method="POST" action="{{ route('login.store') }}">
                @csrf
                <div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus></div>
                <div class="field"><label for="password">Kata sandi</label><input id="password" name="password" type="password" autocomplete="current-password" required></div>
                <label class="checkbox-field"><input type="checkbox" name="remember" value="1"><span>Ingat saya di perangkat ini</span></label>
                <button class="button" type="submit">Masuk ke dashboard</button>
            </form>
            <p class="auth-links">Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai pelanggan</a></p>
        </div>
    </section>
@endsection
