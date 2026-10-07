@php
    $jawaHtml = file_get_contents(base_path('contoh jawa.html'));
    abort_if($jawaHtml === false, 500, 'Template contoh Jawa tidak ditemukan.');

    $jawaPublicUrl = fn (?string $path): ?string => $path ? \Illuminate\Support\Facades\Storage::disk('public')->url($path) : null;
    $jawaBride = e($invitation->bride_nickname ?: $invitation->bride_name);
    $jawaGroom = e($invitation->groom_nickname ?: $invitation->groom_name);
    $jawaBrideFull = e($invitation->bride_name);
    $jawaGroomFull = e($invitation->groom_name);
    $jawaGuest = e($guest->name);
    $jawaFirstEvent = $invitation->events->first(fn ($event): bool => $event->starts_at !== null);
    $jawaSecondEvent = $invitation->events->skip(1)->first(fn ($event): bool => $event->starts_at !== null);
    $jawaDate = $jawaFirstEvent?->starts_at?->translatedFormat('l, d F Y') ?? '';
    $jawaShortDate = $jawaFirstEvent?->starts_at?->translatedFormat('j F Y') ?? '';
    $jawaStories = array_values($invitation->love_story ?? []);
    $jawaGifts = $invitation->gifts->values();
    $jawaFallbackImage = asset('images/asetttt/jawa/JAWA-FALLBACK.jpg');
    $jawaCoverPhoto = $jawaPublicUrl($invitation->cover_image) ?: $jawaPublicUrl($invitation->gallery_images[0] ?? null) ?: $jawaFallbackImage;
    $jawaTogetherPhoto = $jawaCoverPhoto;
    $jawaBridePhoto = $jawaPublicUrl($invitation->bride_photo) ?: $jawaTogetherPhoto;
    $jawaGroomPhoto = $jawaPublicUrl($invitation->groom_photo) ?: $jawaTogetherPhoto;
    $jawaGalleryPhotos = array_values(array_filter(array_map($jawaPublicUrl, $invitation->gallery_images ?? [])));
    $jawaPhotos = [
        'GIGI5684-2.jpg' => $jawaTogetherPhoto,
        'GIGI5691-1.jpg' => $jawaBridePhoto,
        'GIGI5692.jpg' => $jawaGroomPhoto,
        'GIGI5665.jpg' => $jawaTogetherPhoto,
        'Revisi-2.jpg' => $jawaBridePhoto,
        'Revisi-3.jpg' => $jawaGroomPhoto,
        'Revisi-5.jpg' => $jawaTogetherPhoto,
    ];
    $jawaHtml = str_replace('https:\\/\\/by.memonika.com\\/wp-content\\/uploads\\/2025\\/08\\/GIGI5692.jpg', str_replace('/', '\\/', $jawaTogetherPhoto), $jawaHtml);

    $jawaHtml = str_replace(
        ['Widya Ismiriadi S.I.Kom', 'Habiburrahman S.I.Kom', 'Bapak Nasrudin Hatta', 'Ibu Elma Muna', 'Bapak Sufian Jadin', 'Ibu Elmira Ghendis', 'Widya', 'Habib', 'https://www.instagram.com/memonikacom'],
        [$jawaBrideFull, $jawaGroomFull, 'Bapak '.e($invitation->bride_father), 'Ibu '.e($invitation->bride_mother), 'Bapak '.e($invitation->groom_father), 'Ibu '.e($invitation->groom_mother), $jawaBride, $jawaGroom, e($invitation->bride_instagram ?: $invitation->groom_instagram ?: '#')],
        $jawaHtml
    );
    $jawaHtml = str_replace('memonikacom</span>', 'Instagram</span>', $jawaHtml);
    foreach ([
        ['id' => '3dd1a44', 'url' => $invitation->bride_instagram],
        ['id' => '18dc3e39', 'url' => $invitation->groom_instagram],
        ['id' => '11bde252', 'url' => $invitation->livestream_url],
    ] as $jawaProfileLink) {
        $jawaProfileUrl = e($jawaProfileLink['url'] ?: '#');
        $jawaHtml = preg_replace_callback('/(<div class="elementor-element elementor-element-'.$jawaProfileLink['id'].'\b.*?<a\b[^>]*href=")[^"]+(")/s', fn (array $matches): string => $matches[1].$jawaProfileUrl.$matches[2], $jawaHtml, 1) ?? $jawaHtml;
        if (! $jawaProfileLink['url']) {
            $jawaHtml = str_replace('data-id="'.$jawaProfileLink['id'].'"', 'data-id="'.$jawaProfileLink['id'].'" hidden', $jawaHtml);
        }
    }
    if (! $invitation->livestream_url) {
        $jawaHtml = str_replace('data-id="7c4049b0"', 'data-id="7c4049b0" hidden', $jawaHtml);
    }
    foreach (['5d3fe0ac', '41edf003', '6b081c13', '1a6a69e3'] as $jawaBrandWidget) {
        $jawaHtml = str_replace('data-id="'.$jawaBrandWidget.'"', 'data-id="'.$jawaBrandWidget.'" hidden', $jawaHtml);
    }
    $jawaHtml = str_replace('<title>Demo Art Motion Java Heritage - Memonika</title>', '<title>'.e($invitation->title).'</title>', $jawaHtml);
    $jawaHtml = str_replace('let to = params.get("to");', 'let to = '.json_encode($jawaGuest, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT).';', $jawaHtml);

    foreach ($jawaPhotos as $jawaFilename => $jawaUrl) {
        $jawaOriginalUrl = 'https://by.memonika.com/wp-content/uploads/2025/08/'.$jawaFilename;
        $jawaHtml = str_replace([$jawaOriginalUrl, str_replace('/', '\\/', $jawaOriginalUrl)], [$jawaUrl, str_replace('/', '\\/', $jawaUrl)], $jawaHtml);
        $jawaHtml = preg_replace('/(<img[^>]+src="'.preg_quote($jawaUrl, '/').'"[^>]*?)\s+srcset="[^"]*"/', '$1', $jawaHtml);
    }
    $jawaGallerySlides = array_map(
        fn (string $imageUrl, int $index): array => ['id' => (string) ($index + 1), 'url' => $imageUrl],
        $jawaGalleryPhotos ?: [$jawaCoverPhoto],
        array_keys($jawaGalleryPhotos ?: [$jawaCoverPhoto])
    );
    $jawaHtml = preg_replace_callback('/(<div[^>]*elementor-element-73e72d37[^>]*data-settings=")([^"]*)(")/', function (array $matches) use ($jawaGallerySlides): string {
        $settings = json_decode(html_entity_decode($matches[2], ENT_QUOTES | ENT_HTML5), true);
        if (! is_array($settings)) {
            return $matches[0];
        }

        $settings['background_slideshow_gallery'] = $jawaGallerySlides;

        return $matches[1].e(json_encode($settings, JSON_UNESCAPED_SLASHES)).$matches[3];
    }, $jawaHtml, 1);
    $jawaHtml = preg_replace('/\s*<div class="elementor-element elementor-element-(?:36390fa3|3d3f00d)\b.*?<\/div>\s*<\/div>/s', '', $jawaHtml, 2);

    $jawaGalleryStart = strpos($jawaHtml, 'data-id="695692de"');
    $jawaGalleryEnd = $jawaGalleryStart === false ? false : strpos($jawaHtml, 'data-id="19b9ce92"', $jawaGalleryStart);
    if ($jawaGalleryStart !== false && $jawaGalleryEnd !== false) {
        $jawaGalleryBlock = substr($jawaHtml, $jawaGalleryStart, $jawaGalleryEnd - $jawaGalleryStart);
        $jawaGalleryItems = '';
        foreach ($jawaGalleryPhotos as $jawaGalleryIndex => $jawaGalleryPhoto) {
            $jawaGalleryUrl = e($jawaGalleryPhoto);
            $jawaGallerySettings = rawurlencode(base64_encode(json_encode([
                'id' => $jawaGalleryIndex + 1,
                'url' => $jawaGalleryPhoto,
                'slideshow' => '695692de',
            ], JSON_UNESCAPED_SLASHES)));
            $jawaGalleryItems .= '<a class="e-gallery-item elementor-gallery-item elementor-animated-content" href="'.$jawaGalleryUrl.'" data-elementor-open-lightbox="yes" data-elementor-lightbox-slideshow="695692de" data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3D'.$jawaGallerySettings.'"><div class="e-gallery-image elementor-gallery-item__image" data-thumbnail="'.$jawaGalleryUrl.'" data-width="1280" data-height="1920" aria-label="Foto galeri" role="img"></div><div class="elementor-gallery-item__overlay"></div></a>';
        }
        $jawaGalleryItemIndex = 0;
        $jawaGalleryBlock = preg_replace_callback('/<a class="e-gallery-item.*?<\/a>/s', function () use (&$jawaGalleryItemIndex, $jawaGalleryItems): string {
            return $jawaGalleryItemIndex++ === 0 ? $jawaGalleryItems : '';
        }, $jawaGalleryBlock) ?? $jawaGalleryBlock;
        if ($jawaGalleryPhotos === []) {
            $jawaGalleryBlock = str_replace('elementor-element-695692de', 'elementor-element-695692de jawa-gallery-empty', $jawaGalleryBlock);
        }
        $jawaHtml = substr($jawaHtml, 0, $jawaGalleryStart).$jawaGalleryBlock.substr($jawaHtml, $jawaGalleryEnd);
    }

    $jawaSampleMusic = 'https://by.memonika.com/wp-content/uploads/2025/08/Niken-Salindry-LESTARI-Kembar-Campursari-1.mp3';
    $jawaMusicUrl = $jawaPublicUrl($invitation->music_file) ?: asset('images/asetttt/jawa/Niken-Salindry-LESTARI-Kembar-Campursari-1.mp3');
    $jawaHtml = str_replace($jawaSampleMusic, $jawaMusicUrl, $jawaHtml);
    if ($jawaFirstEvent) {
        $jawaAkadStart = strpos($jawaHtml, 'data-id="613a104c"');
        $jawaResepsiStart = strpos($jawaHtml, 'data-id="455a6a9b"');
        $jawaAfterEventsStart = strpos($jawaHtml, 'data-id="7c4049b0"', $jawaResepsiStart ?: 0);
        if ($jawaAkadStart !== false && $jawaResepsiStart !== false && $jawaAfterEventsStart !== false) {
            $jawaAkadBlock = substr($jawaHtml, $jawaAkadStart, $jawaResepsiStart - $jawaAkadStart);
            $jawaResepsiBlock = substr($jawaHtml, $jawaResepsiStart, $jawaAfterEventsStart - $jawaResepsiStart);
            $jawaAkadBlock = str_replace(['Akad Nikah', 'minggu', '6 Desember 2026', '08.00 - 10.00 WIB', 'Jalan Raya Bojongsari No.5, Gunung Putri, Citeureup, Bogor, Jawa Barat', 'href="#" target="_blank"'], [
                e($jawaFirstEvent->title),
                e($jawaFirstEvent->starts_at?->translatedFormat('l') ?? ''),
                e($jawaFirstEvent->starts_at?->translatedFormat('j F Y') ?? ''),
                e(trim(($jawaFirstEvent->starts_at?->format('H.i') ?? '').($jawaFirstEvent->ends_at ? ' - '.$jawaFirstEvent->ends_at->format('H.i') : '').' WIB')),
                e($jawaFirstEvent->address ?: $jawaFirstEvent->venue_name),
                'href="'.e($jawaFirstEvent->maps_url ?: '#').'" target="_blank"',
            ], $jawaAkadBlock);
            if ($jawaSecondEvent) {
                $jawaSecondEventTime = ($jawaSecondEvent->starts_at?->format('H.i') ?? '').' WIB'.($jawaSecondEvent->ends_at ? ' - '.$jawaSecondEvent->ends_at->format('H.i').' WIB' : ' - Selesai');
                $jawaResepsiBlock = str_replace(['Resepsi<br>Pernikahan', 'minggu', '6 Desember 2026', '10.00 WIB - Selesai', 'Jalan Raya Bojongsari No.5, Gunung Putri, Citeureup, Bogor, Jawa Barat', 'href="#" target="_blank"'], [
                    e($jawaSecondEvent->title),
                    e($jawaSecondEvent->starts_at?->translatedFormat('l') ?? ''),
                    e($jawaSecondEvent->starts_at?->translatedFormat('j F Y') ?? ''),
                    e($jawaSecondEventTime),
                    e($jawaSecondEvent->address ?: $jawaSecondEvent->venue_name),
                    'href="'.e($jawaSecondEvent->maps_url ?: '#').'" target="_blank"',
                ], $jawaResepsiBlock);
            }
            $jawaHtml = substr($jawaHtml, 0, $jawaAkadStart).$jawaAkadBlock.$jawaResepsiBlock.substr($jawaHtml, $jawaAfterEventsStart);
        }
        $jawaHtml = str_replace('06 . 12 . 26', $jawaFirstEvent->starts_at?->format('d . m . y') ?? '', $jawaHtml);
        $jawaHtml = str_replace('Dec 06 2026 10:00:00', $jawaFirstEvent->starts_at?->format('M d Y H:i:s') ?? '', $jawaHtml);
        $jawaHtml = str_replace(['Minggu, 6 Desember 2026', '6 Desember 2026'], [e($jawaDate), e($jawaShortDate)], $jawaHtml);
        if (! $jawaSecondEvent) {
            $jawaHtml = str_replace('data-id="455a6a9b"', 'data-id="455a6a9b" hidden', $jawaHtml);
        }
    } else {
        $jawaHtml = str_replace('data-id="613a104c"', 'data-id="613a104c" hidden', $jawaHtml);
        $jawaHtml = str_replace('data-id="455a6a9b"', 'data-id="455a6a9b" hidden', $jawaHtml);
    }
    if ($invitation->opening_text) {
        $jawaHtml = str_replace('Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i, untuk menghadiri acara pernikahan kami:', e($invitation->opening_text), $jawaHtml);
    }
    if ($invitation->closing_text) {
        $jawaHtml = str_replace("Suatu kebahagiaan &amp; kehormatan bagi kami, apabila Bapak/Ibu/Saudara/i, berkenan hadir dan memberikan do'a restu kepada kami", e($invitation->closing_text), $jawaHtml);
    }
    $jawaStoryDefaults = [
        ['Awal Bertemu', 'Tidak ada yang kebetulan di dunia ini, Semua sudah tersusun rapi oleh sang Maha Kuasa. Kita tidak bisa memilih kepada siapa kita akan jatuh cinta. Kami bertemu pada awal tahun 2019, tidak ada yang pernah menyangka bahwa pertemuan ini membawa kami pada suatu ikatan cinta yang suci hari ini.'],
        ['Lamaran', 'Kehendaknya menuntun kami pada sebuah pertemuan yang tak pernah di sangka hingga akhirnya di pertengahan tahun 2024 kami memantapkan hati untuk membawa hubungan ini kejenjang yang lebih serius dengan mempertemukan kedua orang tua dan keluarga besar dalam silaturahmi dan lamaran'],
        ['Menikah', 'Percayalah, bukan karena bertemu lalu berjodoh tapi karena berjodoh lah maka kami dipertemukan. Atas izin Allah SWT serta restu dan ridho kedua orang tua kami memutuskan untuk mengikrarkan janji suci pernikahan kami di tanggal 6 Desember 2026. Serta memulai kisah baru kami dalam suatu ikatan suci pernikahan yang semoga senantiasa diberkahi oleh Allah SWT.'],
    ];
    foreach ($jawaStoryDefaults as $index => [$defaultTitle, $defaultDescription]) {
        $story = $jawaStories[$index] ?? null;
        if ($story) {
            $jawaHtml = str_replace($defaultTitle, e($story['title'] ?? $defaultTitle), $jawaHtml);
            $jawaHtml = str_replace($defaultDescription, e($story['description'] ?? ''), $jawaHtml);
        } else {
            $sectionId = ['715fcb88', '14bd2632', '2caa2d6b'][$index];
            $jawaHtml = str_replace('data-id="'.$sectionId.'"', 'data-id="'.$sectionId.'" hidden', $jawaHtml);
        }
    }
    if ($jawaStories === []) {
        $jawaHtml = str_replace('data-id="224d7374"', 'data-id="224d7374" hidden', $jawaHtml);
    }
    $jawaGiftAccounts = $jawaGifts->map(fn ($gift): array => [
        'provider' => $gift->provider,
        'account_name' => $gift->account_name,
        'account_number' => $gift->account_number,
    ])->all();
    if ($jawaGiftAccounts === [] && $invitation->gift_bank_name && $invitation->gift_account_number) {
        $jawaGiftAccounts[] = ['provider' => $invitation->gift_bank_name, 'account_name' => $invitation->gift_account_name, 'account_number' => $invitation->gift_account_number];
    }
    if ($jawaGiftAccounts === [] && ! $invitation->gift_delivery_address) {
        $jawaHtml = str_replace('data-id="4c307476"', 'data-id="4c307476" hidden', $jawaHtml);
    }
    foreach (['1fc8473b', '6d05f627'] as $jawaGiftIndex => $jawaGiftTitleId) {
        $jawaGiftAccount = $jawaGiftAccounts[$jawaGiftIndex] ?? null;
        if (! $jawaGiftAccount) {
            continue;
        }

        $jawaGiftTitle = e($jawaGiftAccount['provider']).'<br>No. Rekening '.e($jawaGiftAccount['account_number']).'<br>a.n <b>'.e($jawaGiftAccount['account_name'] ?: '').'</b>';
        $jawaHtml = preg_replace_callback('/(<div class="elementor-element elementor-element-'.$jawaGiftTitleId.'\b.*?<h2 class="elementor-heading-title elementor-size-default">).*?(<\/h2>)/s', fn (array $matches): string => $matches[1].$jawaGiftTitle.$matches[2], $jawaHtml, 1) ?? $jawaHtml;
    }
    $jawaGiftAccountIndex = 0;
    $jawaHtml = preg_replace_callback('/(<div class="copy-content spancontent" style="display: none;">)123123123(<\/div>)/', function (array $matches) use (&$jawaGiftAccountIndex, $jawaGiftAccounts): string {
        $account = $jawaGiftAccounts[$jawaGiftAccountIndex++] ?? null;

        return $account ? $matches[1].e($account['account_number']).$matches[2] : $matches[1].$matches[2];
    }, $jawaHtml) ?? $jawaHtml;
    $jawaBankLogos = ['bca' => 'bca.webp', 'bni' => 'bni.webp', 'bri' => 'bri.png', 'bsi' => 'bsi.webp', 'btn' => 'btn.webp', 'dana' => 'dana.webp', 'gopay' => 'gopay.webp', 'mandiri' => 'mandiri.webp', 'ovo' => 'ovo.webp', 'seabank' => 'seabank.webp', 'shopeepay' => 'shopeepay.webp'];
    foreach ([['id' => '55ee2c74', 'account' => $jawaGiftAccounts[0] ?? null], ['id' => '42226a5a', 'account' => $jawaGiftAccounts[1] ?? null]] as $jawaGiftLogo) {
        if (! $jawaGiftLogo['account']) {
            $jawaHtml = str_replace('data-id="'.$jawaGiftLogo['id'].'"', 'data-id="'.$jawaGiftLogo['id'].'" hidden', $jawaHtml);
            continue;
        }

        $jawaProviderSlug = strtolower(preg_replace('/[^a-z0-9]/i', '', $jawaGiftLogo['account']['provider']));
        $jawaLogoFilename = $jawaBankLogos[$jawaProviderSlug] ?? null;
        if ($jawaLogoFilename) {
            $jawaLogoUrl = e(asset('images/bank/'.$jawaLogoFilename));
            $jawaHtml = preg_replace_callback('/(<div class="elementor-element elementor-element-'.$jawaGiftLogo['id'].'\b.*?<img\b[^>]*src=")[^"]+("[^>]*>)/s', fn (array $matches): string => $matches[1].$jawaLogoUrl.$matches[2], $jawaHtml, 1) ?? $jawaHtml;
            $jawaHtml = preg_replace_callback('/(<div class="elementor-element elementor-element-'.$jawaGiftLogo['id'].'\b.*?<img\b[^>]*)(>)/s', fn (array $matches): string => preg_replace('/\s+(?:srcset|sizes)="[^"]*"/', '', $matches[1]).$matches[2], $jawaHtml, 1) ?? $jawaHtml;
        } else {
            $jawaHtml = str_replace('data-id="'.$jawaGiftLogo['id'].'"', 'data-id="'.$jawaGiftLogo['id'].'" hidden', $jawaHtml);
        }
    }
    foreach (['1fc8473b', '4c3ffdf3', '5388fd77'] as $jawaFirstGiftWidget) {
        if (! isset($jawaGiftAccounts[0])) {
            $jawaHtml = str_replace('data-id="'.$jawaFirstGiftWidget.'"', 'data-id="'.$jawaFirstGiftWidget.'" hidden', $jawaHtml);
        }
    }
    foreach (['6d05f627', '5d61783a', '421dc575'] as $jawaSecondGiftWidget) {
        if (! isset($jawaGiftAccounts[1])) {
            $jawaHtml = str_replace('data-id="'.$jawaSecondGiftWidget.'"', 'data-id="'.$jawaSecondGiftWidget.'" hidden', $jawaHtml);
        }
    }
    if ($invitation->gift_delivery_address) {
        $jawaHtml = str_replace('Jalan Raya Bojongsari No.5, Gunung Putri, Citeureup, Bogor, Jawa Barat', e($invitation->gift_delivery_address), $jawaHtml);
        $jawaHtml = preg_replace('/(<div class="copy-content spancontent" style="display: none;">)Elyana Azkiya Nur.*?(<\/div>)/s', '$1'.e($invitation->gift_delivery_address).'$2', $jawaHtml, 1) ?? $jawaHtml;
    } else {
        foreach (['ab07ec6', '73a40327', '69316ff5'] as $jawaGiftAddressWidget) {
            $jawaHtml = str_replace('data-id="'.$jawaGiftAddressWidget.'"', 'data-id="'.$jawaGiftAddressWidget.'" hidden', $jawaHtml);
        }
    }

    $jawaWishUrl = route('invitations.public.wishes.store', [$invitation->slug, $guest->token]);
    $jawaWishItems = '';
    foreach ($invitation->wishes as $jawaWish) {
        $jawaWishItems .= '<li class="cui-item-comment"><div class="cui-comment-content"><strong>'.e($jawaWish->guest->name).'</strong><p>'.nl2br(e($jawaWish->message)).'</p></div></li>';
    }
    $jawaWishListPattern = '/(<ul id=[\'"]cui-container-comment-129588[\'"][^>]*>).*?(<\/ul>)/s';
    $jawaHtml = preg_replace_callback($jawaWishListPattern, fn (array $matches): string => $matches[1].$jawaWishItems.$matches[2], $jawaHtml, 1) ?? $jawaHtml;
    $jawaHtml = str_replace(' auto-load-true', '', $jawaHtml);
    $jawaHtml = str_replace("href='?post_id=129588&amp;comments=0&amp;get=150&amp;order=DESC'", "href='#ucapan'", $jawaHtml);
    $jawaWishCount = $invitation->wishes->count();
    $jawaHtml = preg_replace_callback('/(<a id=[\'"]cui-link-129588[\'"][^>]*>).*?(<\/a>)/s', function (array $matches) use ($jawaWishCount): string {
        $openingTag = preg_replace('/title=[\'"][^\'"]*[\'"]/', 'title="'.$jawaWishCount.' Ucapan"', $matches[1], 1) ?? $matches[1];

        return $openingTag.'<span>'.$jawaWishCount.'</span> Ucapan'.$matches[2];
    }, $jawaHtml, 1) ?? $jawaHtml;
    $jawaHtml = str_replace("id='cui-wrap-commnent-129588' class='cui-wrap-comments' style='display:none;'", "id='cui-wrap-commnent-129588' class='cui-wrap-comments' style='display:block;'", $jawaHtml);
    $jawaRsvpForm = '<form action="'.e(route('invitations.public.rsvp', [$invitation->slug, $guest->token])).'" method="post" class="cui-wrap-form jawa-rsvp-form"><input type="hidden" name="_token" value="'.e(csrf_token()).'"><label for="jawa-rsvp">Konfirmasi kehadiran</label><select id="jawa-rsvp" name="rsvp_status" required><option value="">Pilih jawaban</option><option value="attending">Hadir</option><option value="declined">Tidak dapat hadir</option></select><label for="jawa-party-size">Jumlah yang hadir</label><select id="jawa-party-size" name="party_size">';
    for ($jawaPartySize = 1; $jawaPartySize <= 10; $jawaPartySize++) {
        $jawaRsvpForm .= '<option value="'.$jawaPartySize.'">'.$jawaPartySize.' orang</option>';
    }
    $jawaRsvpForm .= '</select><button type="submit">Kirim Konfirmasi</button></form>';
    $jawaHtml = preg_replace("/(?=<form[^>]*id=['\"]commentform)/", $jawaRsvpForm, $jawaHtml, 1);
    $jawaHtml = str_replace('https://by.memonika.com/wp-comments-post.php', $jawaWishUrl, $jawaHtml);
    $jawaHtml = str_replace('name="comment"', 'name="message"', $jawaHtml);
    $jawaHtml = preg_replace("/(<form[^>]*id=['\"]commentform[^>]*>)/", '$1<input type="hidden" name="_token" value="'.e(csrf_token()).'">', $jawaHtml, 1);

    $jawaCountdownTimestamp = $jawaFirstEvent?->starts_at?->timestamp ?? 0;
    $jawaHtml = str_replace('$("#wpkoi-elements-countdown-47f81e21").countdown();', '', $jawaHtml);
    $jawaCountdownScript = '<script>(function(){var target='.(int) $jawaCountdownTimestamp.'*1000;function update(){var remaining=Math.max(0,Math.floor((target-Date.now())/1000));var values={days:Math.floor(remaining/86400),hours:Math.floor(remaining%86400/3600),minutes:Math.floor(remaining%3600/60),seconds:remaining%60};Object.keys(values).forEach(function(unit){document.querySelectorAll("[data-"+unit+"]").forEach(function(element){if(element.closest(".wpkoi-elements-countdown-items")){element.textContent=String(values[unit]).padStart(2,"0");}});});}update();window.setInterval(update,1000);})();</script>';
    $jawaHtml = str_replace('</body>', $jawaCountdownScript.'</body>', $jawaHtml);
    $jawaRemoveWidgets = ['.elementor-element-5d3fe0ac', '.elementor-element-41edf003', '.elementor-element-6b081c13', '.elementor-element-1a6a69e3'];
    if (! $invitation->livestream_url) {
        $jawaRemoveWidgets[] = '.elementor-element-7c4049b0';
    }
    if ($jawaGiftAccounts === [] && ! $invitation->gift_delivery_address) {
        $jawaRemoveWidgets[] = '.elementor-element-4c307476';
    } elseif (! isset($jawaGiftAccounts[1])) {
        $jawaRemoveWidgets[] = '.elementor-element-6d05f627';
    }
    $jawaCleanupScript = '<script>document.querySelectorAll('.json_encode(implode(',', $jawaRemoveWidgets)).').forEach(function(widget){widget.remove();});</script>';
    $jawaHtml = str_replace('</body>', $jawaCleanupScript.'</body>', $jawaHtml);
    $jawaBrandStyles = '.elementor-element-5d3fe0ac,.elementor-element-41edf003,.elementor-element-6b081c13,.elementor-element-1a6a69e3{display:none!important}';
    if (! $invitation->livestream_url) {
        $jawaBrandStyles .= '.elementor-element-7c4049b0{display:none!important}';
    }
    $jawaHtml = str_replace('</head>', '<style>[data-id][hidden]{display:none!important}'.$jawaBrandStyles.'</style></head>', $jawaHtml);

    foreach (glob(public_path('images/asetttt/jawa/*')) ?: [] as $jawaAssetPath) {
        $jawaFilename = basename($jawaAssetPath);
        $jawaHtml = str_replace('https://by.memonika.com/wp-content/uploads/2025/08/'.$jawaFilename, asset('images/asetttt/jawa/'.$jawaFilename), $jawaHtml);
    }
    $jawaHtml = str_replace('https://by.memonika.com/wp-content/uploads/2026/04/GIGI568411-2.jpg', $jawaCoverPhoto, $jawaHtml);
    if ($jawaCoverPhoto) {
        $jawaGalleryPhoto = $jawaGalleryPhotos[0] ?? $jawaCoverPhoto;
        $jawaHeroStyle = '<style>
            .elementor-129588 .elementor-element.elementor-element-4f29c25:not(.elementor-motion-effects-element-type-background) > .elementor-widget-wrap,
            .elementor-129588 .elementor-element.elementor-element-4f29c25 > .elementor-widget-wrap > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-color:#403832!important;background-image:url("'.e($jawaCoverPhoto).'")!important;background-repeat:no-repeat!important;background-size:contain!important;background-position:center center!important}
            .elementor-129588 .elementor-element.elementor-element-169b20e0:not(.elementor-motion-effects-element-type-background) > .elementor-widget-wrap,
            .elementor-129588 .elementor-element.elementor-element-169b20e0 > .elementor-widget-wrap > .elementor-motion-effects-container > .elementor-motion-effects-layer{background-image:url("'.e($jawaGalleryPhoto).'")!important}
            .elementor-129588 .elementor-element.elementor-element-75cd4329 > .elementor-element-populated > .elementor-background-overlay{background-image:url("'.e($jawaBridePhoto).'")!important}
            .elementor-129588 .elementor-element.elementor-element-43df39cf > .elementor-element-populated > .elementor-background-overlay{background-image:url("'.e($jawaGroomPhoto).'")!important}
            .elementor-129588 .elementor-element.elementor-element-58f0b4ad > .elementor-element-populated > .elementor-background-overlay{background-image:url("'.e($jawaGalleryPhoto).'")!important}
            .elementor-129588 .jawa-gallery-empty{display:none!important}
            .elementor-129588 .elementor-element.elementor-element-75cd4329,
            .elementor-129588 .elementor-element.elementor-element-43df39cf{overflow:hidden}
        </style>';
        $jawaHtml = str_replace('</head>', $jawaHeroStyle.'</head>', $jawaHtml);
    }
@endphp
{!! $jawaHtml !!}
