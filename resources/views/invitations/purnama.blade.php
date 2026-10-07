<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#eadcc8">
    <title>{{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{color-scheme:light;--purnama-ink:#382b25;--purnama-brown:#583d31;--purnama-gold:#c4a46c;--purnama-paper:#fffaf0;--purnama-muted:#796d60}
        *{box-sizing:border-box}
        html{scroll-behavior:smooth;scroll-padding-top:65px}
        body.purnama-page{margin:0;background:#241a16;color:var(--purnama-ink);font-family:Georgia,'Times New Roman',serif}
        body.purnama-page.purnama-locked{height:100svh;overflow:hidden}
        .purnama-shell{width:min(100%,560px);margin:auto;overflow:hidden;background:var(--purnama-paper);box-shadow:0 0 0 1px #d5bb86}
        .purnama-section{position:relative;isolation:isolate;min-height:480px;padding:68px 24px;background:var(--purnama-paper);text-align:center;overflow:hidden}
        .purnama-section:before{position:absolute;z-index:-1;inset:0;content:"";opacity:.35;background:radial-gradient(ellipse at 0 0,transparent 0 40%,#c4a46c22 41% 42%,transparent 43%),radial-gradient(ellipse at 100% 100%,transparent 0 40%,#c4a46c22 41% 42%,transparent 43%);background-size:140px 170px}
        .purnama-cover{display:grid;place-items:center;min-height:100svh;padding:24px;background-image:linear-gradient(180deg,#2a1d18a8,#291b16b8),var(--purnama-cover-image,linear-gradient(145deg,#947d69,#382b25));background-position:center;background-size:cover;color:#fff8ed}
        .purnama-cover-card{width:min(100%,410px);padding:44px 24px;border:1px solid #ddc48d;border-radius:190px 190px 28px 28px;background:#3d2b24bd;box-shadow:0 18px 60px #0008;backdrop-filter:blur(3px)}
        .purnama-kicker{margin:0 0 12px;color:var(--purnama-gold);font-size:11px;font-weight:700;letter-spacing:.24em;text-transform:uppercase}
        .purnama-cover h1{margin:16px 0;font-size:clamp(36px,10vw,54px);font-weight:400;line-height:1.05}
        .purnama-cover h1 span{display:block;margin:6px;font-size:.55em;font-style:italic}
        .purnama-date{letter-spacing:.1em}
        .purnama-guest{margin:28px auto 22px;line-height:1.6}
        .purnama-button{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:0 22px;border:1px solid #d1b478;border-radius:24px;background:var(--purnama-gold);color:#fff;text-decoration:none;font-size:13px;font-weight:700;cursor:pointer}
        .purnama-button:hover{background:#a8874e}
        .purnama-main[hidden]{display:none}
        .purnama-main{animation:purnama-in .7s ease both}
        @keyframes purnama-in{from{opacity:0;transform:translateY(14px)}to{opacity:1;transform:none}}
        .purnama-nav{position:sticky;top:0;z-index:10;display:flex;gap:8px;overflow:auto;padding:12px;background:#fffaf0ed;border-bottom:1px solid #c4a46c66;backdrop-filter:blur(12px);scrollbar-width:none}
        .purnama-nav::-webkit-scrollbar{display:none}
        .purnama-nav a{flex:0 0 auto;padding:8px 11px;border:1px solid #c4a46c;border-radius:20px;color:var(--purnama-ink);text-decoration:none;font-size:11px}
        .purnama-section-title{margin:0 0 12px;font-size:clamp(31px,8vw,43px);font-weight:400;font-style:italic}
        .purnama-lead{max-width:390px;margin:0 auto 22px;color:var(--purnama-muted);font-size:14px;line-height:1.75}
        .purnama-countdown{display:flex;justify-content:center;gap:8px;margin:25px 0}
        .purnama-countdown div{display:grid;min-width:65px;padding:12px 8px;border:1px solid #c4a46c;border-radius:9px;background:#fffdf7}
        .purnama-countdown strong{font-size:23px;font-weight:400}.purnama-countdown span{margin-top:4px;color:var(--purnama-muted);font-size:10px}
        .purnama-couple{background:#f5eddf}
        .purnama-person{max-width:410px;margin:24px auto;padding:18px;border:1px solid #c4a46c;border-radius:150px 150px 20px 20px;background:#fffaf0;box-shadow:0 12px 30px #4b38201b}
        .purnama-person-photo{display:block;width:min(100%,260px);height:300px;margin:0 auto 18px;border:1px solid var(--purnama-gold);border-radius:140px 140px 12px 12px;object-fit:cover;object-position:center 30%}
        .purnama-monogram{display:grid;place-items:center;width:150px;height:150px;margin:20px auto;border:1px solid var(--purnama-gold);border-radius:50%;font-size:48px}
        .purnama-person h3{margin:8px;font-size:25px;font-weight:400;font-style:italic}
        .purnama-person p{margin:7px;color:var(--purnama-muted);font-size:13px;line-height:1.7}
        .purnama-instagram{display:inline-flex;margin:8px auto 4px}
        .purnama-event-list,.purnama-story-list,.purnama-gifts{display:grid;gap:14px;max-width:440px;margin:28px auto}
        .purnama-event,.purnama-story,.purnama-gift{padding:22px 18px;border:1px solid #c4a46c;border-radius:15px;background:#fffdf8;box-shadow:0 8px 22px #49342412}
        .purnama-event h3,.purnama-story h3{margin:4px 0 12px;font-size:21px;font-weight:400}
        .purnama-event p,.purnama-story p,.purnama-gift p{margin:8px 0;color:var(--purnama-muted);font-size:13px;line-height:1.7}
        .purnama-story{text-align:left}
        .purnama-gallery{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:9px;max-width:460px;margin:28px auto}
        .purnama-gallery img{display:block;width:100%;height:220px;border:1px solid #c4a46c;border-radius:12px;object-fit:cover}
        .purnama-gift strong,.purnama-gift span,.purnama-gift small{display:block;margin:7px}
        .purnama-gift span{font-size:19px;font-weight:700;letter-spacing:.04em}
        .purnama-gift small{color:var(--purnama-muted)}
        .purnama-gift button{padding:8px 14px;border:0;border-radius:20px;background:var(--purnama-brown);color:white;cursor:pointer}
        .purnama-form{max-width:440px;margin:16px auto;padding:18px;border:1px solid #c4a46c;border-radius:14px;background:#fffdf8;text-align:left}
        .purnama-form label{display:block;margin:0 0 7px;font-size:12px}
        .purnama-form input,.purnama-form textarea,.purnama-form select{display:block;width:100%;margin:0 0 13px;padding:12px;border:1px solid #cdbb9d;border-radius:7px;background:#fff;color:var(--purnama-ink);font:inherit;font-size:14px}
        .purnama-form textarea{min-height:95px;resize:vertical}.purnama-form input:disabled{color:var(--purnama-muted)}
        .purnama-wish{max-width:440px;margin:10px auto;padding:16px;border:1px solid #d8c69f;border-radius:12px;background:#fffdf8;text-align:left}
        .purnama-wish p{margin:8px 0 0;color:var(--purnama-muted);font-size:13px;line-height:1.65}
        .purnama-footer{display:grid;align-content:center;min-height:460px;background:linear-gradient(180deg,#583d31e8,#39261e),var(--purnama-footer-image,none) center/cover;color:#fff8ed}
        .purnama-footer .purnama-section-title{color:#f0d69f}
        .purnama-music{position:fixed;z-index:20;right:max(16px,calc((100vw - 560px)/2 + 16px));bottom:18px;width:44px;height:44px;border:1px solid #e0c88f;border-radius:50%;background:#583d31;color:white;font-size:18px;box-shadow:0 5px 18px #0006;cursor:pointer}
        .purnama-music.is-playing{animation:purnama-disc 5s linear infinite}
        @keyframes purnama-disc{to{transform:rotate(360deg)}}
        .purnama-reveal{opacity:0;transform:translateY(28px);transition:opacity .7s ease,transform .8s ease}
        .purnama-reveal.active{opacity:1;transform:none}
        @media(max-width:370px){.purnama-section{padding-right:18px;padding-left:18px}.purnama-countdown{gap:5px}.purnama-countdown div{min-width:58px}.purnama-gallery img{height:180px}}
        @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}.purnama-reveal{opacity:1;transform:none;transition:none}.purnama-music.is-playing{animation:none}}
    </style>
</head>
@php
    $purnamaFirstEvent = $invitation->events->first(fn ($event): bool => $event->starts_at !== null);
    $purnamaBrideName = $invitation->bride_nickname ?: $invitation->bride_name;
    $purnamaGroomName = $invitation->groom_nickname ?: $invitation->groom_name;
    $purnamaCoverImage = $invitation->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image) : ($invitation->gallery_images[0] ?? null ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->gallery_images[0]) : null);
    $purnamaGallery = array_values(array_filter(array_map(fn (?string $image): ?string => $image ? \Illuminate\Support\Facades\Storage::disk('public')->url($image) : null, $invitation->gallery_images ?? [])));
    $purnamaChildren = [1 => 'Pertama', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat', 5 => 'Kelima', 6 => 'Keenam', 7 => 'Ketujuh', 8 => 'Kedelapan', 9 => 'Kesembilan', 10 => 'Kesepuluh'];
@endphp
<body class="purnama-page purnama-locked">
<div class="purnama-shell">
    <section class="purnama-section purnama-cover" id="purnama-cover" @if ($purnamaCoverImage) style="--purnama-cover-image:url('{{ $purnamaCoverImage }}')" @endif>
        <div class="purnama-cover-card">
            <p class="purnama-kicker">The Wedding Of</p>
            <h1>{{ $purnamaBrideName }}<span>&amp;</span>{{ $purnamaGroomName }}</h1>
            @if ($purnamaFirstEvent?->starts_at)<p class="purnama-date">{{ $purnamaFirstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif
            <p class="purnama-guest">Kepada Yth.<br>{{ $guest->name }}<br>Dengan hormat, kami mengundang Anda ke hari bahagia kami.</p>
            <button class="purnama-button" id="purnama-open" type="button">Buka Undangan</button>
        </div>
    </section>
    <main class="purnama-main" id="purnama-main" hidden>
        <nav class="purnama-nav" aria-label="Navigasi undangan"><a href="#purnama-couple">Mempelai</a><a href="#purnama-events">Acara</a>@if (! empty($invitation->love_story))<a href="#purnama-story">Love Story</a>@endif @if ($purnamaGallery !== [])<a href="#purnama-gallery">Galeri</a>@endif @if ($invitation->gifts->isNotEmpty() || $invitation->gift_delivery_address)<a href="#purnama-gift">Wedding Gift</a>@endif<a href="#purnama-wishes">Ucapan</a></nav>
        @if ($purnamaFirstEvent?->starts_at)
            <section class="purnama-section" id="purnama-date"><p class="purnama-kicker purnama-reveal">Save The Date</p><h2 class="purnama-section-title purnama-reveal">Hari Bahagia</h2><p class="purnama-lead purnama-reveal">{{ $purnamaFirstEvent->starts_at->translatedFormat('l, d F Y') }}</p><div class="purnama-countdown purnama-reveal" data-purnama-countdown="{{ $purnamaFirstEvent->starts_at->format('Y-m-d\TH:i:s') }}"><div><strong data-days>00</strong><span>Hari</span></div><div><strong data-hours>00</strong><span>Jam</span></div><div><strong data-minutes>00</strong><span>Menit</span></div><div><strong data-seconds>00</strong><span>Detik</span></div></div></section>
        @endif
        <section class="purnama-section purnama-couple" id="purnama-couple"><p class="purnama-kicker purnama-reveal">KAMI YANG BERBAHAGIA</p><h2 class="purnama-section-title purnama-reveal">Kedua Mempelai</h2><p class="purnama-lead purnama-reveal">{{ $invitation->opening_text ?: 'Dengan memohon rahmat dan ridha Allah SWT, kami mengundang Anda untuk merayakan hari bahagia kami.' }}</p>
            <article class="purnama-person purnama-reveal">@if ($invitation->bride_photo)<img class="purnama-person-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}">@else<div class="purnama-monogram">{{ mb_substr($invitation->bride_name, 0, 1) }}</div>@endif<p class="purnama-kicker">Mempelai Putri</p><h3>{{ $invitation->bride_name }}</h3><p>Putri {{ $purnamaChildren[$invitation->bride_child_order] ?? '' }} dari<br>Bapak {{ $invitation->bride_father }} &amp; Ibu {{ $invitation->bride_mother }}</p>@if ($invitation->bride_instagram)<a class="purnama-button purnama-instagram" href="{{ $invitation->bride_instagram }}" target="_blank" rel="noopener">Instagram</a>@endif</article>
            <p class="purnama-section-title purnama-reveal">&amp;</p>
            <article class="purnama-person purnama-reveal">@if ($invitation->groom_photo)<img class="purnama-person-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}">@else<div class="purnama-monogram">{{ mb_substr($invitation->groom_name, 0, 1) }}</div>@endif<p class="purnama-kicker">Mempelai Putra</p><h3>{{ $invitation->groom_name }}</h3><p>Putra {{ $purnamaChildren[$invitation->groom_child_order] ?? '' }} dari<br>Bapak {{ $invitation->groom_father }} &amp; Ibu {{ $invitation->groom_mother }}</p>@if ($invitation->groom_instagram)<a class="purnama-button purnama-instagram" href="{{ $invitation->groom_instagram }}" target="_blank" rel="noopener">Instagram</a>@endif</article>
        </section>
        @if ($invitation->events->isNotEmpty())<section class="purnama-section" id="purnama-events"><p class="purnama-kicker purnama-reveal">Wedding Event</p><h2 class="purnama-section-title purnama-reveal">Acara Pernikahan</h2><div class="purnama-event-list">@foreach ($invitation->events as $event)<article class="purnama-event purnama-reveal"><h3>{{ $event->title }}</h3>@if ($event->starts_at)<p>{{ $event->starts_at->translatedFormat('l, d F Y') }}</p><p>{{ $event->starts_at->format('H:i') }} @if ($event->ends_at) – {{ $event->ends_at->format('H:i') }} @else – Selesai @endif WIB</p>@endif<p><strong>{{ $event->venue_name }}</strong>@if ($event->address)<br>{{ $event->address }}@endif</p>@if ($event->maps_url)<a class="purnama-button" href="{{ $event->maps_url }}" target="_blank" rel="noopener">Google Maps</a>@endif</article>@endforeach</div></section>@endif
        @if (! empty($invitation->love_story))<section class="purnama-section" id="purnama-story"><p class="purnama-kicker purnama-reveal">Our Journey</p><h2 class="purnama-section-title purnama-reveal">Love Story</h2><div class="purnama-story-list">@foreach ($invitation->love_story as $story)<article class="purnama-story purnama-reveal"><h3>{{ $story['title'] }} @if (! empty($story['date']))<small>· {{ $story['date'] }}</small>@endif</h3><p>{{ $story['description'] }}</p></article>@endforeach</div></section>@endif
        @if ($purnamaGallery !== [])<section class="purnama-section" id="purnama-gallery"><p class="purnama-kicker purnama-reveal">Momen Bahagia</p><h2 class="purnama-section-title purnama-reveal">Our Gallery</h2><div class="purnama-gallery">@foreach ($purnamaGallery as $image)<img class="purnama-reveal" loading="lazy" src="{{ $image }}" alt="Galeri {{ $invitation->bride_name }} dan {{ $invitation->groom_name }}">@endforeach</div></section>@endif
        @if ($invitation->livestream_url)<section class="purnama-section"><p class="purnama-kicker purnama-reveal">Saksikan bersama</p><h2 class="purnama-section-title purnama-reveal">Live Streaming</h2><p class="purnama-lead purnama-reveal">Ikuti momen bahagia kami secara virtual.</p><a class="purnama-button purnama-reveal" href="{{ $invitation->livestream_url }}" target="_blank" rel="noopener">Tonton Live</a></section>@endif
        @if ($invitation->gifts->isNotEmpty() || $invitation->gift_delivery_address || ($invitation->gift_bank_name && $invitation->gift_account_number))<section class="purnama-section" id="purnama-gift"><p class="purnama-kicker purnama-reveal">Tanda Kasih</p><h2 class="purnama-section-title purnama-reveal">Wedding Gift</h2><p class="purnama-lead purnama-reveal">Doa restu dan kehadiran Anda merupakan hadiah terindah bagi kami.</p><div class="purnama-gifts">@forelse ($invitation->gifts as $gift)<article class="purnama-gift purnama-reveal"><strong>{{ $gift->provider }}</strong><span>{{ $gift->account_number }}</span><small>a.n. {{ $gift->account_name }}</small><button type="button" data-purnama-copy="{{ $gift->account_number }}">Salin rekening</button></article>@empty @if ($invitation->gift_bank_name && $invitation->gift_account_number)<article class="purnama-gift purnama-reveal"><strong>{{ $invitation->gift_bank_name }}</strong><span>{{ $invitation->gift_account_number }}</span><small>a.n. {{ $invitation->gift_account_name }}</small><button type="button" data-purnama-copy="{{ $invitation->gift_account_number }}">Salin rekening</button></article>@endif @endforelse @if ($invitation->gift_delivery_address)<article class="purnama-gift purnama-reveal"><strong>Kirim Hadiah</strong><p>{{ $invitation->gift_delivery_address }}</p></article>@endif</div></section>@endif
        <section class="purnama-section" id="purnama-wishes"><p class="purnama-kicker purnama-reveal">Doa Untuk Pengantin</p><h2 class="purnama-section-title purnama-reveal">Ucapan &amp; Kehadiran</h2><p class="purnama-lead purnama-reveal">{{ $invitation->closing_text ?: 'Mohon doa dan ucapan terbaik untuk perjalanan baru kami.' }}</p><div class="purnama-lead purnama-reveal">{{ $invitation->attending_guests_count }} Hadir · {{ $invitation->declined_guests_count }} Tidak hadir</div>
            @if (session('rsvp_status'))<p role="status">{{ session('rsvp_status') }}</p>@endif<form class="purnama-form purnama-reveal" method="POST" action="{{ route('invitations.public.rsvp', [$invitation->slug, $guest->token]) }}">@csrf<label for="purnama-rsvp">Konfirmasi Kehadiran</label><select id="purnama-rsvp" name="rsvp_status" required><option value="">Pilih status</option><option value="attending" @selected(old('rsvp_status', $guest->rsvp_status) === 'attending')>Hadir</option><option value="declined" @selected(old('rsvp_status', $guest->rsvp_status) === 'declined')>Tidak hadir</option></select><label for="purnama-party-size">Jumlah tamu</label><select id="purnama-party-size" name="party_size"><option value="1">1 orang</option>@for ($count = 2; $count <= 10; $count++)<option value="{{ $count }}" @selected(old('party_size', $guest->party_size) == $count)>{{ $count }} orang</option>@endfor</select><button class="purnama-button" type="submit">Kirim</button></form>
            @if (session('wish_status'))<p role="status">{{ session('wish_status') }}</p>@endif<form class="purnama-form purnama-reveal" method="POST" action="{{ route('invitations.public.wishes.store', [$invitation->slug, $guest->token]) }}">@csrf<label for="purnama-wish-name">Nama Anda</label><input id="purnama-wish-name" value="{{ $guest->name }}" disabled><label for="purnama-message">Ucapan dan doa</label><textarea id="purnama-message" name="message" maxlength="600" required>{{ old('message') }}</textarea><button class="purnama-button" type="submit">Kirim Ucapan</button></form>@foreach ($invitation->wishes as $wish)<article class="purnama-wish purnama-reveal"><strong>{{ $wish->guest->name }}</strong><p>{{ $wish->message }}</p></article>@endforeach
        </section>
        <footer class="purnama-section purnama-footer" @if ($purnamaCoverImage) style="--purnama-footer-image:url('{{ $purnamaCoverImage }}')" @endif><p class="purnama-kicker">Terima Kasih</p><h2 class="purnama-section-title">{{ $purnamaBrideName }} &amp; {{ $purnamaGroomName }}</h2><p class="purnama-lead" style="color:#fff8ed">{{ $invitation->closing_text ?: 'Sampai jumpa di hari bahagia kami.' }}</p></footer>
    </main>
</div>
@if ($invitation->music_file)<audio id="purnama-song" loop preload="none" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file) }}"></audio><button class="purnama-music" id="purnama-music" type="button" aria-label="Putar musik">♫</button>@endif
<script>
    const purnamaOpen = document.querySelector('#purnama-open');
    const purnamaMain = document.querySelector('#purnama-main');
    const purnamaSong = document.querySelector('#purnama-song');
    const purnamaReveal = () => document.querySelectorAll('.purnama-reveal').forEach((item) => item.classList.toggle('active', item.getBoundingClientRect().top < innerHeight - 80));
    purnamaOpen?.addEventListener('click', async () => {
        purnamaMain.hidden = false;
        document.body.classList.remove('purnama-locked');
        document.querySelector('#purnama-cover')?.classList.add('purnama-cover-opened');
        document.querySelector('#purnama-date')?.scrollIntoView({ behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
        requestAnimationFrame(purnamaReveal);
        try { await purnamaSong?.play(); document.querySelector('#purnama-music')?.classList.add('is-playing'); } catch {}
    });
    window.addEventListener('scroll', purnamaReveal, { passive: true });
    const purnamaMusicButton = document.querySelector('#purnama-music');
    purnamaMusicButton?.addEventListener('click', async () => {
        if (purnamaSong.paused) { try { await purnamaSong.play(); purnamaMusicButton.classList.add('is-playing'); } catch {} }
        else { purnamaSong.pause(); purnamaMusicButton.classList.remove('is-playing'); }
    });
    document.querySelectorAll('[data-purnama-copy]').forEach((button) => button.addEventListener('click', async () => {
        try { await navigator.clipboard.writeText(button.dataset.purnamaCopy); button.textContent = 'Tersalin'; } catch { button.textContent = button.dataset.purnamaCopy; }
    }));
    const purnamaCountdown = document.querySelector('[data-purnama-countdown]');
    if (purnamaCountdown) {
        const target = new Date(purnamaCountdown.dataset.purnamaCountdown).getTime();
        const updatePurnamaCountdown = () => {
            let remaining = Math.max(0, target - Date.now());
            [['days', 86400000], ['hours', 3600000], ['minutes', 60000], ['seconds', 1000]].forEach(([unit, size]) => {
                const value = Math.floor(remaining / size); remaining %= size;
                purnamaCountdown.querySelector(`[data-${unit}]`).textContent = String(value).padStart(2, '0');
            });
        };
        updatePurnamaCountdown(); window.setInterval(updatePurnamaCountdown, 1000);
    }
</script>
</body>
</html>
