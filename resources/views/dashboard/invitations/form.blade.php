@extends('layouts.app')

@section('title', ($invitation ? 'Edit undangan' : 'Buat undangan').' - WildanTech Studio')

@section('content')
    <section class="container dashboard-shell">
        <div class="dashboard-head"><div><p class="eyebrow">Undangan digital</p><h1>{{ $invitation ? 'Atur undangan' : 'Mulai undangan baru' }}</h1><p>Lengkapi cerita pasangan, acara, dan tampilan undangan.</p></div></div>
        @if ($errors->any())<div class="notice error" role="alert">Periksa kembali isian yang ditandai. {{ $errors->first() }}</div>@endif
        <form class="surface" method="POST" enctype="multipart/form-data" action="{{ $invitation ? route('dashboard.invitations.update', $invitation) : route('dashboard.invitations.store') }}">
            @csrf
            @if ($invitation) @method('PUT') @endif
            @php
                $legacyThemes = ['botanical', 'wine', 'coastal', 'lavender', 'nocturne', 'olive', 'floral', 'heritage', 'moonlight', 'classic'];
                $selectedTheme = old('theme', in_array($invitation?->theme, $legacyThemes, true) ? 'niku-story' : ($invitation?->theme ?? 'niku-story'));
                $childOrderOptions = [1 => 'Pertama', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat', 5 => 'Kelima', 6 => 'Keenam', 7 => 'Ketujuh', 8 => 'Kedelapan', 9 => 'Kesembilan', 10 => 'Kesepuluh'];
            @endphp

            <div class="form-section"><p class="eyebrow">01 · Cerita pasangan</p><h2>Siapa yang berbahagia?</h2></div>
            <div class="form-grid">
                <div class="field"><label for="title">Nama undangan</label><input id="title" name="title" value="{{ old('title', $invitation?->title) }}" maxlength="120" placeholder="Pernikahan Alya & Raka" required></div>
                <div class="field"><label for="theme">Tema visual</label><select id="theme" name="theme" required>
                    @foreach (['indigo' => 'Indigo · ilustrasi floral', 'midnight-moon' => 'Midnight Moon · jendela malam', 'jawa' => 'Jawa Heritage · wayang & gunungan', 'netflix' => 'Netflix · cinematic red & black', 'purnama' => 'Purnama · klasik floral', 'niku-story' => 'Niku Story · floral editorial'] as $value => $label)
                        <option value="{{ $value }}" @selected($selectedTheme === $value)>{{ $label }}</option>
                    @endforeach
                </select></div>
                <div class="field"><label for="bride_nickname">Nama panggilan mempelai putri (opsional)</label><input id="bride_nickname" name="bride_nickname" value="{{ old('bride_nickname', $invitation?->bride_nickname) }}" maxlength="80" placeholder="Contoh: Widya"></div>
                <div class="field"><label for="groom_nickname">Nama panggilan mempelai putra (opsional)</label><input id="groom_nickname" name="groom_nickname" value="{{ old('groom_nickname', $invitation?->groom_nickname) }}" maxlength="80" placeholder="Contoh: Habib"></div>
                <div class="field"><label for="bride_name">Nama lengkap mempelai putri</label><input id="bride_name" name="bride_name" value="{{ old('bride_name', $invitation?->bride_name) }}" maxlength="120" required></div>
                <div class="field"><label for="groom_name">Nama lengkap mempelai putra</label><input id="groom_name" name="groom_name" value="{{ old('groom_name', $invitation?->groom_name) }}" maxlength="120" required></div>
                <div class="field"><label for="bride_father">Putri dari Bapak</label><input id="bride_father" name="bride_father" value="{{ old('bride_father', $invitation?->bride_father) }}" maxlength="120" required></div>
                <div class="field"><label for="groom_father">Putra dari Bapak</label><input id="groom_father" name="groom_father" value="{{ old('groom_father', $invitation?->groom_father) }}" maxlength="120" required></div>
                <div class="field"><label for="bride_mother">dan Ibu</label><input id="bride_mother" name="bride_mother" value="{{ old('bride_mother', $invitation?->bride_mother) }}" maxlength="120" required></div>
                <div class="field"><label for="groom_mother">dan Ibu</label><input id="groom_mother" name="groom_mother" value="{{ old('groom_mother', $invitation?->groom_mother) }}" maxlength="120" required></div>
                <div class="field"><label for="bride_instagram">Instagram mempelai putri (opsional)</label><input id="bride_instagram" type="url" name="bride_instagram" value="{{ old('bride_instagram', $invitation?->bride_instagram) }}" placeholder="https://instagram.com/namapengantin"></div>
                <div class="field"><label for="groom_instagram">Instagram mempelai putra (opsional)</label><input id="groom_instagram" type="url" name="groom_instagram" value="{{ old('groom_instagram', $invitation?->groom_instagram) }}" placeholder="https://instagram.com/namapengantin"></div>
                <div class="field"><label for="bride_child_order">Urutan putri</label><select id="bride_child_order" name="bride_child_order" required><option value="">Pilih urutan</option>@foreach ($childOrderOptions as $value => $label)<option value="{{ $value }}" @selected((string) old('bride_child_order', $invitation?->bride_child_order) === (string) $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="field"><label for="groom_child_order">Urutan putra</label><select id="groom_child_order" name="groom_child_order" required><option value="">Pilih urutan</option>@foreach ($childOrderOptions as $value => $label)<option value="{{ $value }}" @selected((string) old('groom_child_order', $invitation?->groom_child_order) === (string) $value)>{{ $label }}</option>@endforeach</select></div>
                <div class="field"><label for="bride_photo">Foto mempelai putri</label><input id="bride_photo" type="file" name="bride_photo" accept="image/jpeg,image/png,image/webp" data-preview="#bride-preview"><small>JPG, PNG, WebP · maks. 5 MB.</small>
                    @if ($invitation?->bride_photo)<img class="cover-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) }}" alt="Foto mempelai putri saat ini"><label class="checkbox-field"><input type="checkbox" name="remove_bride_photo" value="1"><span>Hapus foto ini</span></label>@endif
                    <img class="cover-preview" id="bride-preview" alt="Pratinjau foto mempelai putri" hidden>
                </div>
                <div class="field"><label for="groom_photo">Foto mempelai putra</label><input id="groom_photo" type="file" name="groom_photo" accept="image/jpeg,image/png,image/webp" data-preview="#groom-preview"><small>JPG, PNG, WebP · maks. 5 MB.</small>
                    @if ($invitation?->groom_photo)<img class="cover-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) }}" alt="Foto mempelai putra saat ini"><label class="checkbox-field"><input type="checkbox" name="remove_groom_photo" value="1"><span>Hapus foto ini</span></label>@endif
                    <img class="cover-preview" id="groom-preview" alt="Pratinjau foto mempelai putra" hidden>
                </div>
                <div class="field full"><label for="cover_image">Foto sampul / foto bersama</label><input id="cover_image" type="file" name="cover_image" accept="image/jpeg,image/png,image/webp" data-preview="#cover-preview"><small>Opsional · JPG, PNG, WebP · maks. 5 MB.</small>
                    @if ($invitation?->cover_image)<img class="cover-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image) }}" alt="Foto sampul saat ini"><label class="checkbox-field"><input type="checkbox" name="remove_cover_image" value="1"><span>Hapus foto sampul</span></label>@endif
                    <img class="cover-preview" id="cover-preview" alt="Pratinjau foto sampul" hidden>
                </div>
                <div class="field full"><label for="gallery_images">Galeri foto</label><input id="gallery_images" type="file" name="gallery_images[]" accept="image/jpeg,image/png,image/webp" multiple><small>Maksimal 12 foto total · tiap file maksimal 5 MB.</small>
                    @if ($invitation?->gallery_images)<div class="media-grid">@foreach ($invitation->gallery_images as $image)<label class="media-remove"><img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}" alt="Foto galeri"><span><input type="checkbox" name="remove_gallery_images[]" value="{{ $image }}"> Hapus</span></label>@endforeach</div>@endif
                </div>
                <div class="field full"><label for="music_file">Musik latar (opsional)</label><input id="music_file" type="file" name="music_file" accept="audio/mpeg,audio/mp4,audio/aac,audio/ogg,audio/wav"><small>MP3, M4A, AAC, OGG, WAV · maksimal 12 MB. Tamu menekan tombol musik untuk mulai memutar.</small>
                    @if ($invitation?->music_file)<audio class="audio-preview" controls preload="none" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file) }}"></audio><label class="checkbox-field"><input type="checkbox" name="remove_music_file" value="1"><span>Hapus musik saat ini</span></label>@endif
                </div>
                <div class="field full"><label for="opening_text">Kalimat pembuka (opsional)</label><textarea id="opening_text" name="opening_text" maxlength="1000" placeholder="Dengan memohon rahmat dan ridha Allah SWT...">{{ old('opening_text', $invitation?->opening_text) }}</textarea></div>
                <div class="field full"><label for="closing_text">Kalimat penutup (opsional)</label><textarea id="closing_text" name="closing_text" maxlength="500">{{ old('closing_text', $invitation?->closing_text) }}</textarea></div>
            </div>

            <div class="surface-head" style="margin-top:28px"><div><p class="eyebrow">01b · Kisah pasangan</p><h2>Our Love Story</h2></div><button class="button-quiet button-small" type="button" id="add-story">Tambah kisah</button></div>
            <p class="muted">Bagian ini opsional. Isi jika ingin menampilkan kisah perjalanan kalian pada tema yang mendukungnya.</p>
            <input type="hidden" name="love_story_present" value="1">
            <div id="love-story-list">
                @foreach (old('love_story', $invitation?->love_story ?? []) as $index => $story)
                    <fieldset class="event-editor" data-story>
                        <h3>Kisah <span data-story-number>{{ $loop->iteration }}</span></h3>
                        <div class="event-fields">
                            <div class="field"><label>Judul momen</label><input name="love_story[{{ $index }}][title]" value="{{ $story['title'] ?? '' }}" maxlength="120" required></div>
                            <div class="field"><label>Tahun / tanggal (opsional)</label><input name="love_story[{{ $index }}][date]" value="{{ $story['date'] ?? '' }}" maxlength="80"></div>
                            <div class="field full"><label>Cerita</label><textarea name="love_story[{{ $index }}][description]" maxlength="1000" required>{{ $story['description'] ?? '' }}</textarea></div>
                        </div>
                        <button class="button-quiet button-small remove-story" type="button">Hapus kisah</button>
                    </fieldset>
                @endforeach
            </div>
            <div class="form-grid" style="margin-top:18px">
                <div class="field full"><label for="livestream_url">Tautan live streaming (opsional)</label><input id="livestream_url" type="url" name="livestream_url" value="{{ old('livestream_url', $invitation?->livestream_url) }}" placeholder="https://youtube.com/live/..."></div>
            </div>

            <div class="surface-head" style="margin-top:30px"><div><p class="eyebrow">02 · Hari istimewa</p><h2>Rangkaian acara</h2></div><button class="button-quiet button-small" type="button" id="add-event">Tambah acara</button></div>
            <div id="events-list">
                @foreach (old('events', $events) as $index => $event)
                    <fieldset class="event-editor" data-event>
                        <h3>Acara <span data-event-number>{{ $loop->iteration }}</span></h3>
                        <div class="event-fields">
                            <div class="field"><label>Nama sesi</label><input name="events[{{ $index }}][title]" value="{{ $event['title'] ?? '' }}" required></div>
                            <div class="field"><label>Lokasi</label><input name="events[{{ $index }}][venue_name]" value="{{ $event['venue_name'] ?? '' }}" required></div>
                            <div class="field"><label>Mulai</label><input type="datetime-local" name="events[{{ $index }}][starts_at]" value="{{ $event['starts_at'] ?? '' }}" required></div>
                            <div class="field"><label>Selesai (opsional)</label><input type="datetime-local" name="events[{{ $index }}][ends_at]" value="{{ $event['ends_at'] ?? '' }}"></div>
                            <div class="field full"><label>Alamat</label><textarea name="events[{{ $index }}][address]">{{ $event['address'] ?? '' }}</textarea></div>
                            <div class="field full"><label>Tautan Google Maps</label><div class="map-url-field"><input type="url" name="events[{{ $index }}][maps_url]" value="{{ $event['maps_url'] ?? '' }}" placeholder="Pilih titik peta atau tempel tautan"><button class="button-quiet button-small" type="button" data-map-picker>Pilih lokasi di peta</button></div></div>
                        </div>
                        @if ($index > 0)<button class="button-quiet button-small remove-event" type="button">Hapus sesi</button>@endif
                    </fieldset>
                @endforeach
            </div>

            <dialog class="map-picker-dialog" id="map-picker" aria-labelledby="map-picker-title">
                <div class="map-picker-head"><div><p class="eyebrow">Pilih titik acara</p><h2 id="map-picker-title">Lokasi di peta</h2></div><button type="button" class="button-quiet button-small" data-map-close aria-label="Tutup peta">Tutup</button></div>
                <div class="map-search"><label class="sr-only" for="map-search-query">Cari tempat atau alamat</label><input id="map-search-query" placeholder="Cari nama tempat atau alamat"><button class="button button-small" type="button" id="map-search-submit">Cari</button></div>
                <p class="map-picker-status" id="map-picker-status" role="status">Cari tempat, lalu pilih hasilnya atau klik peta untuk menentukan pin.</p>
                <div class="map-search-results" id="map-search-results"></div>
                <div class="map-canvas" id="map-canvas" aria-label="Peta interaktif"></div>
                <div class="map-picker-foot"><span id="map-picked-coordinate">Belum ada titik dipilih</span><button class="button" type="button" id="map-confirm" disabled>Gunakan lokasi ini</button></div>
            </dialog>

            <div class="surface-head" style="margin-top:28px"><div><p class="eyebrow">03 · Informasi tambahan</p><h2>Hadiah digital</h2></div></div>
            <p class="muted">Tambahkan rekening bank atau e-wallet yang ingin ditampilkan.</p>
            @php
                $bankOptions = ['bca' => ['BCA', 'bca.webp'], 'bni' => ['BNI', 'bni.webp'], 'bri' => ['BRI', 'bri.png'], 'bsi' => ['BSI', 'bsi.webp'], 'btn' => ['BTN', 'btn.webp'], 'dana' => ['DANA', 'dana.webp'], 'gopay' => ['GoPay', 'gopay.webp'], 'mandiri' => ['Mandiri', 'mandiri.webp'], 'ovo' => ['OVO', 'ovo.webp'], 'seabank' => ['SeaBank', 'seabank.webp'], 'shopeepay' => ['ShopeePay', 'shopeepay.webp']];
            @endphp
            @php
                $bankLogoMap = [];
                foreach ($bankOptions as $key => $bank) {
                    $bankLogoMap[$key] = ['label' => $bank[0], 'logo' => asset('images/bank/'.$bank[1])];
                }
            @endphp
            @php
                $giftRows = old('gifts', $gifts ?? (($invitation?->gift_bank_name && $invitation?->gift_account_number) ? [['provider' => $invitation->gift_bank_name, 'account_name' => $invitation->gift_account_name, 'account_number' => $invitation->gift_account_number]] : []));
            @endphp
            <div id="gifts-list" class="gift-editor-list">
                @foreach ($giftRows as $index => $gift)
                    <fieldset class="gift-editor" data-gift>
                        <legend>Metode hadiah <span data-gift-number>{{ $loop->iteration }}</span></legend>
                        <div class="form-grid">
                            <div class="field"><label>Bank / e-wallet</label><div class="bank-choice"><img class="bank-choice-logo" src="{{ $bankLogoMap[strtolower(str_replace(' ', '', $gift['provider'] ?? ''))]['logo'] ?? '' }}" alt="Logo {{ $gift['provider'] ?? 'bank' }}" @if (! isset($bankLogoMap[strtolower(str_replace(' ', '', $gift['provider'] ?? ''))])) hidden @endif><select name="gifts[{{ $index }}][provider]" data-bank-select required><option value="">Pilih bank / e-wallet</option>@foreach ($bankOptions as $key => [$label, $logo])<option value="{{ $key }}" @selected(strtolower(str_replace(' ', '', $gift['provider'] ?? '')) === $key)>{{ $label }}</option>@endforeach</select></div></div>
                            <div class="field"><label>Nama pemilik</label><input name="gifts[{{ $index }}][account_name]" value="{{ $gift['account_name'] ?? '' }}" required></div>
                            <div class="field"><label>Nomor rekening / akun</label><input name="gifts[{{ $index }}][account_number]" value="{{ $gift['account_number'] ?? '' }}" required></div>
                        </div>
                        @if ($index > 0)<button class="button-quiet button-small remove-gift" type="button">Hapus metode</button>@endif
                    </fieldset>
                @endforeach
            </div>
            <button class="button-quiet button-small" type="button" id="add-gift">Tambah bank / e-wallet</button>
            <div class="form-grid" style="margin-top:18px"><div class="field full"><label for="gift_delivery_address">Alamat kirim hadiah fisik (opsional)</label><textarea id="gift_delivery_address" name="gift_delivery_address" maxlength="1000">{{ old('gift_delivery_address', $invitation?->gift_delivery_address) }}</textarea></div></div>
            <div class="form-grid" style="margin-top:18px">
                <label class="checkbox-field field full"><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $invitation?->is_published))><span>Terbitkan undangan agar tautan personal tamu bisa dibuka</span></label>
                <p class="retention-note field full">Undangan, daftar tamu, RSVP, ucapan, seluruh foto, dan musik akan dihapus permanen 30 hari setelah pertama kali diterbitkan. Kamu bisa mengunduh atau menyimpan data yang diperlukan sebelum tanggal tersebut.</p>
            </div>
            <div class="form-actions"><button class="button" type="submit">Simpan undangan</button><a class="button-quiet" href="{{ $invitation ? route('dashboard.invitations.show', $invitation) : route('dashboard.index') }}">Batal</a></div>
        </form>
    </section>
