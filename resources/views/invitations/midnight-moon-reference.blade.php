@php
    $midnightHtml = file_get_contents(base_path('contohpertama.html'));
    abort_if($midnightHtml === false, 500, 'Template Midnight Moon tidak ditemukan.');

    $midnightEvents = $invitation->events->values();
    $midnightFirstEvent = $midnightEvents->first();
    $midnightSecondEvent = $midnightEvents->get(1);
    $midnightStories = array_values($invitation->love_story ?? []);
    $midnightGuestName = e($guest->name);
    $midnightBrideName = e($invitation->bride_name);
    $midnightGroomName = e($invitation->groom_name);
    $midnightBrideNickname = e($invitation->bride_nickname ?: $invitation->bride_name);
    $midnightGroomNickname = e($invitation->groom_nickname ?: $invitation->groom_name);
    $midnightChildOrderWords = [1 => 'Pertama', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat', 5 => 'Kelima', 6 => 'Keenam', 7 => 'Ketujuh', 8 => 'Kedelapan', 9 => 'Kesembilan', 10 => 'Kesepuluh'];

    $midnightReplaceHeading = function (string $widgetId, string $content) use (&$midnightHtml): void {
        $pattern = '/(<div\b[^>]*data-id="' . preg_quote($widgetId, '/') . '"[^>]*>.*?<h2\b[^>]*>).*?(<\/h2>)/s';
        $midnightHtml = preg_replace_callback($pattern, fn (array $matches): string => $matches[1] . $content . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
    };
    $midnightSetWidgetHref = function (string $widgetId, string $url) use (&$midnightHtml): void {
        $pattern = '/(<div\b[^>]*data-id="' . preg_quote($widgetId, '/') . '"[^>]*>.*?<a\b[^>]*href=["\x27])[^"\x27]*(["\x27])/s';
        $midnightHtml = preg_replace_callback($pattern, fn (array $matches): string => $matches[1] . e($url) . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
    };
    $midnightHideWidget = function (string $widgetId) use (&$midnightHtml): void {
        $pattern = '/(<(?:div|section)\b[^>]*data-id="' . preg_quote($widgetId, '/') . '")(>)/';
        $midnightHtml = preg_replace($pattern, '$1 hidden$2', $midnightHtml, 1) ?? $midnightHtml;
    };

    $midnightHtml = str_replace(
        ['<title>Demo Midnight Moon - Memonika</title>', 'Demo Midnight Moon - Memonika', 'Demo Midnight Moon'],
        ['<title>' . e($invitation->title) . '</title>', e($invitation->title), e($invitation->title)],
        $midnightHtml
    );
    $midnightHtml = str_replace('Nama Tamu', $midnightGuestName, $midnightHtml);
    $midnightHtml = str_replace('Minggu, 6 April 2025', e($midnightFirstEvent?->starts_at?->translatedFormat('l, j F Y') ?? ''), $midnightHtml);
    $midnightHtml = str_replace('6 April 2025', e($midnightFirstEvent?->starts_at?->translatedFormat('j F Y') ?? ''), $midnightHtml);

    foreach ([
        '3d4d1673' => $midnightBrideNickname,
        '30c75c22' => $midnightGroomNickname,
        '7fdc8566' => $midnightBrideNickname,
        '267c1e1d' => $midnightGroomNickname,
        '78e0095e' => $midnightBrideName,
        '48ac4ba4' => $midnightGroomName,
        '235de449' => $midnightBrideNickname . ' &amp; ' . $midnightGroomNickname,
        '624c345c' => $midnightGuestName,
    ] as $midnightWidgetId => $midnightContent) {
        $midnightReplaceHeading($midnightWidgetId, $midnightContent);
    }
    $midnightReplaceHeading('795d4a16', 'Bapak ' . e($invitation->bride_father) . '<br>&amp; Ibu ' . e($invitation->bride_mother));
    $midnightReplaceHeading('511acdf4', 'Bapak ' . e($invitation->groom_father) . '<br>&amp; Ibu ' . e($invitation->groom_mother));
    $midnightReplaceHeading('38aa80bb', 'Putri ' . ($midnightChildOrderWords[$invitation->bride_child_order] ?? '') );
    $midnightReplaceHeading('678e78fe', 'Putra ' . ($midnightChildOrderWords[$invitation->groom_child_order] ?? '') );
    if ($invitation->opening_text) {
        $midnightReplaceHeading('24ba6f15', e($invitation->opening_text));
    }

    if ($midnightFirstEvent) {
        $midnightEventTitle = e($midnightFirstEvent->title);
        $midnightEventTime = ($midnightFirstEvent->starts_at?->format('H.i') ?? '') . ($midnightFirstEvent->ends_at ? ' - ' . $midnightFirstEvent->ends_at->format('H.i') : '') . ' WIB';
        foreach ([
            '20155dc4' => $midnightEventTitle,
            '7805d295' => e($midnightFirstEvent->starts_at?->translatedFormat('l') ?? ''),
            '39a5ce9a' => e($midnightEventTime),
            '59b82850' => e($midnightFirstEvent->starts_at?->translatedFormat('F') ?? ''),
            '23b96c8e' => e($midnightFirstEvent->starts_at?->format('Y') ?? ''),
            '44f2cc4a' => e($midnightFirstEvent->venue_name),
            '297b2088' => e($midnightFirstEvent->address ?: $midnightFirstEvent->venue_name),
            '3f4612a' => e($midnightFirstEvent->starts_at?->translatedFormat('l, j F Y') ?? ''),
        ] as $midnightWidgetId => $midnightContent) {
            $midnightReplaceHeading($midnightWidgetId, $midnightContent);
        }
        $midnightHtml = preg_replace_callback('/(<div\b[^>]*data-id="3d6dcfe1"[^>]*>.*?data-to-value=")\d+(")/s', fn (array $matches): string => $matches[1] . $midnightFirstEvent->starts_at->format('j') . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
        $midnightHtml = preg_replace_callback('/(<div\b[^>]*data-id="154ef7c5"[^>]*>.*?<a\b[^>]*href=["\x27])[^"\x27]*(["\x27])/s', function (array $matches) use ($midnightFirstEvent, $invitation): string {
            $start = $midnightFirstEvent->starts_at?->copy()->utc()->format('Ymd\THis\Z');
            $end = $midnightFirstEvent->ends_at?->copy()->utc()->format('Ymd\THis\Z') ?? $start;
            $url = $start ? 'https://calendar.google.com/calendar/render?' . http_build_query([
                'action' => 'TEMPLATE',
                'text' => $invitation->title,
                'dates' => $start . '/' . $end,
                'details' => $invitation->opening_text ?: 'Undangan pernikahan ' . $invitation->bride_name . ' & ' . $invitation->groom_name,
                'location' => $midnightFirstEvent->venue_name,
            ]) : '#';

            return $matches[1] . e($url) . $matches[2];
        }, $midnightHtml, 1) ?? $midnightHtml;
        $midnightHtml = preg_replace('/(data-date=")\d+(")/', '$1' . $midnightFirstEvent->starts_at->timestamp . '$2', $midnightHtml);
        $midnightHtml = str_replace('data-widget_type="countdown.default"', 'data-widget_type="invitation-countdown.default"', $midnightHtml);
        if ($midnightFirstEvent->maps_url) {
            $midnightSetWidgetHref('350aaaf1', $midnightFirstEvent->maps_url);
        } else {
            $midnightHideWidget('350aaaf1');
        }
    } else {
        foreach (['6da25168', '7a33dd2f'] as $midnightEventWidget) {
            $midnightHideWidget($midnightEventWidget);
        }
    }

    if ($midnightSecondEvent) {
        $midnightSecondTime = ($midnightSecondEvent->starts_at?->format('H.i') ?? '') . ($midnightSecondEvent->ends_at ? ' - ' . $midnightSecondEvent->ends_at->format('H.i') : '') . ' WIB';
        foreach ([
            '4a8040e1' => e($midnightSecondEvent->title),
            '734d40f' => e($midnightSecondEvent->starts_at?->translatedFormat('l') ?? ''),
            '1f838014' => e($midnightSecondTime),
            '53f965c7' => e($midnightSecondEvent->starts_at?->translatedFormat('F') ?? ''),
            '42fbd88f' => e($midnightSecondEvent->starts_at?->format('Y') ?? ''),
            'd832010' => e($midnightSecondEvent->venue_name),
            '222b2d56' => e($midnightSecondEvent->address ?: $midnightSecondEvent->venue_name),
        ] as $midnightWidgetId => $midnightContent) {
            $midnightReplaceHeading($midnightWidgetId, $midnightContent);
        }
        $midnightHtml = preg_replace_callback('/(<div\b[^>]*data-id="9018233"[^>]*>.*?data-to-value=")\d+(")/s', fn (array $matches): string => $matches[1] . $midnightSecondEvent->starts_at->format('j') . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
        if ($midnightSecondEvent->maps_url) {
            $midnightSetWidgetHref('25a64bcd', $midnightSecondEvent->maps_url);
        } else {
            $midnightHideWidget('25a64bcd');
        }
    } else {
        $midnightHideWidget('75a878bd');
    }

    $midnightStoryDefaults = [
        ['Awal Bertemu', 'Tidak ada yang kebetulan di dunia ini, Semua sudah tersusun rapi oleh sang Maha Kuasa. Kita tidak bisa memilih kepada siapa kita tidak akan jatuh cinta. Kami bertemu pada awal tahun 2019, tidak ada yang pernah menyangka bahwa pertemuan ini membawa kami pada suatu ikatan cinta yang suci hari ini.'],
        ['Lamaran', 'Kehendak Nya menuntun kami pada sebuah pertemuan yang tak pernah di sangka hingga akhirnya di pertengahan tahun 2024 kami memantapkan hati untuk membawa hubungan ini kejenjang yang lebih serius dengan mempertemukan kedua orang tua dan keluarga besar dalam silaturahmi dan lamaran'],
        ['Menikah', 'Percayalah, bukan karena bertemu lalu berjodoh tapi karena berjodoh lah maka kami dipertemukan , Atas izin Allah SWT serta restu dan ridho kedua orang tua kami memutuskan untuk mengikrarkan janji suci pernikahan kami di tanggal 6 April 2025 . Serta memulai kisah baru kami dalam suatu ikatan suci pernikahan yang semoga senantiasa diberkahi oleh Allah SWT.'],
    ];
    if ($midnightStories === []) {
        $midnightHideWidget('417a61db');
    } else {
        foreach ($midnightStoryDefaults as $midnightStoryIndex => [$midnightDefaultTitle, $midnightDefaultDescription]) {
            $midnightStory = $midnightStories[$midnightStoryIndex] ?? null;
            if (! $midnightStory) {
                continue;
            }

            $midnightHtml = str_replace('<span>' . $midnightDefaultTitle . '</span>', '<span>' . e($midnightStory['title'] ?? $midnightDefaultTitle) . '</span>', $midnightHtml);
            $midnightHtml = str_replace('<p>' . $midnightDefaultDescription . '</p>', '<p>' . e($midnightStory['description'] ?? '') . '</p>', $midnightHtml);
        }
        $midnightStoryDateIndex = 0;
        $midnightHtml = preg_replace_callback('/<li><\/li>/', function (array $matches) use (&$midnightStoryDateIndex, $midnightStories): string {
            $storyDate = $midnightStories[$midnightStoryDateIndex++]['date'] ?? '';

            return '<li>' . e($storyDate) . '</li>';
        }, $midnightHtml, 3) ?? $midnightHtml;
        $midnightTimelineItemIndex = 0;
        $midnightHtml = preg_replace_callback('/<div class=" weddingpress-timeline-item (?:left-part|right-part)">/', function (array $matches) use (&$midnightTimelineItemIndex, $midnightStories): string {
            $hidden = $midnightTimelineItemIndex++ >= count($midnightStories) ? ' hidden' : '';

            return rtrim(substr($matches[0], 0, -1)) . $hidden . '>';
        }, $midnightHtml, 3) ?? $midnightHtml;
    }

    $midnightGiftAccounts = $invitation->gifts->map(fn ($gift): array => [
        'provider' => $gift->provider,
        'account_name' => $gift->account_name,
        'account_number' => $gift->account_number,
    ])->all();
    if ($midnightGiftAccounts === [] && $invitation->gift_bank_name && $invitation->gift_account_number) {
        $midnightGiftAccounts[] = [
            'provider' => $invitation->gift_bank_name,
            'account_name' => $invitation->gift_account_name,
            'account_number' => $invitation->gift_account_number,
        ];
    }
    $midnightBankLogos = ['bca' => 'bca.webp', 'bni' => 'bni.webp', 'bri' => 'bri.png', 'bsi' => 'bsi.webp', 'btn' => 'btn.webp', 'dana' => 'dana.webp', 'gopay' => 'gopay.webp', 'mandiri' => 'mandiri.webp', 'ovo' => 'ovo.webp', 'seabank' => 'seabank.webp', 'shopeepay' => 'shopeepay.webp'];
    foreach ([
        ['section' => '38afbceb', 'logo' => '6df078fc', 'number' => '10bbb6f0', 'name' => '695771e7', 'copy' => '6267080e'],
        ['section' => '5c1f3f46', 'logo' => '3a6ee07e', 'number' => '119bebc7', 'name' => '4ecd065a', 'copy' => '3f8957c4'],
    ] as $midnightGiftIndex => $midnightGiftWidgets) {
        $midnightGift = $midnightGiftAccounts[$midnightGiftIndex] ?? null;
        if (! $midnightGift) {
            $midnightHideWidget($midnightGiftWidgets['section']);
            continue;
        }

        $midnightReplaceHeading($midnightGiftWidgets['number'], e($midnightGift['account_number']));
        $midnightReplaceHeading($midnightGiftWidgets['name'], e($midnightGift['account_name'] ?: ''));
        $midnightCopyPattern = '/(<div\b[^>]*data-id="' . preg_quote($midnightGiftWidgets['copy'], '/') . '"[^>]*>.*?<div class="copy-content spancontent"[^>]*>).*?(<\/div>)/s';
        $midnightHtml = preg_replace_callback($midnightCopyPattern, fn (array $matches): string => $matches[1] . e($midnightGift['account_number']) . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
        $midnightProvider = strtolower(preg_replace('/[^a-z0-9]/i', '', $midnightGift['provider']));
        if (isset($midnightBankLogos[$midnightProvider])) {
            $midnightLogoUrl = e(asset('images/bank/' . $midnightBankLogos[$midnightProvider]));
            $midnightLogoPattern = '/(<div\b[^>]*data-id="' . preg_quote($midnightGiftWidgets['logo'], '/') . '"[^>]*>.*?<img\b[^>]*src=")[^"]+("[^>]*>)/s';
            $midnightHtml = preg_replace_callback($midnightLogoPattern, fn (array $matches): string => $matches[1] . $midnightLogoUrl . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
            $midnightHtml = preg_replace_callback('/(<div\b[^>]*data-id="' . preg_quote($midnightGiftWidgets['logo'], '/') . '"[^>]*>.*?<img\b[^>]*)(>)/s', fn (array $matches): string => preg_replace('/\s+(?:srcset|sizes)="[^"]*"/', '', $matches[1]) . $matches[2], $midnightHtml, 1) ?? $midnightHtml;
        }
    }
    if ($invitation->gift_delivery_address) {
        $midnightReplaceHeading('173de054', $midnightBrideName . '<br>' . e($invitation->gift_delivery_address));
    } else {
        foreach (['659578d0', '173de054'] as $midnightAddressWidget) {
            $midnightHideWidget($midnightAddressWidget);
        }
    }
    if ($midnightGiftAccounts === [] && ! $invitation->gift_delivery_address) {
        $midnightHideWidget('7b4f8a49');
    }

    if ($invitation->livestream_url) {
        $midnightSetWidgetHref('212447c6', $invitation->livestream_url);
    } else {
        $midnightHideWidget('527378d4');
    }
    foreach (['1171b9d7', '1da8ec7', '4db84238'] as $midnightBrandWidget) {
        $midnightHideWidget($midnightBrandWidget);
    }
    $midnightReplaceHeading('5414f6f4', 'You Are The Reason<br>Calum Scott (Violin Cover)');
    foreach ([
        ['id' => '3f28b01a', 'url' => $invitation->bride_instagram],
        ['id' => '669829e8', 'url' => $invitation->groom_instagram],
    ] as $midnightInstagram) {
        if ($midnightInstagram['url']) {
            $midnightSetWidgetHref($midnightInstagram['id'], $midnightInstagram['url']);
        } else {
            $midnightHideWidget($midnightInstagram['id']);
        }
    }

    $midnightMusicUrl = $invitation->music_file
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file)
        : asset('images/asetttt/' . rawurlencode('You Are The Reason - Calum Scott - violin cover [-_Yjcf8dbOo].mp3'));
    $midnightHtml = str_replace('https://by.memonika.com/wp-content/uploads/2025/08/You-Are-The-Reason-Calum-Scott-violin-cover.mp3', e($midnightMusicUrl), $midnightHtml);
    foreach (glob(public_path('images/asetttt/*')) ?: [] as $midnightAssetPath) {
        $midnightAssetName = basename($midnightAssetPath);
        $midnightHtml = str_replace(
            'https://by.memonika.com/wp-content/uploads/2025/08/' . $midnightAssetName,
            asset('images/asetttt/' . rawurlencode($midnightAssetName)),
            $midnightHtml
        );
    }

    $midnightWishMarkup = '<div class="cui-wrapper cui-facebook cui-border" style="overflow:hidden"><div class="cui-wrap-link"><div class="header-cui"><a id="cui-link-' . $invitation->id . '" class="cui-link cui-icon-link cui-icon-link-true" href="#ucapan"><span>' . $invitation->wishes->count() . '</span> Ucapan</a></div></div><div id="cui-wrap-commnent-' . $invitation->id . '" class="cui-wrap-comments" style="display:block"><div id="cui-wrap-form-' . $invitation->id . '" class="cui-clearfix"><div class="cui-comment-attendence"><div id="invitation-count-' . $invitation->id . '" class="cui_comment_count_card_wrap"><div class="cui_comment_count_card_row_2"><div class="cui_comment_count_card cui_card-hadir"><span>' . (int) ($invitation->attending_guests_count ?? 0) . '</span><span>Hadir</span></div><div class="cui_comment_count_card cui_card-tidak_hadir"><span>' . (int) ($invitation->declined_guests_count ?? 0) . '</span><span>Tidak hadir</span></div></div></div></div>';
    $midnightWishMarkup .= '<div class="cui-clearfix cui-wrap-form"><form class="rsvp-form cui-form" action="' . e(route('invitations.public.rsvp', [$invitation->slug, $guest->token])) . '" method="post"><input type="hidden" name="_token" value="' . e(csrf_token()) . '"><label for="midnight-rsvp">Konfirmasi kehadiran</label><select id="midnight-rsvp" name="rsvp_status" class="waci_comment cui-select" required><option value="">Pilih jawaban</option><option value="attending" ' . ($guest->rsvp_status === 'attending' ? 'selected' : '') . '>Hadir</option><option value="declined" ' . ($guest->rsvp_status === 'declined' ? 'selected' : '') . '>Tidak hadir</option></select><label for="midnight-party-size">Jumlah yang hadir</label><select id="midnight-party-size" name="party_size" class="waci_comment cui-select">';
    for ($midnightPartySize = 1; $midnightPartySize <= 10; $midnightPartySize++) {
        $midnightWishMarkup .= '<option value="' . $midnightPartySize . '" ' . ((int) $guest->party_size === $midnightPartySize ? 'selected' : '') . '>' . $midnightPartySize . ' orang</option>';
    }
    $midnightWishMarkup .= '</select><button class="cui-form-btn" type="submit">Simpan kehadiran</button></form><form id="commentform-' . $invitation->id . '" class="wish-form cui-form" action="' . e(route('invitations.public.wishes.store', [$invitation->slug, $guest->token])) . '" method="post"><input type="hidden" name="_token" value="' . e(csrf_token()) . '"><label for="midnight-wish-name">Nama</label><input id="midnight-wish-name" class="cui-input" value="' . $midnightGuestName . '" readonly><label for="midnight-wish-message">Ucapan</label><textarea id="midnight-wish-message" class="waci_comment cui-textarea autosize-textarea" name="message" maxlength="600" placeholder="Tuliskan doa terbaikmu..." required></textarea><button class="cui-form-btn" type="submit">Kirim ucapan</button></form></div><div id="cui-box" class="cui-box"><ul id="cui-container-comment-' . $invitation->id . '" class="cui-container-comments cui-order-DESC" data-order="DESC">';
    foreach ($invitation->wishes as $midnightWish) {
        $midnightWishMarkup .= '<li class="cui-item-comment"><div class="cui-comment-content"><strong>' . e($midnightWish->guest->name) . '</strong><p>' . nl2br(e($midnightWish->message)) . '</p></div></li>';
    }
    $midnightWishMarkup .= '</ul></div></div></div><!--.cui-wrapper-->';
    $midnightWishStart = strpos($midnightHtml, "<div class='cui-wrapper cui-facebook cui-border");
    $midnightWishEndMarker = '</div><!--.cui-wrapper-->';
    $midnightWishEnd = $midnightWishStart === false ? false : strpos($midnightHtml, $midnightWishEndMarker, $midnightWishStart);
    if ($midnightWishStart !== false && $midnightWishEnd !== false) {
        $midnightHtml = substr_replace($midnightHtml, $midnightWishMarkup, $midnightWishStart, $midnightWishEnd + strlen($midnightWishEndMarker) - $midnightWishStart);
    }
    foreach ([
        "'cui-link-23618'" => "'cui-link-{$invitation->id}'",
        "'invitation-count-23618'" => "'invitation-count-{$invitation->id}'",
        "'commentform-23618'" => "'commentform-{$invitation->id}'",
    ] as $midnightSourceId => $midnightInvitationId) {
        $midnightHtml = str_replace($midnightSourceId, $midnightInvitationId, $midnightHtml);
    }
    if ($midnightFirstEvent) {
        $midnightCountdownScript = '<script>(function(){var target=' . (int) $midnightFirstEvent->starts_at->timestamp . '*1000;function update(){var remaining=Math.max(0,Math.floor((target-Date.now())/1000));var values={"days":Math.floor(remaining/86400),"hours":Math.floor(remaining%86400/3600),"minutes":Math.floor(remaining%3600/60),"seconds":remaining%60};Object.keys(values).forEach(function(unit){document.querySelectorAll(".elementor-countdown-"+unit).forEach(function(element){var digits=element.classList.contains("elementor-countdown-digits")?element:element.querySelector(".elementor-countdown-digits");if(digits){digits.textContent=String(values[unit]).padStart(2,"0");}});});}update();window.setInterval(update,1000);})();</script>';
        $midnightHtml = str_replace('</body>', $midnightCountdownScript . '</body>', $midnightHtml);
    }
    $midnightRemoveWidgets = ['.elementor-element-1171b9d7', '.elementor-element-1da8ec7', '.elementor-element-4db84238'];
    if (! $invitation->livestream_url) {
        $midnightRemoveWidgets[] = '.elementor-element-527378d4';
    }
    if ($midnightGiftAccounts === [] && ! $invitation->gift_delivery_address) {
        $midnightRemoveWidgets[] = '.elementor-element-7b4f8a49';
    }
    if (! isset($midnightGiftAccounts[1])) {
        $midnightRemoveWidgets[] = '.elementor-element-5c1f3f46';
    }
    if (! $invitation->bride_instagram) {
        $midnightRemoveWidgets[] = '.elementor-element-3f28b01a';
    }
    if (! $invitation->groom_instagram) {
        $midnightRemoveWidgets[] = '.elementor-element-669829e8';
    }
    $midnightCleanupScript = '<script>document.querySelectorAll(' . json_encode(implode(',', $midnightRemoveWidgets)) . ').forEach(function(widget){widget.remove();});</script>';
    $midnightHtml = str_replace('</body>', $midnightCleanupScript . '</body>', $midnightHtml);
    $midnightHtml = str_replace('</head>', '<style>[data-id][hidden]{display:none!important}</style></head>', $midnightHtml);
    $midnightHtml = preg_replace_callback(
        '/<script\b(?=[^>]*\bsrc=["\']https?:\/\/)[^>]*>/i',
        static fn (array $matches): string => preg_match('/\b(?:async|defer)\b/i', $matches[0])
            ? $matches[0]
            : preg_replace('/^<script\b/i', '<script defer', $matches[0]),
        $midnightHtml,
    ) ?? $midnightHtml;
@endphp
{!! $midnightHtml !!}
