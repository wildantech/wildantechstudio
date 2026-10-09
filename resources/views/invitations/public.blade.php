@if ($invitation->theme === 'zaki-zahro')
    @include('invitations.zaki-zahro')
@elseif ($invitation->theme === 'midnight-moon')
    @include('invitations.midnight-moon-reference')
@elseif ($invitation->theme === 'jawa')
    @include('invitations.jawa-reference')
@elseif ($invitation->theme === 'netflix')
    @include('invitations.netflix-reference')
@elseif ($invitation->theme === 'purnama')
    @include('invitations.purnama')
@elseif ($invitation->theme === 'niku-story')
    @include('invitations.niku-story-reference')
@else
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="{{ $invitation->theme === 'lavender' ? '#000000' : '#f3eee5' }}">
    <title>{{ $invitation->title }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="invitation-page invitation-long theme-{{ $invitation->theme }}" style="--theme-stage: {{ $invitation->theme === 'lavender' ? 'none' : "url('".asset('images/aset/'.str_replace(' ', '%20', match ($invitation->theme) { 'indigo' => 'dekorasi gapura1.png', 'wine' => 'dekorasi gapura2.png', 'coastal' => 'dekor belakang gapura 3.png', default => 'dekorasi bunga tinggi.png' }))."')" }}">
    @php($firstEvent = $invitation->events->first(fn ($event): bool => $event->starts_at !== null))
    @php($artwork = match ($invitation->theme) {
        'indigo' => ['bride' => 'wanita jawa 2.png', 'groom' => 'pria jawa 2.png', 'couple' => 'pria wanita jawa 2.png', 'ornament' => 'bunga sudut 2.png', 'foliage' => 'daun dekor sudut.png'],
        'wine' => ['bride' => 'wanita jawa 1.png', 'groom' => 'pria jawa 1.png', 'couple' => 'jawa baju hitam suami sitri.png', 'ornament' => 'ornamen bunga.png', 'foliage' => 'kepang melati.png'],
        'coastal' => ['bride' => 'wanita melayu.png', 'groom' => 'pria melayu.png', 'couple' => 'pasangan islam 2.png', 'ornament' => 'rumput sudut.png', 'foliage' => 'daun dekor sudut.png'],
        'lavender' => ['bride' => 'islam istri.png', 'groom' => 'islam suami.png', 'couple' => 'islam suami istri.png', 'ornament' => 'bunga sudut 2.png', 'foliage' => 'daun dekor sudut.png'],
        default => ['bride' => 'islam istri.png', 'groom' => 'islam suami.png', 'couple' => 'islam suami istri.png', 'ornament' => 'bunga sudut.png', 'foliage' => 'dekor sudut daun dan bunga.png'],
    })
    @php($artUrl = fn (string $file) => asset('images/aset/'.str_replace(' ', '%20', $file)))
    @php($childOrderWords = [1 => 'pertama', 2 => 'kedua', 3 => 'ketiga', 4 => 'keempat', 5 => 'kelima', 6 => 'keenam', 7 => 'ketujuh', 8 => 'kedelapan', 9 => 'kesembilan', 10 => 'kesepuluh'])
    @php($bankLogos = ['bca' => ['BCA', 'bca.webp'], 'bni' => ['BNI', 'bni.webp'], 'bri' => ['BRI', 'bri.png'], 'bsi' => ['BSI', 'bsi.webp'], 'btn' => ['BTN', 'btn.webp'], 'dana' => ['DANA', 'dana.webp'], 'gopay' => ['GoPay', 'gopay.webp'], 'mandiri' => ['Mandiri', 'mandiri.webp'], 'ovo' => ['OVO', 'ovo.webp'], 'seabank' => ['SeaBank', 'seabank.webp'], 'shopeepay' => ['ShopeePay', 'shopeepay.webp']])
    @if ($invitation->music_file)
        <audio id="invite-music" loop preload="none" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file) }}"></audio>
        <button class="music-toggle" id="music-toggle" type="button" aria-pressed="false" aria-label="Putar musik latar">
            @if ($invitation->theme === 'lavender')
                <svg class="music-control-icon" viewBox="0 0 48 48" aria-hidden="true">
                    <path class="music-pause-icon" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm-16 328c0 8.8-7.2 16-16 16h-48c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v160zm112 0c0 8.8-7.2 16-16 16h-48c-8.8 0-16-7.2-16-16V176c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v160z" fill="currentColor" />
                    <path class="music-disc-icon" d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zM88 256H56c0-105.9 86.1-192 192-192v32c-88.2 0-160 71.8-160 160zm160 96c-53 0-96-43-96-96s43-96 96-96 96 43 96 96-43 96-96 96zm0-128c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32z" fill="currentColor" />
                </svg>
            @else
                <span class="music-record" aria-hidden="true"></span>
            @endif
        </button>
    @endif

    <section class="invitation-cover" id="invitation-cover" style="--hero-image: {{ $invitation->theme === 'lavender' ? 'none' : ($invitation->cover_image ? "url('".\Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image)."')" : 'var(--theme-stage)') }}">
            @if ($invitation->theme === 'lavender')
                <div class="night-sky" aria-hidden="true">
                    <span class="night-moon"></span>
                    <span class="night-window-stripes"></span>
                </div>
                <img class="night-flower night-flower-cover-left" src="{{ asset('images/aset/bunga-malam.svg') }}" alt="" aria-hidden="true">
                <img class="night-flower night-flower-cover-right" src="{{ asset('images/aset/bunga-malam.svg') }}" alt="" aria-hidden="true">
            @endif
            <div class="hero-wash"></div>
            @if ($invitation->theme !== 'lavender')
                <img class="cover-flower cover-flower-left" src="{{ $artUrl($artwork['ornament']) }}" alt="" aria-hidden="true">
                <img class="cover-flower cover-flower-right" src="{{ $artUrl($artwork['ornament']) }}" alt="" aria-hidden="true">
            @endif
            <div class="hero-copy">
                <p class="invite-kicker">{{ $invitation->theme === 'lavender' ? 'Save the Date' : 'The Wedding Of' }}</p>
                <h1>{{ $invitation->bride_name }} <span>&amp;</span> {{ $invitation->groom_name }}</h1>
                @if ($firstEvent)<p class="hero-date">{{ $firstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif
                <p class="guest-greeting">Kepada {{ $guest->name }}<br />Dengan penuh kebahagiaan, kami mengundang Anda.</p>
                @if ($invitation->theme !== 'lavender')
                    <img class="cover-couple" src="{{ $artUrl($artwork['couple']) }}" alt="Ilustrasi kedua mempelai">
                @endif
                <button class="invite-cta" id="open-invitation" type="button">Buka Undangan <span aria-hidden="true">↓</span></button>
            </div>
    </section>

    <main class="invite-card invite-long-card" id="invite-content" style="--invite-ornament: url('{{ $artUrl($artwork['ornament']) }}')" hidden>
        <header class="long-hero" style="--hero-image: {{ $invitation->theme === 'lavender' ? 'none' : ($invitation->cover_image ? "url('".\Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image)."')" : 'var(--theme-stage)') }}">
            <div class="hero-wash"></div><div class="hero-copy"><p class="invite-kicker">The Wedding Of</p><h1 tabindex="-1">{{ $invitation->bride_name }} <span>&amp;</span> {{ $invitation->groom_name }}</h1>@if ($firstEvent)<p class="hero-date">{{ $firstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif</div>
        </header>
        <div class="invite-body long-body" id="undangan">
            @if ($firstEvent)
                <section class="countdown-section" data-reveal>
                    <p class="invite-kicker">Menuju hari bahagia</p>
                    <div class="countdown" data-countdown="{{ $firstEvent->starts_at->format('Y-m-d\TH:i:s') }}">
                        <div><strong data-days>00</strong><span>Hari</span></div>
                        <div><strong data-hours>00</strong><span>Jam</span></div>
                        <div><strong data-minutes>00</strong><span>Menit</span></div>
                        <div><strong data-seconds>00</strong><span>Detik</span></div>
                    </div>
                </section>
            @endif

            @if ($invitation->opening_text)<p class="invite-opening long-opening" data-reveal>{{ $invitation->opening_text }}</p>@endif

            <section class="invite-verse long-verse" data-reveal>
                <p class="verse-arabic" lang="ar" dir="rtl">وَمِنْ اٰيٰتِهٖٓ اَنْ خَلَقَ لَكُمْ مِّنْ اَنْفُسِكُمْ اَزْوَاجًا لِّتَسْكُنُوْٓا اِلَيْهَا وَجَعَلَ بَيْنَكُمْ مَّوَدَّةً وَّرَحْمَةًۗ اِنَّ فِيْ ذٰلِكَ لَاٰيٰتٍ لِّقَوْمٍ يَّتَفَكَّرُوْنَ</p>
                <p>“Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.”</p>
                <small>QS. Ar-Rum: 21</small>
            </section>

            <section class="couple-section" id="pasangan" data-reveal style="--couple-flower: url('{{ $artUrl($artwork['ornament']) }}'); --couple-foliage: url('{{ $artUrl($artwork['foliage']) }}');">
                <p class="invite-kicker">Dengan memohon rahmat Allah</p>
                <h2>Merayakan sebuah janji</h2>
                <div class="couple-grid">
                    <article class="person-card person-bride">
                        @if ($invitation->bride_photo)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) }}" alt="{{ $invitation->bride_name }}">@else<img src="{{ $artUrl($artwork['bride']) }}" alt="Ilustrasi pengantin putri">@endif
                        <h3>{{ $invitation->bride_name }}</h3>
                        <p>Putri {{ $childOrderWords[$invitation->bride_child_order] ?? '' }} dari<br />Bapak {{ $invitation->bride_father }}<br />&amp; Ibu {{ $invitation->bride_mother }}</p>
                    </article>
                    <span class="couple-and" aria-hidden="true">&amp;</span>
                    <article class="person-card person-groom">
                        @if ($invitation->groom_photo)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) }}" alt="{{ $invitation->groom_name }}">@else<img src="{{ $artUrl($artwork['groom']) }}" alt="Ilustrasi pengantin putra">@endif
                        <h3>{{ $invitation->groom_name }}</h3>
                        <p>Putra {{ $childOrderWords[$invitation->groom_child_order] ?? '' }} dari<br />Bapak {{ $invitation->groom_father }}<br />&amp; Ibu {{ $invitation->groom_mother }}</p>
                    </article>
                </div>
            </section>

            <section class="events-section" id="acara" data-reveal>
                @if ($invitation->theme === 'lavender')
                    <div class="moon-background" aria-hidden="true"></div>
                @endif
                <p class="invite-kicker">Catat tanggalnya</p>
                <h2>Rangkaian Acara</h2>
                <div class="event-stack">
                    @foreach ($invitation->events as $event)
                        <article class="long-event-card">
                            <span class="event-index">0{{ $loop->iteration }}</span>
                            <div>@if ($event->starts_at)<p class="invite-kicker">{{ $event->starts_at->translatedFormat('l, d F Y') }}</p>@endif<h3>{{ $event->title }}</h3>
                                <p class="event-time">
                                    @if ($event->starts_at){{ $event->starts_at->format('H:i') }}@endif
                                    @if ($event->ends_at) – {{ $event->ends_at->format('H:i') }}@endif WIB
                                </p>
                                <p><strong>{{ $event->venue_name }}</strong>@if ($event->address)<br />{{ $event->address }}@endif</p>
                                @if ($event->maps_url)<a class="invite-cta" href="{{ $event->maps_url }}" target="_blank" rel="noopener noreferrer">Buka lokasi ↗</a>@endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            @if ($invitation->gallery_images)
                <section class="gallery-section" id="galeri" data-reveal>
                    <p class="invite-kicker">Potongan cerita kami</p><h2>Galeri</h2>
                    <div class="invite-gallery">@foreach ($invitation->gallery_images as $image)<figure><button type="button" class="gallery-open" aria-label="Perbesar foto {{ $loop->iteration }}"><img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}" alt="Foto kenangan {{ $invitation->bride_name }} dan {{ $invitation->groom_name }}"></button></figure>@endforeach</div>
                </section>
            @endif

            @if ($invitation->gifts->isNotEmpty() || ($invitation->gift_bank_name && $invitation->gift_account_number))
                <section class="gift-section" id="hadiah" data-reveal><p class="invite-kicker">Tanda kasih</p><h2>Wedding Gift</h2><p>Doa restu merupakan hadiah terbaik. Namun bila ingin berbagi tanda kasih:</p><div class="gift-cards">
                    @forelse ($invitation->gifts as $gift)
                        @php($provider = strtolower(str_replace(' ', '', $gift->provider)))
                        @php($bank = $bankLogos[$provider] ?? null)
                        <article class="gift-account">@if ($bank)<img class="gift-bank-logo" src="{{ asset('images/bank/'.$bank[1]) }}" alt="{{ $bank[0] }}">@else<strong>{{ $gift->provider }}</strong>@endif<span>{{ $gift->account_number }}</span><small>{{ $gift->account_name }}</small><button type="button" class="copy-account" data-copy="{{ $gift->account_number }}">▣ Salin</button></article>
                    @empty
                        @php($provider = strtolower(str_replace(' ', '', $invitation->gift_bank_name)))
                        @php($bank = $bankLogos[$provider] ?? null)
                        <article class="gift-account">@if ($bank)<img class="gift-bank-logo" src="{{ asset('images/bank/'.$bank[1]) }}" alt="{{ $bank[0] }}">@else<strong>{{ $invitation->gift_bank_name }}</strong>@endif<span>{{ $invitation->gift_account_number }}</span><small>{{ $invitation->gift_account_name }}</small><button type="button" class="copy-account" data-copy="{{ $invitation->gift_account_number }}">▣ Salin</button></article>
                    @endforelse
                </div></section>
            @endif

            <section class="rsvp-section" id="konfirmasi" data-reveal>
                <p class="invite-kicker">Sebuah kabar dari Anda</p><h2>Konfirmasi Kehadiran</h2><p class="guest-greeting">Jawaban tersimpan untuk {{ $guest->name }}.</p>
                @if (session('rsvp_status'))<div class="notice" role="status">{{ session('rsvp_status') }}</div>@endif
                <form class="rsvp-form" method="POST" action="{{ route('invitations.public.rsvp', [$invitation->slug, $guest->token]) }}">
                    @csrf
                    <div class="pill-choice"><label><input type="radio" name="rsvp_status" value="attending" @checked(old('rsvp_status', $guest->rsvp_status) === 'attending') required><span>Hadir</span></label><label><input type="radio" name="rsvp_status" value="declined" @checked(old('rsvp_status', $guest->rsvp_status) === 'declined')><span>Berhalangan</span></label></div>
                    <div class="field"><label for="party_size">Jumlah yang hadir, termasuk kamu</label><select id="party_size" name="party_size"><option value="1">1 orang</option>@for ($count = 2; $count <= 10; $count++)<option value="{{ $count }}" @selected(old('party_size', $guest->party_size) == $count)>{{ $count }} orang</option>@endfor</select></div>
                    <button class="invite-cta" type="submit">Kirim konfirmasi</button>
                </form>
            </section>

            <section class="wishes-section" id="ucapan" data-reveal>
                <p class="invite-kicker">Wedding wish</p><h2>Kirim doa dan ucapan</h2>
                @if (session('wish_status'))<div class="notice" role="status">{{ session('wish_status') }}</div>@endif
                <form class="rsvp-form" method="POST" action="{{ route('invitations.public.wishes.store', [$invitation->slug, $guest->token]) }}">
                    @csrf
                    <div class="field"><label for="wish-name">Nama</label><input id="wish-name" value="{{ $guest->name }}" disabled></div>
                    <div class="field"><label for="message">Ucapan</label><textarea id="message" name="message" maxlength="600" placeholder="Tuliskan doa terbaikmu..." required>{{ old('message') }}</textarea></div>
                    <button class="invite-cta" type="submit">Kirim ucapan</button>
                </form>
                <div class="approved-wishes">@foreach ($invitation->wishes as $wish)<article class="long-wish"><strong>{{ $wish->guest->name }}</strong><p>{{ $wish->message }}</p></article>@endforeach</div>
            </section>

            <footer class="long-closing" data-reveal>
                @if ($invitation->theme !== 'lavender')<img src="{{ $artUrl($artwork['couple']) }}" alt="Ilustrasi kedua mempelai">@endif
                @if ($invitation->closing_text)<p>{{ $invitation->closing_text }}</p>@else<p>Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>@endif
                <h2>{{ $invitation->bride_name }} <span>&amp;</span> {{ $invitation->groom_name }}</h2>
            </footer>
        </div>
        <div class="invite-credit">Dengan hangat, dari {{ $invitation->bride_name }} &amp; {{ $invitation->groom_name }}</div>
    </main>
    @if ($invitation->theme === 'lavender')
        <button class="scroll-to-top" id="scroll-to-top" type="button" aria-label="Kembali ke atas">⌃</button>
    @endif
    <dialog class="gallery-lightbox" id="gallery-lightbox"><button type="button" class="lightbox-close" aria-label="Tutup">×</button><img alt="Foto galeri"></dialog>

    <script>
        const countdown = document.querySelector('[data-countdown]');
        if (countdown) {
            const target = new Date(countdown.dataset.countdown).getTime();
            const updateCountdown = () => {
                const distance = Math.max(0, target - Date.now());
                const units = { days: 86400000, hours: 3600000, minutes: 60000, seconds: 1000 };
                let rest = distance;
                Object.entries(units).forEach(([unit, size]) => {
                    const value = Math.floor(rest / size);
                    rest %= size;
                    countdown.querySelector(`[data-${unit}]`).textContent = String(value).padStart(2, '0');
                });
            };
            updateCountdown();
            window.setInterval(updateCountdown, 1000);
        }
        const music = document.querySelector('#invite-music');
        const musicButton = document.querySelector('#music-toggle');
        const openButton = document.querySelector('#open-invitation');
        const inviteContent = document.querySelector('#invite-content');
        document.querySelector('#scroll-to-top')?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' });
        });
        openButton?.addEventListener('click', async () => {
            openButton.disabled = true;
            const cover = document.querySelector('#invitation-cover');
            const opensLikeWindow = document.body.classList.contains('theme-lavender');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            inviteContent.hidden = false;
            cover.classList.add('cover-opening');
            inviteContent.querySelector('h1')?.focus({ preventScroll: true });
            const revealInvitation = () => {
                inviteContent.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'start' });
                requestAnimationFrame(() => document.body.classList.add('invitation-open'));
            };
            if (opensLikeWindow && !reduceMotion) {
                window.setTimeout(revealInvitation, 1050);
            } else {
                revealInvitation();
            }
            if (music) {
                try {
                    await music.play();
                    musicButton?.setAttribute('aria-pressed', 'true');
                    musicButton?.setAttribute('aria-label', 'Jeda musik latar');
                } catch { /* Opening remains available when browser audio is unavailable. */ }
            }
        });
        musicButton?.addEventListener('click', async () => {
            if (music.paused) {
                try {
                    await music.play();
                    musicButton.setAttribute('aria-pressed', 'true');
                    musicButton.setAttribute('aria-label', 'Jeda musik latar');
                } catch {
                    musicButton.setAttribute('aria-label', 'Musik tidak tersedia');
                }
            } else {
                music.pause();
                musicButton.setAttribute('aria-pressed', 'false');
                musicButton.setAttribute('aria-label', 'Putar musik latar');
            }
        });
        document.querySelectorAll('.copy-account').forEach((button) => button.addEventListener('click', async () => {
            let copied = false;
            try {
                if (navigator.clipboard?.writeText) {
                    await navigator.clipboard.writeText(button.dataset.copy);
                    copied = true;
                }
            } catch { }
            if (!copied) {
                const temporaryInput = document.createElement('textarea');
                temporaryInput.value = button.dataset.copy;
                temporaryInput.setAttribute('readonly', '');
                temporaryInput.style.position = 'fixed';
                temporaryInput.style.left = '-9999px';
                document.body.append(temporaryInput);
                temporaryInput.focus();
                temporaryInput.select();
                temporaryInput.setSelectionRange(0, temporaryInput.value.length);
                copied = document.execCommand('copy');
                temporaryInput.remove();
            }
            button.textContent = copied ? 'Tersalin' : 'Tekan lama nomor';
            window.setTimeout(() => { button.textContent = '▣ Salin'; }, 1800);
        }));
        const lightbox = document.querySelector('#gallery-lightbox');
        document.querySelectorAll('.gallery-open').forEach((button) => button.addEventListener('click', () => {
            lightbox.querySelector('img').src = button.querySelector('img').src;
            lightbox.showModal();
        }));
        lightbox?.querySelector('.lightbox-close')?.addEventListener('click', () => lightbox.close());
    </script>
</body>
</html>
@endif