@endsection

@push('scripts')
<script>
    const bankAssets = {
        bca: { label: 'BCA', logo: '/images/bank/bca.webp' },
        bni: { label: 'BNI', logo: '/images/bank/bni.webp' },
        bri: { label: 'BRI', logo: '/images/bank/bri.png' },
        bsi: { label: 'BSI', logo: '/images/bank/bsi.webp' },
        btn: { label: 'BTN', logo: '/images/bank/btn.webp' },
        dana: { label: 'DANA', logo: '/images/bank/dana.webp' },
        gopay: { label: 'GoPay', logo: '/images/bank/gopay.webp' },
        mandiri: { label: 'Mandiri', logo: '/images/bank/mandiri.webp' },
        ovo: { label: 'OVO', logo: '/images/bank/ovo.webp' },
        seabank: { label: 'SeaBank', logo: '/images/bank/seabank.webp' },
        shopeepay: { label: 'ShopeePay', logo: '/images/bank/shopeepay.webp' },
    };
    const eventsList = document.querySelector('#events-list');
    const addEventButton = document.querySelector('#add-event');
    let nextEventIndex = eventsList.querySelectorAll('[data-event]').length;
    const eventFields = [
        ['title', 'Nama sesi', 'text'], ['venue_name', 'Lokasi', 'text'], ['starts_at', 'Mulai', 'datetime-local'],
        ['ends_at', 'Selesai (opsional)', 'datetime-local'], ['address', 'Alamat', 'textarea'], ['maps_url', 'Tautan Google Maps', 'url'],
    ];
    function renumberEvents() {
        [...eventsList.querySelectorAll('[data-event]')].forEach((event, index) => {
            event.querySelector('[data-event-number]').textContent = index + 1;
            const remove = event.querySelector('.remove-event');
            if (remove) remove.hidden = index === 0;
        });
        addEventButton.disabled = eventsList.querySelectorAll('[data-event]').length >= 6;
    }
    addEventButton.addEventListener('click', () => {
        if (eventsList.querySelectorAll('[data-event]').length >= 6) return;
        const fieldset = document.createElement('fieldset');
        fieldset.className = 'event-editor';
        fieldset.dataset.event = '';
        const heading = document.createElement('h3');
        heading.innerHTML = `Acara <span data-event-number>${eventsList.querySelectorAll('[data-event]').length + 1}</span>`;
        const fields = document.createElement('div');
        fields.className = 'event-fields';
        eventFields.forEach(([name, labelText, type]) => {
            const wrapper = document.createElement('div');
            wrapper.className = name === 'address' || name === 'maps_url' ? 'field full' : 'field';
            const label = document.createElement('label');
            label.textContent = labelText;
            const input = type === 'textarea' ? document.createElement('textarea') : document.createElement('input');
            if (type !== 'textarea') input.type = type;
            input.name = `events[${nextEventIndex}][${name}]`;
            if (['title', 'venue_name', 'starts_at'].includes(name)) input.required = true;
            wrapper.append(label);
            if (name === 'maps_url') {
                const mapField = document.createElement('div');
                mapField.className = 'map-url-field';
                const mapButton = document.createElement('button');
                mapButton.type = 'button';
                mapButton.className = 'button-quiet button-small';
                mapButton.dataset.mapPicker = '';
                mapButton.textContent = 'Pilih lokasi di peta';
                mapField.append(input, mapButton);
                wrapper.append(mapField);
            } else {
                wrapper.append(input);
            }
            fields.append(wrapper);
        });
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'button-quiet button-small remove-event';
        remove.textContent = 'Hapus sesi';
        fieldset.append(heading, fields, remove);
        eventsList.append(fieldset);
        nextEventIndex += 1;
        renumberEvents();
    });
    eventsList.addEventListener('click', (event) => {
        if (event.target.matches('.remove-event')) {
            event.target.closest('[data-event]').remove();
            renumberEvents();
        }
    });
    document.querySelectorAll('[data-preview]').forEach((input) => {
        const preview = document.querySelector(input.dataset.preview);
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) { preview.hidden = true; return; }
            preview.src = URL.createObjectURL(file);
            preview.hidden = false;
        });
    });
    renumberEvents();

    const mapDialog = document.querySelector('#map-picker');
    const mapStatus = document.querySelector('#map-picker-status');
    const mapSearchInput = document.querySelector('#map-search-query');
    const mapSearchButton = document.querySelector('#map-search-submit');
    const mapResults = document.querySelector('#map-search-results');
    const mapCoordinate = document.querySelector('#map-picked-coordinate');
    const mapConfirm = document.querySelector('#map-confirm');
    let mapInstance;
    let mapMarker;
    let selectedPoint = null;
    let selectedPlace = '';
    let activeMapField = null;
    let leafletPromise;

    function loadLeaflet() {
        if (window.L) return Promise.resolve();
        if (!leafletPromise) {
            const css = document.createElement('link');
            css.rel = 'stylesheet';
            css.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            document.head.append(css);
            leafletPromise = new Promise((resolve, reject) => {
                const script = document.createElement('script');
                script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                script.onload = resolve;
                script.onerror = reject;
                document.head.append(script);
            });
        }
        return leafletPromise;
    }

    function setMapPoint(lat, lon, zoom = 16, place = '') {
        selectedPoint = { lat: Number(lat), lon: Number(lon) };
        selectedPlace = place;
        mapMarker.setLatLng([selectedPoint.lat, selectedPoint.lon]);
        mapInstance.setView([selectedPoint.lat, selectedPoint.lon], zoom);
        mapCoordinate.textContent = `${selectedPoint.lat.toFixed(6)}, ${selectedPoint.lon.toFixed(6)}${place ? ` · ${place}` : ''}`;
        mapConfirm.disabled = false;
    }

    eventsList.addEventListener('click', async (event) => {
        const button = event.target.closest('[data-map-picker]');
        if (!button) return;
        activeMapField = button.closest('.field').querySelector('input[name$="[maps_url]"]');
        selectedPlace = '';
        mapDialog.showModal();
        mapStatus.textContent = 'Memuat peta…';
        try {
            await loadLeaflet();
            if (!mapInstance) {
                mapInstance = L.map('map-canvas').setView([-7.362, 109.903], 10);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors',
                }).addTo(mapInstance);
                mapMarker = L.marker(mapInstance.getCenter(), { draggable: true }).addTo(mapInstance);
                mapMarker.on('dragend', () => {
                    const point = mapMarker.getLatLng();
                    setMapPoint(point.lat, point.lng, mapInstance.getZoom());
                });
                mapInstance.on('click', (mapEvent) => setMapPoint(mapEvent.latlng.lat, mapEvent.latlng.lng, mapInstance.getZoom()));
            }
            mapInstance.invalidateSize();
            mapStatus.textContent = 'Cari tempat, klik peta untuk memasang pin, atau seret pin ke titik yang tepat.';
            const coordinates = activeMapField.value.match(/query=(-?[\d.]+),\s*(-?[\d.]+)/);
            if (coordinates) setMapPoint(coordinates[1], coordinates[2], 16);
            else {
                selectedPoint = null;
                mapConfirm.disabled = true;
                mapCoordinate.textContent = 'Belum ada titik dipilih';
            }
            window.setTimeout(() => mapInstance.invalidateSize(), 100);
        } catch {
            mapStatus.textContent = 'Peta tidak dapat dimuat. Periksa koneksi internet lalu coba lagi.';
        }
    });

    async function searchMapPlaces() {
        const query = mapSearchInput.value.trim();
        if (!query) return;
        mapStatus.textContent = 'Mencari tempat…';
        mapResults.replaceChildren();
        try {
            const url = new URL('https://nominatim.openstreetmap.org/search');
            url.search = new URLSearchParams({ format: 'jsonv2', limit: '6', q: query });
            const response = await fetch(url, { headers: { Accept: 'application/json' } });
            if (!response.ok) throw new Error('Search failed');
            const places = await response.json();
            if (!places.length) {
                mapStatus.textContent = 'Tempat tidak ditemukan. Coba nama atau alamat yang lebih spesifik.';
                return;
            }
            mapStatus.textContent = 'Pilih hasil pencarian untuk memindahkan pin.';
            places.forEach((place) => {
                const result = document.createElement('button');
                result.type = 'button';
                result.className = 'map-search-result';
                result.textContent = place.display_name;
                result.addEventListener('click', () => setMapPoint(place.lat, place.lon, 17, place.display_name));
                mapResults.append(result);
            });
        } catch {
            mapStatus.textContent = 'Pencarian gagal. Coba lagi sebentar.';
        }
    }
    mapSearchButton.addEventListener('click', searchMapPlaces);
    mapSearchInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchMapPlaces();
        }
    });
    mapConfirm.addEventListener('click', () => {
        if (!selectedPoint || !activeMapField) return;
        activeMapField.value = `https://www.google.com/maps/search/?api=1&query=${selectedPoint.lat},${selectedPoint.lon}`;
        activeMapField.dispatchEvent(new Event('input', { bubbles: true }));
        const addressField = activeMapField.closest('[data-event]').querySelector('textarea[name$="[address]"]');
        if (addressField && selectedPlace && !addressField.value) addressField.value = selectedPlace;
        mapDialog.close();
    });
    mapDialog.querySelector('[data-map-close]').addEventListener('click', () => mapDialog.close());

    const giftsList = document.querySelector('#gifts-list');
    const addGiftButton = document.querySelector('#add-gift');
    let nextGiftIndex = giftsList.querySelectorAll('[data-gift]').length;
    function renumberGifts() {
        [...giftsList.querySelectorAll('[data-gift]')].forEach((gift, index) => {
            gift.querySelector('[data-gift-number]').textContent = index + 1;
            const remove = gift.querySelector('.remove-gift');
            if (remove) remove.hidden = index === 0;
        });
        addGiftButton.disabled = giftsList.querySelectorAll('[data-gift]').length >= 8;
    }
    addGiftButton.addEventListener('click', () => {
        if (giftsList.querySelectorAll('[data-gift]').length >= 8) return;
        const index = nextGiftIndex++;
        const fieldset = document.createElement('fieldset');
        fieldset.className = 'gift-editor';
        fieldset.dataset.gift = '';
        const providerOptions = Object.entries(bankAssets).map(([key, bank]) => `<option value="${key}">${bank.label}</option>`).join('');
        fieldset.innerHTML = `<legend>Metode hadiah <span data-gift-number></span></legend><div class="form-grid"><div class="field"><label>Bank / e-wallet</label><div class="bank-choice"><img class="bank-choice-logo" alt="Logo bank" hidden><select name="gifts[${index}][provider]" data-bank-select required><option value="">Pilih bank / e-wallet</option>${providerOptions}</select></div></div><div class="field"><label>Nama pemilik</label><input name="gifts[${index}][account_name]" required></div><div class="field"><label>Nomor rekening / akun</label><input name="gifts[${index}][account_number]" required></div></div><button class="button-quiet button-small remove-gift" type="button">Hapus metode</button>`;
        giftsList.append(fieldset);
        renumberGifts();
    });
    giftsList.addEventListener('click', (event) => {
        if (event.target.matches('.remove-gift')) {
            event.target.closest('[data-gift]').remove();
            renumberGifts();
        }
    });
    function updateBankLogo(select) {
        const image = select.closest('.bank-choice').querySelector('.bank-choice-logo');
        const bank = bankAssets[select.value];
        image.hidden = !bank;
        if (bank) {
            image.src = bank.logo;
            image.alt = `Logo ${bank.label}`;
        }
    }
    giftsList.addEventListener('change', (event) => {
        if (event.target.matches('[data-bank-select]')) updateBankLogo(event.target);
    });
    giftsList.querySelectorAll('[data-bank-select]').forEach(updateBankLogo);
    renumberGifts();

    const storyList = document.querySelector('#love-story-list');
    const addStoryButton = document.querySelector('#add-story');
    let nextStoryIndex = storyList.querySelectorAll('[data-story]').length;
    function renumberStories() {
        [...storyList.querySelectorAll('[data-story]')].forEach((story, index) => {
            story.querySelector('[data-story-number]').textContent = index + 1;
            const remove = story.querySelector('.remove-story');
            if (remove) remove.hidden = false;
        });
        addStoryButton.disabled = storyList.querySelectorAll('[data-story]').length >= 6;
    }
    addStoryButton.addEventListener('click', () => {
        if (storyList.querySelectorAll('[data-story]').length >= 6) return;
        const index = nextStoryIndex++;
        const fieldset = document.createElement('fieldset');
        fieldset.className = 'event-editor';
        fieldset.dataset.story = '';
        fieldset.innerHTML = `<h3>Kisah <span data-story-number></span></h3><div class="event-fields"><div class="field"><label>Judul momen</label><input name="love_story[${index}][title]" maxlength="120" required></div><div class="field"><label>Tahun / tanggal (opsional)</label><input name="love_story[${index}][date]" maxlength="80"></div><div class="field full"><label>Cerita</label><textarea name="love_story[${index}][description]" maxlength="1000" required></textarea></div></div><button class="button-quiet button-small remove-story" type="button">Hapus kisah</button>`;
        storyList.append(fieldset);
        renumberStories();
    });
    storyList.addEventListener('click', (event) => {
        if (event.target.matches('.remove-story')) {
            event.target.closest('[data-story]').remove();
            renumberStories();
        }
    });
    renumberStories();
</script>
@endpush
