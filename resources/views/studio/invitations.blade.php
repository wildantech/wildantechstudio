@extends('layouts.app')

@section('title', 'Undangan Digital - WildanTech Studio')

@section('content')
    <section class="container page-intro reveal">
        <p class="eyebrow">Produk WildanTech</p>
        <h1 class="page-title">Satu undangan. Tautan personal untuk setiap tamu.</h1>
        <p>Bangun halaman acara, kelola daftar tamu, lalu bagikan undangan satu per satu lewat WhatsApp dengan nama dan tautan masing-masing.</p>
        <div class="hero-actions">
            @auth
                <a class="button" href="{{ route('dashboard.invitations.create') }}">Buat undangan</a>
            @else
                <a class="button" href="{{ route('register') }}">Buat akun dan mulai</a>
                <a class="button-quiet" href="{{ route('login') }}">Sudah punya akun</a>
            @endauth
        </div>
    </section>

    <section class="container section">
        <div class="section-heading"><div><p class="eyebrow">Cara kerja</p><h2>Dari daftar tamu ke konfirmasi.</h2></div></div>
        <div class="service-list">
            <article class="service-item"><p class="eyebrow">01 · Rancang</p><h3>Isi detail acara</h3><p>Tulis nama acara, rangkaian waktu, tempat, dan informasi yang ingin dibagikan.</p></article>
            <article class="service-item"><p class="eyebrow">02 · Kelola</p><h3>Tambah tamu</h3><p>Masukkan nama dan nomor WhatsApp. Setiap tamu mendapat tautan personal yang sulit ditebak.</p></article>
            <article class="service-item"><p class="eyebrow">03 · Bagikan</p><h3>Kirim satu per satu</h3><p>Tombol WhatsApp menyiapkan pesan dan tautan. Kamu tetap memeriksa lalu menekan tombol kirim di WhatsApp.</p></article>
            <article class="service-item"><p class="eyebrow">04 · Pantau</p><h3>Lihat RSVP</h3><p>Konfirmasi hadir, jumlah tamu, dan ucapan masuk ke dashboard undanganmu.</p></article>
        </div>
    </section>

    <section class="container section">
        <div class="callout">
            <div><p class="eyebrow">Dikerjakan bersama</p><h2>Ingin dibantu menyiapkan undangan?</h2><p>Kamu bisa mengelola data sendiri atau mengirim detailnya ke Wildan untuk dibantu pengisian awal.</p></div>
            <a class="button" href="https://wa.me/6281215430648?text=Halo%20WildanTech%2C%20saya%20ingin%20bertanya%20tentang%20undangan%20digital." target="_blank" rel="noopener noreferrer">Tanya lewat WhatsApp</a>
        </div>
    </section>
@endsection
