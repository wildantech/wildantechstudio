@php
    $firstEvent = $invitation->events->first(fn ($event): bool => $event->starts_at !== null);
    $photoUrl = fn (?string $photo): ?string => $photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($photo) : null;
    $bride = $invitation->bride_nickname ?: $invitation->bride_name;
    $groom = $invitation->groom_nickname ?: $invitation->groom_name;
    $gallery = array_values(array_filter(array_map($photoUrl, $invitation->gallery_images ?? [])));
    $cover = $photoUrl($invitation->cover_image) ?? $gallery[0] ?? $photoUrl($invitation->bride_photo) ?? $photoUrl($invitation->groom_photo);
    $closingPhoto = $gallery[1] ?? $cover;
    $musicUrl = $invitation->music_file
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file)
        : asset('images/asetttt/nikustory.mp3');
    $childrenOrder = [1 => 'pertama', 2 => 'kedua', 3 => 'ketiga', 4 => 'keempat', 5 => 'kelima', 6 => 'keenam', 7 => 'ketujuh', 8 => 'kedelapan', 9 => 'kesembilan', 10 => 'kesepuluh'];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#171717">
    <title>{{ $invitation->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    @include('invitations.niku-story-styles')
</head>
<body>
<div class="elementor elementor-6547" data-elementor-type="wp-post">
    <section class="elementor-element elementor-element-292e0416 e-flex e-con-boxed e-con e-parent" id="sec" style="--niku-cover: @if ($cover) url('{{ $cover }}') @else none @endif">
        <div class="e-con-inner">
            <div class="elementor-element elementor-element-3a2abc19 e-con-full e-flex e-con e-child" id="kolom">
                <div class="idb-reveal zoom-down elementor-element elementor-element-38c9939f elementor-widget elementor-widget-heading niku-reveal"><div class="elementor-widget-container"><h2 class="elementor-heading-title">The Wedding of</h2></div></div>
                <div class="idb-reveal zoom-down elementor-element elementor-element-1a08861e elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $bride }} &amp; {{ $groom }}</div></div>
                <div class="idb-reveal zoom-down elementor-element elementor-element-495c982d elementor-widget elementor-widget-heading niku-reveal"><div class="elementor-widget-container"><h2 class="elementor-heading-title">Dear</h2></div></div>
                <div class="idb-reveal zoom-down elementor-element elementor-element-47d3809c elementor-widget elementor-widget-heading niku-reveal"><div class="elementor-widget-container"><h2 class="elementor-heading-title">{{ $guest->name }}</h2></div></div>
                <div class="elementor-align-center elementor-element elementor-element-567c32f6 elementor-widget elementor-widget-button niku-reveal" id="open"><div class="elementor-widget-container"><div class="elementor-button-wrapper"><a class="elementor-button elementor-size-sm" href="#undangan" role="button"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Buka Undangan</span></span></a></div></div></div>
                <div class="elementor-element elementor-element-4dd3326f elementor-widget elementor-widget-spacer"><div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div></div>
            </div>
        </div>
    </section>

    <main id="undangan" class="niku-page-content niku-hidden">
        <section class="elementor-element elementor-element-762b36c1 e-flex e-con-boxed e-con e-parent">
            <div class="e-con-inner"><div class="elementor-element elementor-element-64838fb7 gradient-overlay e-con-full e-flex e-con e-child" style="--niku-hero: @if ($cover) url('{{ $cover }}') @else none @endif">
                <div class="idb-reveal zoom-down elementor-element elementor-element-68433e81 elementor-widget elementor-widget-heading niku-reveal"><div class="elementor-widget-container"><h2 class="elementor-heading-title">The Wedding of</h2></div></div>
                <div class="idb-reveal zoom-down elementor-element elementor-element-622c05f1 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $bride }}<br>&amp; {{ $groom }}</div></div>
                @if ($firstEvent)<div class="idb-reveal zoom-down elementor-element elementor-element-ebeb636 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $firstEvent->starts_at->format('d. m. Y') }}</div></div>@endif
                <div class="elementor-element elementor-element-48bf11c elementor-widget elementor-widget-spacer"><div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div></div>
                <div class="idb-reveal zoom-right elementor-element elementor-element-a89d7ab elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">“Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.”<br><br>QS. Ar-Rum: 21</div></div>
                <div class="idb-reveal elementor-element elementor-element-6fe1b24a elementor-widget elementor-widget-divider niku-reveal"><div class="elementor-widget-container"><div class="elementor-divider"><span class="elementor-divider-separator"></span></div></div></div>
            </div></div>
        </section>

        @if ($firstEvent)
        <section class="elementor-element elementor-element-50c4cac2 e-flex e-con-boxed e-con e-parent">
            <div class="e-con-inner"><div class="elementor-element elementor-element-1925b298 e-con-full e-flex e-con e-child"><div class="elementor-element elementor-element-5b1ddbeb e-con-full e-flex e-con e-child">
                <div class="idb-reveal elementor-element elementor-element-45bcd21 elementor-widget elementor-widget-heading niku-reveal"><div class="elementor-widget-container"><h2 class="elementor-heading-title">We’re Getting Married</h2></div></div>
                <div class="idb-reveal elementor-element elementor-element-6b890676 elementor-widget-divider niku-reveal"><div class="elementor-widget-container"><div class="elementor-divider"><span class="elementor-divider-separator"></span></div></div></div>
                <div class="idb-reveal elementor-element elementor-element-76a0bef2 elementor-widget elementor-widget-bisdev_countdown niku-reveal"><div class="elementor-widget-container"><div class="idb-countdown" data-countdown="{{ $firstEvent->starts_at->timestamp }}"><div class="idb-countdown__row"><div class="idb-countdown__item"><div class="idb-countdown__num" data-unit="days">00</div><div class="idb-countdown__label">Hari</div></div><div class="idb-countdown__item"><div class="idb-countdown__num" data-unit="hours">00</div><div class="idb-countdown__label">Jam</div></div><div class="idb-countdown__item"><div class="idb-countdown__num" data-unit="minutes">00</div><div class="idb-countdown__label">Menit</div></div><div class="idb-countdown__item"><div class="idb-countdown__num" data-unit="seconds">00</div><div class="idb-countdown__label">Detik</div></div></div></div></div></div>
                <div class="elementor-align-center elementor-element elementor-element-1f1666ee elementor-widget elementor-widget-button niku-reveal"><div class="elementor-widget-container"><div class="elementor-button-wrapper"><a class="elementor-button elementor-button-link elementor-size-sm" href="#acara"><span class="elementor-button-content-wrapper"><span class="elementor-button-text">Save The Date</span></span></a></div></div></div>
                @if ($cover)<div class="idb-reveal elementor-element elementor-element-4e8236f2 story elementor-widget elementor-widget-image niku-reveal"><div class="elementor-widget-container"><img src="{{ $cover }}" alt="Foto {{ $bride }} dan {{ $groom }}" loading="lazy"></div></div>@endif
            </div></div></div>
        </section>
        @endif

        <section class="elementor-element elementor-element-19f5923c e-flex e-con-boxed e-con e-parent" id="date"><div class="e-con-inner"><div class="elementor-element elementor-element-35a26632 e-con-full e-flex e-con e-child" style="--niku-profile-bg: @if ($cover) url('{{ $cover }}') @else none @endif">
            <div class="elementor-element elementor-element-7a5c3cf4 elementor-widget elementor-widget-spacer"><div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div></div>
            <div class="idb-reveal elementor-element elementor-element-4698f508 elementor-widget-divider niku-reveal"><div class="elementor-widget-container"><div class="elementor-divider"><span class="elementor-divider-separator"><span class="elementor-divider__text">The Bride &amp; The Groom</span></span></div></div></div>
            <div class="elementor-element elementor-element-b416d90 elementor-widget elementor-widget-spacer"><div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div></div>
            @if ($photoUrl($invitation->groom_photo))<article class="elementor-element elementor-element-6b00fe91 e-con-full e-flex e-con e-child"><div class="idb-reveal elementor-element elementor-element-df7b70 pp elementor-widget elementor-widget-image niku-reveal"><div class="elementor-widget-container"><img src="{{ $photoUrl($invitation->groom_photo) }}" alt="{{ $groom }}" loading="lazy"></div></div><div class="idb-reveal elementor-element elementor-element-49f1bce0 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $groom }}</div></div></article>@endif
            <div class="idb-reveal elementor-element elementor-element-3fc836e elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $invitation->groom_name }}</div></div>
            <div class="idb-reveal elementor-element elementor-element-2077a27e elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">Putra {{ $childrenOrder[$invitation->groom_child_order] ?? '' }} dari<br>Bapak {{ $invitation->groom_father }}<br>Ibu {{ $invitation->groom_mother }}</div></div>
            <div class="idb-reveal elementor-element elementor-element-7297e0bd elementor-widget-divider niku-reveal"><div class="elementor-widget-container"><div class="elementor-divider"><span class="elementor-divider-separator"><span class="elementor-divider__text">&amp;</span></span></div></div></div>
            @if ($photoUrl($invitation->bride_photo))<article class="elementor-element elementor-element-5306ba55 e-con-full e-flex e-con e-child"><div class="idb-reveal elementor-element elementor-element-1def2ccd pp elementor-widget elementor-widget-image niku-reveal"><div class="elementor-widget-container"><img src="{{ $photoUrl($invitation->bride_photo) }}" alt="{{ $bride }}" loading="lazy"></div></div><div class="idb-reveal elementor-element elementor-element-45ab1f68 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $bride }}</div></div></article>@endif
            <div class="idb-reveal elementor-element elementor-element-36a4a1c5 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $invitation->bride_name }}</div></div>
            <div class="idb-reveal elementor-element elementor-element-5cf29757 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">Putri {{ $childrenOrder[$invitation->bride_child_order] ?? '' }} dari<br>Bapak {{ $invitation->bride_father }}<br>Ibu {{ $invitation->bride_mother }}</div></div>
        </div></div></section>

        @if ($invitation->events->isNotEmpty())
        <section class="elementor-element elementor-element-3750f715 e-flex e-con-boxed e-con e-parent" id="acara"><div class="e-con-inner"><div class="elementor-element elementor-element-69661c2c e-con-full e-flex e-con e-child">
            <div class="elementor-element elementor-element-4af5003e elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Wedding</p></div></div><div class="elementor-element elementor-element-7832f4d3 elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Event</p></div></div>
            @foreach ($invitation->events as $event)
            @php($eventPhoto = $gallery[($loop->index + 1) % max(count($gallery), 1)] ?? $cover)
            <article class="elementor-element elementor-element-{{ $loop->first ? '5ba5a731' : '3eac6168' }} e-con-full acara-con e-flex e-con e-child"><div class="idb-reveal elementor-element elementor-element-{{ $loop->first ? '3db8d240' : '742f8103' }} e-con-full e-flex e-con e-child niku-event-photo" style="--event-photo: @if ($eventPhoto) url('{{ $eventPhoto }}') @else none @endif">
                <div class="elementor-element elementor-element-12b08276 elementor-widget elementor-widget-spacer"><div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div></div><div class="idb-reveal elementor-element elementor-element-4719179a elementor-widget elementor-widget-heading niku-reveal"><div class="elementor-widget-container"><h2 class="elementor-heading-title"><span>{{ $event->title }}</span></h2></div></div>
                                @if ($event->starts_at)
                    <div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container">{{ $event->starts_at->translatedFormat('l, d F Y') }}</div></div>
                    <div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container">{{ $event->starts_at->format('H:i') }} @if ($event->ends_at) – {{ $event->ends_at->format('H:i') }} @else – Selesai @endif WIB</div></div>
                @endif
                <div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><strong>{{ $event->venue_name }}</strong>@if ($event->address)<br>{{ $event->address }}@endif</div></div>@if ($event->maps_url)<div class="elementor-widget elementor-widget-button"><div class="elementor-widget-container"><a class="elementor-button" href="{{ $event->maps_url }}" target="_blank" rel="noopener noreferrer"><span class="elementor-button-text">Kunjungi Lokasi</span></a></div></div>@endif
            </div></article>
            @endforeach
        </div></div></section>
        @endif

        @if ($invitation->livestream_url)<section class="elementor-element elementor-element-39dc6f0d e-flex e-con-boxed e-con e-parent"><div class="e-con-inner"><div class="elementor-element elementor-element-68fdbb1c e-con-full e-flex e-con e-child"><div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Live Streaming</p></div></div><a class="elementor-button" href="{{ $invitation->livestream_url }}" target="_blank" rel="noopener noreferrer">Saksikan secara langsung</a></div></div></section>@endif
        @if (!empty($invitation->love_story))<section class="elementor-element elementor-element-39dc6f0d e-flex e-con-boxed e-con e-parent"><div class="e-con-inner"><div class="elementor-element elementor-element-68fdbb1c e-con-full e-flex e-con e-child"><div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Our Love Story</p></div></div><div class="idb-timeline">@foreach ($invitation->love_story as $story)<article class="niku-wish"><h3>{{ $story['title'] ?? '' }}</h3><p>{{ $story['description'] ?? '' }}</p></article>@endforeach</div></div></div></section>@endif

        @if ($gallery !== [])<section class="elementor-element elementor-element-39dc6f0d e-flex e-con-boxed e-con e-parent"><div class="e-con-inner"><div class="elementor-element elementor-element-68fdbb1c e-con-full e-flex e-con e-child niku-gallery"><div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Gallery</p></div></div><div class="elementor-element elementor-element-7cc9684c elementor-widget elementor-widget-gallery"><div class="elementor-widget-container"><div class="elementor-gallery__container">@foreach ($gallery as $photo)<a class="e-gallery-item elementor-gallery-item niku-gallery-open" href="{{ $photo }}" data-photo="{{ $photo }}" aria-label="Lihat foto {{ $loop->iteration }}"><div class="e-gallery-image elementor-gallery-item__image" style="background-image:url('{{ $photo }}')" role="img" aria-label="Foto {{ $bride }} dan {{ $groom }}"></div><div class="elementor-gallery-item__overlay"></div></a>@endforeach</div></div></div></div></div></section>@endif

        @if ($invitation->gifts->isNotEmpty() || $invitation->gift_delivery_address || ($invitation->gift_bank_name && $invitation->gift_account_number))<section class="elementor-element elementor-element-6380e40d e-flex e-con-boxed e-con e-parent"><div class="e-con-inner"><div class="elementor-element elementor-element-1423fe96 e-con-full e-flex e-con e-child"><div class="elementor-element elementor-element-74e11a5b amplop-section e-con-full e-flex e-con e-child"><div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Amplop Digital</p><p>Doa restu dan kehadiran Anda adalah hadiah terbaik bagi kami.</p></div></div><button class="elementor-button niku-gift-open" id="niku-gift-open" type="button">Kirim Hadiah</button><div class="elementor-element elementor-element-1d2c31 e-con-full e-flex e-con e-child" id="amplop" role="dialog" aria-modal="true" aria-label="Detail hadiah"><button class="niku-gift-close" id="niku-gift-close" type="button" aria-label="Tutup">×</button>
            @forelse ($invitation->gifts as $gift)<article class="idb-copy-rek idb-copy-rek--auto is-stack"><div class="idb-copy-rek__box"><div class="idb-copy-rek__info"><div class="idb-copy-rek__label"><strong>{{ $gift->provider }}</strong></div><div class="idb-copy-rek__number"><span class="idb-copy-rek__numtext">{{ $gift->account_number }}</span></div><div class="idb-copy-rek__name">{{ $gift->account_name }}</div></div><button class="niku-gift-copy" type="button" data-copy="{{ $gift->account_number }}">Salin rekening</button><span class="idb-copy-rek__toast" aria-live="polite"></span></div></article>@empty @if ($invitation->gift_bank_name && $invitation->gift_account_number)<article class="idb-copy-rek idb-copy-rek--auto is-stack"><div class="idb-copy-rek__box"><div class="idb-copy-rek__info"><div class="idb-copy-rek__label"><strong>{{ $invitation->gift_bank_name }}</strong></div><div class="idb-copy-rek__number"><span class="idb-copy-rek__numtext">{{ $invitation->gift_account_number }}</span></div><div class="idb-copy-rek__name">{{ $invitation->gift_account_name }}</div></div><button class="niku-gift-copy" type="button" data-copy="{{ $invitation->gift_account_number }}">Salin rekening</button></div></article>@endif @endforelse
            @if ($invitation->gift_delivery_address)<article class="idb-copy-rek idb-copy-rek--auto is-stack"><div class="idb-copy-rek__box"><div class="idb-copy-rek__info"><div class="idb-copy-rek__label"><strong>Alamat Pengiriman Kado</strong></div><div class="idb-copy-rek__name">{{ $invitation->gift_delivery_address }}</div></div></div></article>@endif
        </div></div></div></div></section>@endif

        <section class="elementor-element elementor-element-6380e40d e-flex e-con-boxed e-con e-parent" id="ucapan"><div class="e-con-inner"><div class="elementor-element elementor-element-2b5e53b e-con-full e-flex e-con e-child"><div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container"><p>Ucapkan Sesuatu</p><p>Doa dan ucapan terbaik untuk kedua mempelai.</p></div></div><div class="niku-rsvp-local rsvp-card">
            @if (session('rsvp_status'))<p role="status">{{ session('rsvp_status') }}</p>@endif
            <form method="POST" action="{{ route('invitations.public.rsvp', [$invitation->slug, $guest->token]) }}">@csrf<label for="niku-rsvp-status">Konfirmasi Kehadiran</label><select id="niku-rsvp-status" name="rsvp_status" required><option value="">Pilih konfirmasi</option><option value="attending" @selected($guest->rsvp_status === 'attending')>Hadir</option><option value="declined" @selected($guest->rsvp_status === 'declined')>Tidak hadir</option></select><label for="niku-party-size">Jumlah tamu</label><select id="niku-party-size" name="party_size">@for ($count = 1; $count <= 10; $count++)<option value="{{ $count }}" @selected((int) $guest->party_size === $count)>{{ $count }} orang</option>@endfor</select><button type="submit">Kirim RSVP</button></form>
            @if (session('wish_status'))<p role="status">{{ session('wish_status') }}</p>@endif
            <form method="POST" action="{{ route('invitations.public.wishes.store', [$invitation->slug, $guest->token]) }}">@csrf<label for="niku-wish-name">Nama</label><input id="niku-wish-name" value="{{ $guest->name }}" readonly><label for="niku-wish-message">Ucapan / Doa</label><textarea id="niku-wish-message" name="message" maxlength="1000" placeholder="Tuliskan ucapan atau doa" required>{{ old('message') }}</textarea><button type="submit">Kirim Ucapan</button></form>
            <div class="rsvp-list">@foreach ($invitation->wishes as $wish)<article class="niku-wish"><strong>{{ $wish->guest->name }}</strong><p>{{ $wish->message }}</p></article>@endforeach</div>
        </div></div></div></section>

        <section class="elementor-element elementor-element-5173f81 e-flex e-con-boxed e-con e-parent"><div class="e-con-inner"><div class="elementor-element elementor-element-2cf05624 e-con-full e-flex e-con e-child"><div class="idb-reveal elementor-element elementor-element-257d1fa9 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container"><p>{{ $invitation->closing_text ?: 'Merupakan suatu kebahagiaan dan kehormatan bagi kami apabila Anda berkenan hadir dan memberikan doa restu kepada kami.' }}</p></div></div><div class="idb-reveal elementor-element elementor-element-492d7f4 elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">Kami yang berbahagia,</div></div><div class="idb-reveal elementor-element elementor-element-43ca936a elementor-widget elementor-widget-text-editor niku-reveal"><div class="elementor-widget-container">{{ $bride }} &amp; {{ $groom }}</div></div></div><div class="elementor-element elementor-element-329eefad e-con-full e-flex e-con e-child" style="--niku-closing: @if ($closingPhoto) url('{{ $closingPhoto }}') @else none @endif"><div class="elementor-element elementor-element-43c73f33 elementor-widget elementor-widget-spacer"><div class="elementor-widget-container"><div class="elementor-spacer"><div class="elementor-spacer-inner"></div></div></div></div></div></div></section>
        <footer class="elementor-element elementor-element-64be67a2 e-flex e-con-boxed e-con e-parent"><div class="e-con-inner"><div class="elementor-element elementor-element-1d5ee45b e-con-full e-flex e-con e-child"><div class="elementor-widget elementor-widget-text-editor"><div class="elementor-widget-container">{{ $bride }} &amp; {{ $groom }}</div></div></div></div></footer>
    </main>
</div>
<audio id="niku-music" loop preload="none" src="{{ $musicUrl }}"></audio>
<button class="niku-music-button" id="niku-music-toggle" type="button" aria-label="Putar musik">♪</button>
<div class="niku-lightbox" id="niku-lightbox" role="dialog" aria-modal="true" aria-label="Foto galeri"><button type="button" aria-label="Tutup">×</button><img alt=""></div>
<script>
(() => {
    const cover = document.getElementById('sec');
    const openButton = document.querySelector('#open a');
    const content = document.getElementById('undangan');
    const audio = document.getElementById('niku-music');
    openButton?.addEventListener('click', (event) => {
        event.preventDefault();
        if (!cover || !content) return;
        content.classList.remove('niku-hidden');
        cover.classList.add('niku-hidden');
        document.documentElement.style.scrollBehavior = 'smooth';
        audio?.play().catch(() => {});
    });
    document.getElementById('niku-music-toggle')?.addEventListener('click', async (event) => {
        const button = event.currentTarget;
        if (!audio) return;
        if (audio.paused) { await audio.play(); button.setAttribute('aria-label', 'Jeda musik'); }
        else { audio.pause(); button.setAttribute('aria-label', 'Putar musik'); }
    });
    const giftLayer = document.getElementById('niku-gift-open') ? document.getElementById('amplop') : null;
    document.getElementById('niku-gift-open')?.addEventListener('click', () => giftLayer?.classList.add('is-open'));
    const closeGiftLayer = () => giftLayer?.classList.remove('is-open');
    document.getElementById('niku-gift-close')?.addEventListener('click', closeGiftLayer);
    giftLayer?.addEventListener('click', (event) => { if (event.target === giftLayer) closeGiftLayer(); });    document.querySelectorAll('[data-countdown]').forEach((clock) => {
        const target = Number(clock.dataset.countdown) * 1000;
        const tick = () => {
            const distance = Math.max(0, target - Date.now());
            const values = { days: Math.floor(distance / 86400000), hours: Math.floor(distance / 3600000) % 24, minutes: Math.floor(distance / 60000) % 60, seconds: Math.floor(distance / 1000) % 60 };
            Object.entries(values).forEach(([unit, value]) => { const output = clock.querySelector(`[data-unit="${unit}"]`); if (output) output.textContent = String(value).padStart(2, '0'); });
        };
        tick(); window.setInterval(tick, 1000);
    });
    document.querySelectorAll('[data-copy]').forEach((button) => button.addEventListener('click', async () => {
        const account = button.dataset.copy || '';
        try { await navigator.clipboard.writeText(account); button.textContent = 'Tersalin'; }
        catch { button.textContent = account; }
    }));
    const lightbox = document.getElementById('niku-lightbox');
    const lightboxImage = lightbox?.querySelector('img');
    const closeLightbox = () => lightbox?.classList.remove('is-open');
    document.querySelectorAll('[data-photo]').forEach((item) => item.addEventListener('click', (event) => {
        event.preventDefault();
        if (!lightbox || !lightboxImage) return;
        lightboxImage.src = item.dataset.photo || '';
        lightboxImage.alt = item.getAttribute('aria-label') || 'Foto galeri';
        lightbox.classList.add('is-open');
    }));
    lightbox?.querySelector('button')?.addEventListener('click', closeLightbox);
    lightbox?.addEventListener('click', (event) => { if (event.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeLightbox(); });
    const revealItems = document.querySelectorAll('.niku-reveal');
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => entries.forEach((entry) => { if (entry.isIntersecting) { entry.target.classList.add('is-visible'); observer.unobserve(entry.target); } }), { threshold: 0.12 });
        revealItems.forEach((item) => observer.observe(item));
    } else { revealItems.forEach((item) => item.classList.add('is-visible')); }
})();
</script>
</body>
</html>