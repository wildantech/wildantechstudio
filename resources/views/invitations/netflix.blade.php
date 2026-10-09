<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#090909">
    <title>{{ $invitation->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{color-scheme:dark;--nf-red:#e50914;--nf-black:#090909;--nf-panel:#181818;--nf-white:#f5f5f1;--nf-muted:#aaa}
        *{box-sizing:border-box}
        html{scroll-behavior:smooth;scroll-padding-top:70px}
        body.nf-page{margin:0;background:var(--nf-black);color:var(--nf-white);font-family:Arial,Helvetica,sans-serif}
        body.nf-page.nf-locked{height:100svh;overflow:hidden}
        .nf-shell{width:min(100%,560px);margin:auto;background:var(--nf-black);overflow:hidden;box-shadow:0 0 0 1px #ffffff18}
        .nf-section{position:relative;isolation:isolate;min-height:480px;padding:76px 25px;background:#090909;color:var(--nf-white);text-align:center;overflow:hidden}
        .nf-cover{display:grid;place-items:center;min-height:100svh;padding:30px 22px;background-image:linear-gradient(180deg,#07070754 0%,#090909c9 67%,#090909 100%),var(--nf-cover-image,none);background-position:center;background-size:cover}
        .nf-cover:before{position:absolute;inset:0;z-index:-1;content:"";background:radial-gradient(ellipse at 50% 35%,#8b101752,transparent 60%),linear-gradient(90deg,#0009,transparent 50%,#0009)}
        .nf-cover-content{width:min(100%,410px);padding:44px 23px 38px;border:1px solid #ffffff22;background:#080808b5;box-shadow:0 18px 70px #0009;backdrop-filter:blur(4px)}
        .nf-wordmark{margin:0;color:var(--nf-red);font-weight:900;font-size:clamp(35px,10vw,58px);line-height:.9;letter-spacing:.16em;text-shadow:0 2px 18px #000}
        .nf-wordmark span{display:block;margin-top:11px;color:#fff;font-size:12px;letter-spacing:.5em}
        .nf-cover-names{margin:34px 0 12px;font-family:Georgia,'Times New Roman',serif;font-size:clamp(34px,9vw,56px);font-weight:400;line-height:1.02;text-shadow:0 3px 12px #000}
        .nf-cover-date{margin:0 0 26px;color:#ddd;font-size:14px;letter-spacing:.1em}
        .nf-cover-guest{margin:0 auto 24px;color:#d7d7d7;font-size:13px;line-height:1.6}
        .nf-button{display:inline-flex;align-items:center;justify-content:center;min-height:43px;padding:0 22px;border:0;border-radius:3px;background:var(--nf-red);color:white;font-weight:700;font-size:13px;text-decoration:none;cursor:pointer;transition:background .2s,transform .2s}
        .nf-button:hover{background:#bd0710;transform:translateY(-1px)}
        .nf-open{min-width:172px;gap:9px}
        .nf-face{position:relative;width:180px;height:76px;margin:26px auto 5px}
        .nf-eye-pair{position:absolute;top:0;left:50%;width:107px;height:18px;transform:translateX(-50%)}
        .nf-mouth{position:absolute;top:39px;left:50%;width:63px;height:13px;transform:translateX(-50%)}
        .nf-mouth-left{animation:nf-mouth-left 2.5s linear infinite}
        .nf-mouth-right{animation:nf-mouth-right 2.5s linear infinite}
        @keyframes nf-mouth-left{0%,100%{translate:0 0}50%{translate:-20px 0}}
        @keyframes nf-mouth-right{0%,100%{translate:0 0}50%{translate:20px 0}}
        .nf-cover.is-opening .nf-cover-content{animation:nf-cover-exit .55s ease forwards}
        .nf-cover.is-opening #nf-open{display:none}
        @keyframes nf-cover-exit{to{opacity:0;transform:scale(.96)}}
        .nf-main[hidden]{display:none}
        .nf-main{animation:nf-main-in .8s ease both}
        @keyframes nf-main-in{from{opacity:0}to{opacity:1}}
        .nf-opening{display:grid;align-content:center;min-height:100svh;padding-top:92px;background-image:radial-gradient(ellipse at 50% 5%,#6b080e66,transparent 58%),linear-gradient(180deg,#111 0%,#090909 58%)}
        .nf-opening .nf-wordmark{font-size:35px}
        .nf-opening h1{max-width:430px;margin:28px auto 12px;font-family:Georgia,'Times New Roman',serif;font-size:clamp(36px,10vw,58px);font-weight:400;line-height:1.04}
        .nf-eyebrow{margin:0 0 12px;color:#ef3941;font-size:11px;font-weight:700;letter-spacing:.22em;text-transform:uppercase}
        .nf-lead{max-width:390px;margin:0 auto 24px;color:#c8c8c8;font-size:14px;line-height:1.75}
        .nf-nav{position:sticky;top:0;z-index:10;display:flex;justify-content:center;gap:7px;overflow:auto;padding:12px 10px;background:#111e;border-bottom:1px solid #ffffff16;backdrop-filter:blur(14px);scrollbar-width:none}
        .nf-nav::-webkit-scrollbar{display:none}
        .nf-nav a{flex:0 0 auto;padding:8px 10px;border:1px solid #ffffff1c;border-radius:3px;color:#dedede;text-decoration:none;font-size:10px;font-weight:bold}
        .nf-nav a:hover{border-color:var(--nf-red);color:white}
        .nf-section-title{margin:0 0 9px;font-family:Georgia,'Times New Roman',serif;font-size:clamp(32px,8vw,45px);font-weight:400;line-height:1.08}
        .nf-title-tag{display:inline-block;margin-right:5px;padding:4px 7px;border-radius:3px;background:var(--nf-red);font-family:Arial,Helvetica,sans-serif;font-size:.36em;font-weight:700;letter-spacing:.02em;vertical-align:middle}
        .nf-subtitle{margin:0 0 30px;color:var(--nf-muted);font-size:13px;line-height:1.6}
        .nf-couple{padding-top:84px;background:linear-gradient(180deg,#141414,#090909)}
        .nf-person{max-width:410px;margin:24px auto 38px;padding:16px 16px 23px;border:1px solid #ffffff18;border-radius:5px;background:linear-gradient(150deg,#202020,#111);box-shadow:0 15px 40px #0009}
        .nf-person-photo{display:block;width:min(100%,340px);height:320px;object-fit:cover;object-position:center 32%;margin:0 auto 18px;border-radius:3px;background:#222}
        .nf-person-monogram{display:grid;place-items:center;width:146px;height:146px;margin:0 auto 18px;border:1px solid #ffffff20;border-radius:50%;background:radial-gradient(circle at 50% 35%,#8f171f,#251214 64%,#141414);color:#fff;font-family:Georgia,serif;font-size:48px}
        .nf-person h3{margin:7px 0 9px;font-family:Georgia,'Times New Roman',serif;font-size:27px;font-weight:400}
        .nf-person p{margin:0;color:#c9c9c9;font-size:13px;line-height:1.7}
        .nf-person a{display:inline-flex;margin-top:15px}
        .nf-and{margin:0;color:var(--nf-red);font-family:Georgia,serif;font-size:38px}
        .nf-countdown{display:flex;justify-content:center;gap:9px;margin:25px 0}
        .nf-countdown div{display:grid;min-width:64px;padding:12px 7px;border:1px solid #ffffff22;border-radius:3px;background:#141414}
        .nf-countdown strong{color:#fff;font-size:24px;font-weight:700}.nf-countdown span{margin-top:3px;color:#aaa;font-size:9px;font-weight:700;letter-spacing:.12em;text-transform:uppercase}
        .nf-event-grid{display:grid;gap:14px;max-width:450px;margin:30px auto}
        .nf-event{padding:22px 18px;border:1px solid #ffffff1c;border-left:4px solid var(--nf-red);border-radius:4px;background:linear-gradient(145deg,#1c1c1c,#111);text-align:left}
        .nf-event h3{margin:7px 0 12px;font-size:21px}.nf-event p{margin:8px 0;color:#c8c8c8;font-size:13px;line-height:1.65}
        .nf-event .nf-button{margin-top:7px}
        .nf-story-list{max-width:440px;margin:30px auto;text-align:left}
        .nf-story{position:relative;margin:0 0 14px;padding:19px;border:1px solid #ffffff19;border-radius:4px;background:#161616}
        .nf-story:before{position:absolute;top:0;bottom:0;left:0;width:3px;background:var(--nf-red);content:""}
        .nf-story h3{margin:0 0 8px;font-size:18px}.nf-story p{margin:0;color:#c5c5c5;font-size:13px;line-height:1.7}
        .nf-gallery{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;max-width:450px;margin:28px auto}
        .nf-gallery button{display:block;width:100%;padding:0;border:1px solid #ffffff20;border-radius:3px;background:#111;overflow:hidden;cursor:pointer}
        .nf-gallery img{display:block;width:100%;aspect-ratio:3/4;object-fit:cover;transition:transform .5s ease}
        .nf-gallery button:hover img{transform:scale(1.04)}
        .nf-gifts{display:grid;gap:12px;max-width:420px;margin:24px auto}
        .nf-gift{padding:20px;border:1px solid #ffffff21;border-radius:4px;background:#161616}
        .nf-gift strong,.nf-gift span,.nf-gift small{display:block;margin:6px}
        .nf-gift strong{color:#fff;font-size:14px}.nf-gift span{font-size:19px;font-weight:bold;letter-spacing:.06em}.nf-gift small{color:#aaa}
        .nf-gift button{margin-top:9px;padding:9px 15px;border:0;border-radius:3px;background:#333;color:white;cursor:pointer}
        .nf-wish-count{display:flex;justify-content:center;gap:10px;margin:22px 0}
        .nf-wish-count span{min-width:125px;padding:12px;border:1px solid #ffffff20;border-radius:3px;background:#171717;color:#bbb;font-size:12px}
        .nf-wish-count strong{display:block;margin-bottom:3px;color:white;font-size:20px}
        .nf-form{max-width:440px;margin:16px auto;padding:18px;border:1px solid #ffffff1d;border-radius:4px;background:#151515;text-align:left}
        .nf-form label{display:block;margin:0 0 7px;color:#c9c9c9;font-size:12px}
        .nf-form input,.nf-form textarea,.nf-form select{display:block;width:100%;margin:0 0 13px;padding:12px;border:1px solid #444;border-radius:3px;background:#090909;color:white;font-size:14px}
        .nf-form textarea{min-height:95px;resize:vertical}.nf-form input:disabled{color:#aaa}
        .nf-wish{max-width:440px;margin:10px auto;padding:15px;border:1px solid #ffffff18;border-radius:4px;background:#141414;text-align:left}
        .nf-wish-head{display:flex;align-items:center;gap:10px}
        .nf-wish-avatar{width:34px;height:34px;border-radius:50%;object-fit:cover;background:#444}
        .nf-wish strong{font-size:13px}.nf-wish p{margin:7px 0 0;color:#c5c5c5;font-size:13px;line-height:1.6}
        .nf-lightbox{width:min(92vw,760px);max-width:none;max-height:90vh;padding:38px 10px 10px;border:1px solid #ffffff30;background:#111}
        .nf-lightbox::backdrop{background:#000e;backdrop-filter:blur(4px)}
        .nf-lightbox img{display:block;max-width:100%;max-height:82vh;margin:auto;object-fit:contain}
        .nf-lightbox button{position:absolute;top:5px;right:9px;border:0;background:none;color:white;font-size:28px;cursor:pointer}
        .nf-footer{display:grid;align-content:center;min-height:380px;background:radial-gradient(ellipse at 50% 100%,#7a080e44,transparent 62%),#090909}
        .nf-footer h2{margin:16px 0;font-family:Georgia,serif;font-size:34px;font-weight:400}
        .nf-music{position:fixed;z-index:20;right:max(16px,calc((100vw - 560px)/2 + 16px));bottom:18px;width:46px;height:46px;border:1px solid #ffffff30;border-radius:50%;background:#151515;color:white;font-size:18px;box-shadow:0 5px 22px #0009;cursor:pointer}
        .nf-music.is-playing{border-color:#e50914;color:#ff353d;animation:nf-disc 5s linear infinite}
        @keyframes nf-disc{to{transform:rotate(360deg)}}
        .nf-reveal{position:relative;opacity:0;transform:translateY(6rem) scale(.93);transition:opacity .5s ease,transform 1s ease}
        .nf-reveal.active{transform:translateY(0);opacity:1}
        .nf-reveal-left{position:relative;opacity:0;transform:translateX(-100%) scale(.93);transition:opacity .5s ease,transform 1s ease}
        .nf-reveal-left.active{transform:translateX(0);opacity:1}
        .nf-reveal-right{position:relative;opacity:0;transform:translateX(100%) scale(.93);transition:opacity .5s ease,transform 1s ease}
        .nf-reveal-right.active{transform:translateX(0);opacity:1}
        .nf-reveal-zoom{position:relative;opacity:0;transform:scale(.5);transition:opacity .5s ease,transform 1.5s ease}
        .nf-reveal-zoom.active{transform:scale(1);opacity:1}
        @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}.nf-face img,.nf-music.is-playing{animation:none}.nf-reveal,.nf-reveal-left,.nf-reveal-right,.nf-reveal-zoom{opacity:1;transform:none;transition:none}}
    </style>
</head>
<body class="nf-page nf-locked">
@php
    $nfAsset = fn (string $file) => asset('images/asetttt/netflix/'.$file);
    $nfFirstEvent = $invitation->events->first(fn ($event): bool => $event->starts_at !== null);
    $nfChildren = [1 => 'pertama', 2 => 'kedua', 3 => 'ketiga', 4 => 'keempat', 5 => 'kelima', 6 => 'keenam', 7 => 'ketujuh', 8 => 'kedelapan', 9 => 'kesembilan', 10 => 'kesepuluh'];
    $nfBanks = ['bca' => 'bca.webp', 'bni' => 'bni.webp', 'bri' => 'bri.png', 'bsi' => 'bsi.webp', 'btn' => 'btn.webp', 'dana' => 'dana.webp', 'gopay' => 'gopay.webp', 'mandiri' => 'mandiri.webp', 'ovo' => 'ovo.webp', 'seabank' => 'seabank.webp', 'shopeepay' => 'shopeepay.webp'];
    $nfCoverImage = $invitation->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image) : (($invitation->gallery_images[0] ?? null) ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->gallery_images[0]) : ($invitation->bride_photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) : ($invitation->groom_photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) : null)));
@endphp
<div class="nf-shell">
    <section class="nf-section nf-cover" id="nf-cover" @if ($nfCoverImage) style="--nf-cover-image:url('{{ $nfCoverImage }}')" @endif>
        <div class="nf-cover-content">
            <p class="nf-wordmark">NETFLIX<span>THE WEDDING</span></p>
            <div class="nf-face" aria-hidden="true"><img class="nf-eye-pair" src="{{ $nfAsset('01-eyes-1.svg') }}" alt=""><img class="nf-mouth nf-mouth-left" src="{{ $nfAsset('02-mouth-1.svg') }}" alt=""><img class="nf-mouth nf-mouth-right" src="{{ $nfAsset('02-mouth-1.svg') }}" alt=""></div>
            <h1 class="nf-cover-names">{{ $invitation->bride_name }}<br><span>&amp;</span><br>{{ $invitation->groom_name }}</h1>
            @if ($nfFirstEvent)<p class="nf-cover-date">{{ $nfFirstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif
            <p class="nf-cover-guest">Kepada Yth. {{ $guest->name }}<br>Dengan hormat, kami mengundang Anda untuk hadir di hari istimewa kami.</p>
            <button class="nf-button nf-open" id="nf-open" type="button"><span aria-hidden="true">▶</span> Buka Undangan</button>
        </div>
    </section>

    <main class="nf-main" id="nf-main" hidden>
        <section class="nf-section nf-opening" id="nf-opening">
            <p class="nf-wordmark nf-reveal-left">NETFLIX<span>THE WEDDING</span></p>
            <p class="nf-eyebrow nf-reveal">Sebuah kisah tentang cinta</p>
            <h1 class="nf-reveal-left">{{ $invitation->bride_name }}<br><span style="color:var(--nf-red)">&amp;</span><br>{{ $invitation->groom_name }}</h1>
            @if ($nfFirstEvent)<p class="nf-lead nf-reveal">{{ $nfFirstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif
            <p class="nf-lead nf-reveal">{{ $invitation->opening_text ?: 'Kami akan memulai lembaran baru, dan ingin Anda menjadi bagian dari hari istimewa kami.' }}</p>
            <a class="nf-button nf-reveal" href="#nf-couple">Mulai Menonton</a>
        </section>
        <nav class="nf-nav" aria-label="Navigasi undangan"><a href="#nf-couple">Pasangan</a><a href="#nf-events">Acara</a>@if (! empty($invitation->love_story))<a href="#nf-story">Love Story</a>@endif @if ($invitation->gallery_images)<a href="#nf-gallery">Galeri</a>@endif @if ($invitation->gifts->isNotEmpty() || $invitation->gift_account_number)<a href="#nf-gift">Gift</a>@endif<a href="#nf-wishes">Ucapan</a></nav>

        <section class="nf-section nf-couple" id="nf-couple">
            <p class="nf-eyebrow nf-reveal">Happy Couple</p><h2 class="nf-section-title nf-reveal">Kedua Mempelai</h2>
            <article class="nf-person nf-reveal-left">
                @if ($invitation->bride_photo)<img class="nf-person-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}">@else<div class="nf-person-monogram">{{ mb_substr($invitation->bride_name, 0, 1) }}</div>@endif
                <p class="nf-eyebrow">The bride</p><h3>{{ $invitation->bride_name }}</h3><p>Putri {{ $nfChildren[$invitation->bride_child_order] ?? '' }} dari<br>Bapak {{ $invitation->bride_father }} &amp; Ibu {{ $invitation->bride_mother }}</p>
                @if ($invitation->bride_instagram)<a class="nf-button" href="{{ $invitation->bride_instagram }}" target="_blank" rel="noopener">Instagram</a>@endif
            </article>
            <div class="nf-and nf-reveal">&amp;</div>
            <article class="nf-person nf-reveal-right">
                @if ($invitation->groom_photo)<img class="nf-person-photo" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}">@else<div class="nf-person-monogram">{{ mb_substr($invitation->groom_name, 0, 1) }}</div>@endif
                <p class="nf-eyebrow">The groom</p><h3>{{ $invitation->groom_name }}</h3><p>Putra {{ $nfChildren[$invitation->groom_child_order] ?? '' }} dari<br>Bapak {{ $invitation->groom_father }} &amp; Ibu {{ $invitation->groom_mother }}</p>
                @if ($invitation->groom_instagram)<a class="nf-button" href="{{ $invitation->groom_instagram }}" target="_blank" rel="noopener">Instagram</a>@endif
            </article>
        </section>

        @if ($nfFirstEvent)
            <section class="nf-section" id="nf-date"><p class="nf-eyebrow nf-reveal">Save The Date</p><h2 class="nf-section-title nf-reveal-zoom">Hari Pernikahan</h2><p class="nf-lead nf-reveal">{{ $nfFirstEvent->starts_at?->translatedFormat('l, d F Y') }}</p><div class="nf-countdown nf-reveal" data-nf-countdown="{{ $nfFirstEvent->starts_at?->format('Y-m-d\TH:i:s') }}"><div><strong data-days>00</strong><span>Hari</span></div><div><strong data-hours>00</strong><span>Jam</span></div><div><strong data-minutes>00</strong><span>Menit</span></div><div><strong data-seconds>00</strong><span>Detik</span></div></div></section>
        @endif

        @if ($invitation->events->isNotEmpty())
            <section class="nf-section" id="nf-events"><p class="nf-eyebrow nf-reveal">Date &amp; Location</p><h2 class="nf-section-title nf-reveal">Rangkaian Acara</h2><p class="nf-subtitle nf-reveal">Yang akan dilaksanakan pada:</p><div class="nf-event-grid">
                @foreach ($invitation->events as $event)
                    <article class="nf-event {{ $loop->odd ? 'nf-reveal-left' : 'nf-reveal-right' }}">
                        <p class="nf-eyebrow">Acara {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</p>
                        <h3>{{ $event->title }}</h3>
                        @if ($event->starts_at)<p>{{ $event->starts_at->translatedFormat('l, d F Y') }}</p>@endif
                        <p>@if ($event->starts_at){{ $event->starts_at->format('H:i') }}@endif @if ($event->ends_at)– {{ $event->ends_at->format('H:i') }}@endif WIB</p>
                        <p><strong>{{ $event->venue_name }}</strong>@if ($event->address)<br>{{ $event->address }}@endif</p>
                        @if ($event->maps_url)<a class="nf-button" href="{{ $event->maps_url }}" target="_blank" rel="noopener">Buka Maps</a>@endif
                    </article>
                @endforeach
            </div></section>
        @endif

        @if ($invitation->livestream_url)<section class="nf-section"><p class="nf-eyebrow nf-reveal">Watch together</p><h2 class="nf-section-title nf-reveal">Live Streaming</h2><p class="nf-lead nf-reveal">Temui kami secara virtual untuk menyaksikan acara pernikahan melalui tautan berikut.</p><a class="nf-button nf-reveal" href="{{ $invitation->livestream_url }}" target="_blank" rel="noopener">Tonton Live</a></section>@endif

        @if (! empty($invitation->love_story))
            <section class="nf-section" id="nf-story"><p class="nf-eyebrow nf-reveal">Our Journey</p><h2 class="nf-section-title nf-reveal">Our Love Story</h2><div class="nf-story-list">@foreach ($invitation->love_story as $story)<article class="nf-story nf-reveal"><h3>{{ $story['title'] }} @if (! empty($story['date']))<small style="color:#999">· {{ $story['date'] }}</small>@endif</h3><p>{{ $story['description'] }}</p></article>@endforeach</div></section>
        @endif

        @if ($invitation->gallery_images)
            <section class="nf-section" id="nf-gallery"><p class="nf-eyebrow nf-reveal">Our Moments</p><h2 class="nf-section-title nf-reveal">Wedding Gallery</h2><div class="nf-gallery">@foreach ($invitation->gallery_images as $image)<button class="nf-reveal-zoom" type="button" aria-label="Foto {{ $loop->iteration }}"><img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}" alt="Momen {{ $loop->iteration }} {{ $invitation->bride_name }} dan {{ $invitation->groom_name }}"></button>@endforeach</div></section>
        @endif

        @if ($invitation->gifts->isNotEmpty() || ($invitation->gift_bank_name && $invitation->gift_account_number) || $invitation->gift_delivery_address)
            <section class="nf-section" id="nf-gift"><p class="nf-eyebrow nf-reveal">Wedding Gift</p><h2 class="nf-section-title nf-reveal">Tanda Kasih</h2><p class="nf-lead nf-reveal">{{ $invitation->gift_delivery_address ? 'Kehadiran Anda adalah hadiah terbaik. Jika berkenan, tanda kasih dapat dikirimkan melalui pilihan berikut.' : 'Kehadiran dan doa Anda merupakan hadiah terbaik bagi kami.' }}</p><div class="nf-gifts">
                @forelse ($invitation->gifts as $gift)@php($provider = strtolower(str_replace(' ', '', $gift->provider)))<article class="nf-gift nf-reveal"><p class="nf-eyebrow">Cashless gift</p><strong>{{ $gift->provider }}</strong><span>{{ $gift->account_number }}</span><small>a.n. {{ $gift->account_name }}</small><button type="button" data-nf-copy="{{ $gift->account_number }}">Salin nomor rekening</button></article>@empty
                    @if ($invitation->gift_bank_name && $invitation->gift_account_number)<article class="nf-gift nf-reveal"><p class="nf-eyebrow">Cashless gift</p><strong>{{ $invitation->gift_bank_name }}</strong><span>{{ $invitation->gift_account_number }}</span><small>a.n. {{ $invitation->gift_account_name }}</small><button type="button" data-nf-copy="{{ $invitation->gift_account_number }}">Salin nomor rekening</button></article>@endif
                @endforelse
                @if ($invitation->gift_delivery_address)<article class="nf-gift nf-reveal"><p class="nf-eyebrow">Send a gift</p><strong>Alamat pengiriman</strong><span style="font-size:14px;letter-spacing:0">{{ $invitation->gift_delivery_address }}</span></article>@endif
            </div></section>
        @endif

        <section class="nf-section" id="nf-wishes"><p class="nf-eyebrow nf-reveal">Wedding Wish</p><h2 class="nf-section-title nf-reveal">Ucapan &amp; Doa</h2><p class="nf-subtitle nf-reveal">Beri doa dan ucapan terbaikmu untuk kami.</p><div class="nf-wish-count nf-reveal"><span><strong>{{ $invitation->attending_guests_count }}</strong>Hadir</span><span><strong>{{ $invitation->declined_guests_count }}</strong>Tidak hadir</span></div>
            @if (session('rsvp_status'))<p role="status">{{ session('rsvp_status') }}</p>@endif
            <form class="nf-form nf-reveal" method="POST" action="{{ route('invitations.public.rsvp', [$invitation->slug, $guest->token]) }}">@csrf<label for="nf-rsvp">Konfirmasi Kehadiran</label><select id="nf-rsvp" name="rsvp_status" required><option value="">Pilih status kehadiran</option><option value="attending" @selected(old('rsvp_status', $guest->rsvp_status) === 'attending')>Hadir</option><option value="declined" @selected(old('rsvp_status', $guest->rsvp_status) === 'declined')>Tidak hadir</option></select><label for="nf-party-size">Jumlah tamu</label><select id="nf-party-size" name="party_size"><option value="1">1 orang</option>@for ($count = 2; $count <= 10; $count++)<option value="{{ $count }}" @selected(old('party_size', $guest->party_size) == $count)>{{ $count }} orang</option>@endfor</select><button class="nf-button" type="submit">Kirim Konfirmasi</button></form>
            @if (session('wish_status'))<p role="status">{{ session('wish_status') }}</p>@endif
            <form class="nf-form nf-reveal" method="POST" action="{{ route('invitations.public.wishes.store', [$invitation->slug, $guest->token]) }}">@csrf<label for="nf-wish-name">Nama Anda</label><input id="nf-wish-name" value="{{ $guest->name }}" disabled><label for="nf-message">Tulis Ucapan</label><textarea id="nf-message" name="message" maxlength="600" placeholder="Tuliskan doa terbaik Anda..." required>{{ old('message') }}</textarea><button class="nf-button" type="submit">Kirim Ucapan</button></form>
            @foreach ($invitation->wishes as $wish)<article class="nf-wish nf-reveal"><div class="nf-wish-head"><img class="nf-wish-avatar" src="{{ $nfAsset('user-ucapan.png') }}" alt=""><strong>{{ $wish->guest->name }}</strong></div><p>{{ $wish->message }}</p></article>@endforeach
        </section>

        <footer class="nf-section nf-footer"><p class="nf-wordmark nf-reveal-zoom" style="font-size:34px">NETFLIX<span>THE WEDDING</span></p><p class="nf-eyebrow nf-reveal">End credits</p><p class="nf-lead nf-reveal">{{ $invitation->closing_text ?: 'Terima kasih telah menjadi bagian dari cerita kami. Sampai jumpa di hari bahagia.' }}</p><h2 class="nf-reveal">{{ $invitation->bride_name }} &amp; {{ $invitation->groom_name }}</h2></footer>
    </main>
</div>
<dialog class="nf-lightbox" id="nf-lightbox"><button type="button" aria-label="Tutup">×</button><img alt="Foto galeri"></dialog>
@if ($invitation->music_file)<audio id="nf-song" loop preload="none" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file) }}"></audio><button class="nf-music" id="nf-music-toggle" type="button" aria-label="Putar musik">♫</button>@endif
<script>
    const nfOpenButton = document.querySelector('#nf-open');
    const nfCover = document.querySelector('#nf-cover');
    const nfMain = document.querySelector('#nf-main');
    const nfSong = document.querySelector('#nf-song');
    const nfMotionSafe = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const nfUpdateReveals = () => {
        const viewportHeight = window.innerHeight;
        document.querySelectorAll('.nf-reveal, .nf-reveal-left, .nf-reveal-right, .nf-reveal-zoom').forEach((element) => {
            const elementTop = element.getBoundingClientRect().top;
            element.classList.toggle('active', elementTop < viewportHeight - 150);
        });
    };
    nfOpenButton?.addEventListener('click', async () => {
        nfCover.classList.add('is-opening');
        nfOpenButton.disabled = true;
        document.body.classList.remove('nf-locked');
        window.setTimeout(() => {
            nfMain.hidden = false;
            nfMain.querySelector('#nf-opening').scrollIntoView({ behavior: nfMotionSafe ? 'auto' : 'smooth' });
            window.requestAnimationFrame(nfUpdateReveals);
        }, nfMotionSafe ? 0 : 350);
        if (nfSong) {
            try { await nfSong.play(); document.querySelector('#nf-music-toggle')?.classList.add('is-playing'); } catch {}
        }
    });
    window.addEventListener('scroll', nfUpdateReveals, { passive: true });
    const nfMusicButton = document.querySelector('#nf-music-toggle');
    nfMusicButton?.addEventListener('click', async () => {
        if (nfSong.paused) {
            try { await nfSong.play(); nfMusicButton.classList.add('is-playing'); nfMusicButton.setAttribute('aria-label', 'Jeda musik'); } catch {}
        } else {
            nfSong.pause(); nfMusicButton.classList.remove('is-playing'); nfMusicButton.setAttribute('aria-label', 'Putar musik');
        }
    });
    let nfWasPlaying = false;
    document.addEventListener('visibilitychange', () => {
        if (!nfSong) return;
        if (document.hidden && !nfSong.paused) { nfWasPlaying = true; nfSong.pause(); }
        else if (!document.hidden && nfWasPlaying) {
            nfWasPlaying = false;
            nfSong.play().then(() => nfMusicButton?.classList.add('is-playing')).catch(() => {});
        }
    });
    document.querySelectorAll('[data-nf-copy]').forEach((button) => button.addEventListener('click', async () => {
        try { await navigator.clipboard.writeText(button.dataset.nfCopy); button.textContent = 'Tersalin'; } catch { button.textContent = button.dataset.nfCopy; }
    }));
    const nfLightbox = document.querySelector('#nf-lightbox');
    const nfLightboxImage = nfLightbox?.querySelector('img');
    document.querySelectorAll('.nf-gallery button').forEach((button) => button.addEventListener('click', () => {
        nfLightboxImage.src = button.querySelector('img').src;
        nfLightbox.showModal();
    }));
    nfLightbox?.querySelector('button')?.addEventListener('click', () => nfLightbox.close());
    nfLightbox?.addEventListener('click', (event) => {
        if (event.target === nfLightbox) nfLightbox.close();
    });
    const nfCountdown = document.querySelector('[data-nf-countdown]');
    if (nfCountdown) {
        const target = new Date(nfCountdown.dataset.nfCountdown).getTime();
        const update = () => {
            let remaining = Math.max(0, target - Date.now());
            [['days', 86400000], ['hours', 3600000], ['minutes', 60000], ['seconds', 1000]].forEach(([unit, size]) => {
                const value = Math.floor(remaining / size);
                remaining %= size;
                nfCountdown.querySelector(`[data-${unit}]`).textContent = String(value).padStart(2, '0');
            });
        };
        update(); window.setInterval(update, 1000);
    }
</script>
</body>
</html>
