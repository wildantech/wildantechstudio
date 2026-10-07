@php
    $jawaAsset = fn (string $file) => asset('images/asetttt/jawa/'.$file);
    $jawaFirstEvent = $invitation->events->first(fn ($event): bool => $event->starts_at !== null);
    $jawaCoverImage = $invitation->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image) : ($invitation->bride_photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) : ($invitation->groom_photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) : $jawaAsset('JAWA-FALLBACK.jpg')));
    $jawaFeatureImage = $invitation->cover_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->cover_image) : (($invitation->gallery_images[0] ?? null) ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->gallery_images[0]) : $jawaCoverImage);
    $jawaGalleryImages = array_values(array_unique(array_filter([$invitation->cover_image, $invitation->bride_photo, $invitation->groom_photo, ...($invitation->gallery_images ?? [])])));
    $jawaGiftImages = array_values(array_unique(array_filter([$invitation->bride_photo, $invitation->groom_photo, ...($invitation->gallery_images ?? []), $invitation->cover_image])));
    if ($jawaGiftImages === []) {
        $jawaGiftImages = array_filter([$invitation->cover_image ?: $invitation->bride_photo ?: $invitation->groom_photo]);
    }
    $jawaGiftImageUrls = array_values(array_filter(array_map(fn (?string $image): ?string => $image ? \Illuminate\Support\Facades\Storage::disk('public')->url($image) : null, $jawaGiftImages)));
    if ($jawaGiftImageUrls === []) {
        $jawaGiftImageUrls = [$jawaFeatureImage];
    }
    $jawaBrideDisplayName = $invitation->bride_nickname ?: $invitation->bride_name;
    $jawaGroomDisplayName = $invitation->groom_nickname ?: $invitation->groom_name;
    $jawaOrderWords = [1 => 'Pertama', 2 => 'Kedua', 3 => 'Ketiga', 4 => 'Keempat', 5 => 'Kelima', 6 => 'Keenam', 7 => 'Ketujuh', 8 => 'Kedelapan', 9 => 'Kesembilan', 10 => 'Kesepuluh'];
    $jawaBankLogos = ['bca' => 'bca.webp', 'bni' => 'bni.webp', 'bri' => 'bri.png', 'bsi' => 'bsi.webp', 'btn' => 'btn.webp', 'dana' => 'dana.webp', 'gopay' => 'gopay.webp', 'mandiri' => 'mandiri.webp', 'ovo' => 'ovo.webp', 'seabank' => 'seabank.webp', 'shopeepay' => 'shopeepay.webp'];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#171711">
    <title>{{ $invitation->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root{color-scheme:light;--jawa-ink:#30251e;--jawa-gold:#b49150;--jawa-paper:#fffaf0;--jawa-deep:#39271f}
        *{box-sizing:border-box}
        html{scroll-behavior:smooth}
        body.jawa-page{margin:0;background:#17120f;color:var(--jawa-ink);font-family:Georgia,'Times New Roman',serif}
        body.jawa-page.jawa-locked{height:100svh;overflow:hidden}
        .jawa-page button,.jawa-page input,.jawa-page textarea,.jawa-page select{font:inherit}
        .jawa-shell{width:min(100%,520px);margin:auto;overflow:clip;background:#17120f;box-shadow:0 0 0 1px #bda97955}
        .jawa-section{position:relative;isolation:isolate;min-height:540px;padding:76px 28px;background-color:var(--jawa-paper);background-image:url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}');background-size:cover;background-position:center;color:var(--jawa-ink);text-align:center;overflow:hidden}
        .jawa-section--dark{background-color:#493126;background-image:linear-gradient(#38251de8,#38251de8),url('{{ asset('images/asetttt/jawa/JAWA-PATTERN.png') }}');background-size:auto,220px;color:#f7f0df}
        .jawa-section--paper{background-color:#fffaf0;background-image:linear-gradient(#fffaf0e8,#fffaf0e8),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}');background-size:cover}
        .jawa-section--cover{display:grid;align-items:stretch;min-height:100svh;padding:7vh 24px 5vh;background-image:linear-gradient(180deg,#241b19aa 0%,#241b1966 38%,#150f0ccc 100%),url('{{ $jawaCoverImage }}');background-position:center;background-size:cover;color:#fff7e9}
        .jawa-cover-frame{position:relative;display:flex;flex-direction:column;justify-content:flex-start;align-items:center;min-height:88svh;padding:4vh 24px 2vh;border:0;border-radius:0;background:transparent;overflow:hidden}
        .jawa-cover-frame:before,.jawa-cover-frame:after{display:none}
        .jawa-wayang{position:absolute;right:-12px;bottom:4%;width:min(45%,190px);height:34%;object-fit:contain;object-position:bottom;opacity:.62;pointer-events:none}
        .jawa-cover-kicker,.jawa-eyebrow{font-size:11px;letter-spacing:.22em;text-transform:uppercase}
        .jawa-cover-kicker{margin:8px 0 3px;font-family:'Brush Script MT','Segoe Script',cursive;font-size:18px;font-style:italic;letter-spacing:0;text-transform:none}
        .jawa-cover-names{margin:0 0 6px;font-size:clamp(24px,7vw,32px);font-weight:400;line-height:1.1}
        .jawa-cover-names span{display:inline;margin:0 5px;font-size:.78em;font-style:italic}
        .jawa-cover-date{margin:0 0 24px;font-size:14px;letter-spacing:.08em}
        .jawa-button{display:inline-flex;align-items:center;justify-content:center;min-height:42px;padding:0 23px;border:1px solid var(--jawa-gold);border-radius:2px;background:#211e17;color:#fff8e9;text-decoration:none;text-transform:uppercase;font-size:11px;letter-spacing:.08em;cursor:pointer}
        .jawa-open{min-height:42px;border:1px solid #d4bb7b;border-radius:28px;background:#bda166;color:#fff9eb}
        .jawa-guest{max-width:290px;margin:auto 0 18px;color:#fff8e9;font-size:13px;font-weight:600;line-height:1.45;text-shadow:0 1px 4px #21140f}
        .jawa-opened[hidden]{display:none}
        .jawa-opened{animation:jawa-appear .8s ease both}
        @keyframes jawa-appear{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:none}}
        .jawa-motion-layer[hidden],.jawa-welcome[hidden]{display:none}
        .jawa-motion-layer{position:fixed;z-index:50;inset:0;background:#17120f}
        .jawa-motion-layer video{width:100%;height:100%;object-fit:cover}
        .jawa-welcome{position:fixed;z-index:60;inset:0;display:grid;place-items:center;padding:28px;background:#100b09c9;backdrop-filter:blur(8px)}
        .jawa-welcome-card{width:min(100%,420px);padding:42px 26px;border:1px solid #d2b56f;border-radius:160px 160px 26px 26px;background:linear-gradient(#fffaf0ed,#fffaf0f4),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}') center/cover;text-align:center;box-shadow:0 24px 80px #0008;animation:jawa-welcome-in .65s cubic-bezier(.2,.7,.2,1) both}
        @keyframes jawa-welcome-in{from{opacity:0;transform:translateY(12px) scale(.985)}to{opacity:1;transform:none}}
        .jawa-welcome-card img{width:62px;height:82px;object-fit:contain}
        .jawa-welcome-card h2{margin:14px 0 10px;font-family:'Brush Script MT','Segoe Script',cursive;font-size:34px;font-style:italic;font-weight:400}
        .jawa-welcome-card p{margin:8px 0;line-height:1.55}
        .jawa-reveal{position:relative;opacity:0;transform:translateY(24px) scale(.99);transition:opacity .7s ease,transform .85s cubic-bezier(.2,.7,.2,1)}
        .jawa-reveal.active{transform:translateY(0);opacity:1}
        .jawa-scroll-hint{display:none}
        .jawa-intro{display:grid;align-content:center;min-height:100svh;padding:70px 25px;background-image:linear-gradient(#2b1b1840,#2b1b1840),url('{{ asset('images/asetttt/jawa/JAWA-FALLBACK.jpg') }}');background-size:cover;background-position:center;color:#f9eac2;text-shadow:0 1px 5px #342018}
        .jawa-intro:before{display:none}
        .jawa-intro .jawa-eyebrow{font-family:'Brush Script MT','Segoe Script',cursive;font-size:19px;font-style:italic;letter-spacing:0;text-transform:none}
        .jawa-intro .jawa-section-title{margin:12px auto;font-size:clamp(32px,9vw,46px);line-height:1.02}
        .jawa-intro .jawa-amp{display:inline-block;margin:4px 0;color:#e1bf70}
        .jawa-intro .jawa-cover-date{font-weight:600;letter-spacing:.22em}
        .jawa-intro .jawa-gunungan{width:54px;height:75px;object-fit:contain;margin:6px auto 0;filter:drop-shadow(0 6px 6px #34281726)}
        .jawa-intro-verse{max-width:360px;margin:22px auto;font-size:14px;line-height:1.8}
        .jawa-intro cite{font-size:12px;font-weight:bold;font-style:normal;letter-spacing:.12em}
        .jawa-motif{position:absolute;z-index:-1;right:-30px;bottom:-35px;width:min(240px,58vw);opacity:.68;pointer-events:none}
        .jawa-motif--top{top:0;right:-10px;bottom:auto;width:min(210px,50vw);transform:rotate(180deg)}
        .jawa-section-title{margin:0 0 12px;font-size:clamp(34px,9vw,48px);font-weight:400;line-height:1.05}
        .jawa-subtitle{margin:0 0 30px;color:#766345;font-size:13px;letter-spacing:.12em;text-transform:uppercase}
        .jawa-couple{min-height:900px;padding:44px 18px 62px;background-image:url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}');background-position:center;background-size:cover;color:#30251e}
        .jawa-couple-panel{position:relative;max-width:470px;margin:0 auto;padding:44px 20px 42px;border:2px solid #c8a965;border-radius:150px 150px 100px 100px / 115px 115px 65px 65px;background:linear-gradient(#fffaf0ed,#fffaf0ef),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}') center / cover;box-shadow:inset 0 0 0 5px #fff9ea,0 16px 35px #39271938;overflow:hidden}
        .jawa-profile-gunungan{display:block;width:72px;height:98px;object-fit:contain;margin:0 auto 14px}
        .jawa-profile-heading{font-family:'Brush Script MT','Segoe Script',cursive;font-size:clamp(30px,8vw,40px);font-style:italic;font-weight:400;line-height:1.15}
        .jawa-feature{min-height:100svh;padding:24px 20px 54px;background-color:#4a3023;background-image:linear-gradient(#4a3023e8,#4a3023e8),url('{{ asset('images/asetttt/jawa/JAWA-PATTERN.png') }}');background-position:center;background-size:auto,210px;background-blend-mode:normal,soft-light;color:#2f251c}
        .jawa-feature-photo{width:100%;height:min(64svh,560px);overflow:hidden;border:7px solid #e9e0d4;border-bottom-width:0;border-radius:16px 16px 10px 10px;background:#c9bcb0}
        .jawa-feature-photo img{width:100%;height:100%;display:block;object-fit:cover;object-position:center 32%}
        .jawa-feature-verse{position:relative;max-width:440px;margin:0 auto;padding:30px 22px 38px;border:1px solid #c2a35f;border-radius:0 0 14px 14px;background:linear-gradient(#fffaf0ee,#fffaf0f5),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}') center / cover;box-shadow:0 12px 26px #21130940}
        .jawa-feature-verse .jawa-gunungan{position:relative;display:block;width:95px;height:62px;object-fit:contain;margin:-6px auto 16px}
        .jawa-feature-verse .jawa-monogram{margin:10px 0;font-size:clamp(30px,8vw,42px);letter-spacing:.18em}
        .jawa-photo-transition{min-height:60svh;padding:0;background:linear-gradient(0deg,#43291de8 0%,#43291d00 62%),url('{{ $jawaFeatureImage }}') center 30% / cover no-repeat}
        .jawa-save-photos{display:grid;grid-template-columns:1fr 1fr;align-items:center;gap:12px;min-height:66svh;padding:56px 20px;background:linear-gradient(180deg,#43291d00,#43291d55),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}') center/cover}
        .jawa-save-photos figure{position:relative;height:min(54svh,480px);margin:0;overflow:hidden;border:1px solid #d9bd78;border-radius:140px 140px 22px 22px;background:#4a3023;box-shadow:0 14px 32px #20120a44}
        .jawa-save-photos figure:after{position:absolute;inset:0;content:"";background:linear-gradient(180deg,#1c100000 58%,#38251d99);pointer-events:none}
        .jawa-save-photos img{width:100%;height:100%;object-fit:cover;object-position:center top;mask-image:linear-gradient(180deg,#000 0%,#000 65%,#0008 83%,transparent 100%)}
        .jawa-date-section{min-height:430px;padding:55px 22px 46px;background:#4a2e20;color:#fff5df}
        .jawa-date-section .jawa-gunungan{width:66px;height:85px;object-fit:contain;margin:0 auto 16px}
        .jawa-date-section .jawa-section-title,.jawa-script-title{font-family:'Brush Script MT','Segoe Script',cursive;font-size:clamp(32px,9vw,46px);font-style:italic;font-weight:400}
        .jawa-countdown div{min-width:0;flex:1;max-width:82px;border:0;border-radius:10px;background:#d3b677;color:#fff;font-family:Georgia,'Times New Roman',serif}
        .jawa-countdown strong{font-size:22px}.jawa-countdown span{font-size:11px;letter-spacing:0;text-transform:none}
        .jawa-live-card,.jawa-blessing-card{max-width:440px;margin:12px auto;padding:28px 22px;border:2px solid #c9a85f;border-radius:18px;background:linear-gradient(#fffaf0ef,#fffaf0f7),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}') center / cover;color:#30251e;box-shadow:0 10px 26px #35231924}
        .jawa-live-card .jawa-button,.jawa-person .jawa-button{min-height:34px;border:0;border-radius:24px;background:#bda166;color:#fff}
        .jawa-blessing-card{margin-top:20px}
        .jawa-blessing-arabic{margin:16px 0;font-size:clamp(23px,6vw,30px);line-height:1.9}
        .jawa-gallery-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:8px;max-width:460px;margin:22px auto}
        .jawa-gallery-grid img{display:block;width:100%;height:220px;object-fit:cover;border-radius:4px}
        .jawa-story{border:1px solid #c5a55e;border-radius:12px;border-left:1px solid #c5a55e;background:#fffaf0;color:#312b20}
        .jawa-gift-panel{margin-top:18px}
        .jawa-gift-toggle{border-radius:24px;background:#c6a866;color:#fff}
        .jawa-wishes-section{background-image:linear-gradient(#fffaf0ed,#fffaf0ed),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}');background-position:center;background-size:cover}
        .jawa-person{max-width:370px;margin:22px auto 32px}
        .jawa-person:before,.jawa-person:after{position:absolute;z-index:0;content:"";background-position:center;background-repeat:no-repeat;background-size:contain;pointer-events:none}
        .jawa-person:before{top:35%;left:-18px;width:80px;height:180px;background-image:url('{{ asset('images/asetttt/jawa/JAWA-COUPLE-1.png') }}')}
        .jawa-person:after{right:-12px;bottom:4px;width:105px;height:120px;background-image:url('{{ asset('images/asetttt/jawa/JAWA-COUPLE-2.png') }}')}
        .jawa-person img{display:block;width:min(190px,58vw);height:245px;object-fit:cover;object-position:center top;margin:18px auto 13px;border:2px solid #c3a25d;border-radius:100px 100px 58px 58px;background:#b6a99c;box-shadow:0 8px 19px #3223153d}
        .jawa-person img,.jawa-person h3,.jawa-person p,.jawa-person a{position:relative;z-index:1}
        .jawa-person--groom:before{right:-18px;left:auto;background-image:url('{{ asset('images/asetttt/jawa/JAWA-COUPLE-3.png') }}')}
        .jawa-person--groom:after{right:auto;left:-12px;transform:scaleX(-1)}
        .jawa-person h3{margin:5px 0 9px;font-size:clamp(26px,7vw,34px);font-family:'Brush Script MT','Segoe Script',cursive;font-style:italic;font-weight:400}
        .jawa-person .jawa-full-name{font-family:Georgia,'Times New Roman',serif;font-size:17px;font-style:normal;font-weight:500}
        .jawa-person p{margin:0;font-size:14px;line-height:1.65}
        .jawa-amp{margin:18px 0;color:#97743a;font-size:37px;font-style:italic}
        .jawa-divider{width:115px;height:1px;margin:28px auto;background:linear-gradient(90deg,transparent,var(--jawa-gold),transparent)}
        .jawa-countdown{display:flex;justify-content:center;gap:9px;margin:24px 0}
        .jawa-countdown div{display:grid;min-width:62px;padding:12px 8px;border:1px solid #a88b5a;background:#1b1a13;color:#f5eddd}
        .jawa-countdown strong{font-size:23px;font-weight:400}.jawa-countdown span{font-size:10px;letter-spacing:.1em;text-transform:uppercase}
        .jawa-date-section .jawa-countdown div{min-width:0;flex:1;max-width:82px;border:0;border-radius:10px;background:#d3b677;color:#fff}
        .jawa-date-section .jawa-countdown strong{font-size:22px}
        .jawa-date-section .jawa-countdown span{font-size:11px;letter-spacing:0;text-transform:none}
        .jawa-events{padding-bottom:90px;background-image:linear-gradient(#4a3023e8,#4a3023e8),url('{{ asset('images/asetttt/jawa/JAWA-PATTERN.png') }}');background-position:center;background-size:auto,240px;color:#fff4da}
        .jawa-event{position:relative;max-width:390px;margin:18px auto;padding:24px 19px;border:1px solid #c5a35b;border-radius:14px;background:linear-gradient(#fffaf0ef,#fffaf0f8),url('{{ asset('images/asetttt/jawa/JAWA-BACKGROUND.jpg') }}') center / cover;color:#30251e;box-shadow:0 8px 22px #21190c24}
        .jawa-event h3{margin:8px 0;font-size:22px;font-weight:400}
        .jawa-event p{margin:8px 0;font-size:13px;line-height:1.65}
        .jawa-stream{display:inline-block;margin-top:18px}
        .jawa-story-list{max-width:380px;margin:30px auto;text-align:left}
        .jawa-story{position:relative;margin:0 0 14px 13px;padding:18px 19px;border-left:1px solid #af8e54;background:#f7f1e6;color:#312b20}
        .jawa-story h3{margin:0 0 7px;font-size:19px;font-weight:400}.jawa-story p{margin:0;font-size:13px;line-height:1.65}
        .jawa-form{max-width:390px;margin:22px auto;padding:20px;border:1px solid #cdbb99;background:#f8f3e9;color:#27231b;text-align:left}
        .jawa-form input,.jawa-form textarea,.jawa-form select{display:block;width:100%;margin:0 0 12px;padding:12px;border:1px solid #d6c9b1;border-radius:2px;background:#fffdf8;color:#29251d;font-size:14px}
        .jawa-form textarea{min-height:100px;resize:vertical}.jawa-form button{margin-top:3px}
        .jawa-rsvp-count{display:flex;justify-content:center;gap:10px;margin:20px auto}.jawa-rsvp-count span{min-width:115px;padding:12px;border:1px solid #b59a68;background:#fffaf0;font:13px Arial,sans-serif}
        .jawa-wish{margin:12px 0;padding:13px;border-bottom:1px solid #d6c7ac;text-align:left}.jawa-wish strong{font-size:14px}.jawa-wish p{margin:7px 0;font-size:13px;line-height:1.6}
        .jawa-gifts{display:grid;gap:14px;max-width:390px;margin:25px auto}
        .jawa-gift-panel{display:grid;grid-template-rows:0fr;opacity:0;transition:grid-template-rows 1.5s ease,opacity 1.5s ease}
        .jawa-gift-panel.is-open{grid-template-rows:1fr;opacity:1}
        .jawa-gift-panel-inner{min-height:0;overflow:hidden}
        .jawa-gift-toggle[aria-expanded="true"]{background:#a98545;color:#171711}
        .jawa-gift{padding:20px;border:1px solid #b69a64;background:#f8f3e9;color:#312a1d}
        .jawa-gift strong,.jawa-gift span,.jawa-gift small{display:block;margin:5px}
        .jawa-gift button{margin-top:10px;padding:8px 15px;border:1px solid #9d804f;background:#29251d;color:white;cursor:pointer}
        .jawa-gift-section{min-height:150svh;overflow:visible;background-color:#39271f;background-image:linear-gradient(#39271f66,#39271f99),url('{{ asset('images/asetttt/jawa/JAWA-PATTERN.png') }}');background-size:auto,240px}
        .jawa-gift-photo-deck{position:sticky;z-index:0;top:12svh;height:72svh;margin:0 0 -56svh;overflow:hidden;pointer-events:none}
        .jawa-gift-photo{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 30%;opacity:0;filter:blur(1.5px);transition:opacity 1s ease,filter 1.3s ease;mask-image:linear-gradient(90deg,transparent 0%,#000 13%,#000 87%,transparent 100%),linear-gradient(180deg,transparent 0%,#000 18%,#000 73%,transparent 100%);mask-composite:intersect}
        .jawa-gift-photo.is-active{opacity:.72;filter:blur(0)}
        .jawa-gift-section .jawa-live-card,.jawa-gift-section>.jawa-script-title{position:relative;z-index:1}
        .jawa-footer{position:relative;z-index:0;min-height:520px;display:grid;align-content:center;background:#38251d;color:#f8f0df}
        .jawa-footer:before{position:absolute;z-index:-1;inset:0;content:"";background-image:linear-gradient(180deg,#38251d80 0%,#38251d33 40%,#38251deb 96%),url('{{ $jawaFeatureImage }}');background-size:cover;background-position:center 28%;filter:blur(2px);mask-image:linear-gradient(90deg,transparent 0%,#000 12%,#000 88%,transparent 100%),linear-gradient(180deg,transparent 0%,#000 20%,#000 68%,transparent 100%);mask-composite:intersect}
        .jawa-footer img{width:130px;height:220px;object-fit:contain;margin:0 auto 22px}
        .jawa-footer img:last-child{width:42px;height:42px;margin:24px auto 0}
        .jawa-footer h2{margin:18px 0;font-size:34px;font-weight:400}
        .jawa-music{position:fixed;z-index:20;right:max(16px,calc((100vw - 520px)/2 + 16px));bottom:18px;width:40px;height:40px;border:0;border-radius:50%;background:#1d1712;color:#fff8ea;font-size:16px;box-shadow:0 2px 9px #0005}
        .jawa-music.is-playing{animation:jawa-music-turn 7s linear infinite}
        @keyframes jawa-music-turn{to{transform:rotate(360deg)}}
        @media(max-width:380px){.jawa-section{padding-right:20px;padding-left:20px}.jawa-cover-frame{padding-right:8px;padding-left:8px}.jawa-person:before{left:-13px;width:64px}.jawa-person:after{right:-9px;width:86px;height:100px}.jawa-gallery-grid img{height:175px}}
        @media(prefers-reduced-motion:reduce){html{scroll-behavior:auto}.jawa-opened,.jawa-welcome-card,.jawa-music.is-playing{animation:none}.jawa-reveal{opacity:1;transform:none;transition:none}}
    </style>
</head>
<body class="jawa-page jawa-locked">
<div class="jawa-shell">
    <section class="jawa-section jawa-section--cover" id="jawa-cover">
        <div class="jawa-cover-frame">
            <p class="jawa-cover-kicker">The Wedding Of</p>
            <h1 class="jawa-cover-names">{{ $jawaBrideDisplayName }}<span>&amp;</span>{{ $jawaGroomDisplayName }}</h1>
            @if ($jawaFirstEvent?->starts_at)<p class="jawa-cover-date">{{ $jawaFirstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif
            <p class="jawa-guest">Kepada Yth.<br>Bapak/Ibu/Saudara/i<br><strong>{{ $guest->name }}</strong></p>
            <button class="jawa-button jawa-open" id="jawa-open" type="button">✉ Buka Undangan</button>
        </div>
        <span class="jawa-scroll-hint" aria-hidden="true">JAWA HERITAGE · SCROLL</span>
    </section>

    <div class="jawa-motion-layer" id="jawa-motion-layer" hidden aria-hidden="true">
        <video id="jawa-motion-video" muted playsinline preload="metadata" aria-label="Animasi pembuka undangan">
            <source src="https://memonika.com/wp-content/uploads/2024/11/01.-JAWA-MOTION-COMPRESS.mp4" type="video/mp4">
        </video>
    </div>
    <div class="jawa-welcome" id="jawa-welcome" hidden>
        <article class="jawa-welcome-card" role="dialog" aria-modal="true" aria-labelledby="jawa-welcome-title">
            <img src="{{ $jawaAsset('JAWA-GUNUNGAN.png') }}" alt="" aria-hidden="true">
            <p class="jawa-eyebrow">The Wedding Of</p>
            <h2 id="jawa-welcome-title">{{ $jawaBrideDisplayName }}<br>&amp;<br>{{ $jawaGroomDisplayName }}</h2>
            @if ($jawaFirstEvent?->starts_at)<p>{{ $jawaFirstEvent->starts_at->translatedFormat('l, d F Y') }}</p>@endif
            <button class="jawa-button jawa-open" id="jawa-enter" type="button">Buka Undangan</button>
        </article>
    </div>

    <main class="jawa-opened" id="jawa-content" hidden>
        <section class="jawa-section jawa-section--paper jawa-intro" id="jawa-intro">
            <p class="jawa-eyebrow">The Wedding Of</p>
            <h2 class="jawa-section-title">{{ $jawaBrideDisplayName }}<br><span class="jawa-amp">&amp;</span><br>{{ $jawaGroomDisplayName }}</h2>
            @if ($jawaFirstEvent?->starts_at)<p class="jawa-cover-date">{{ $jawaFirstEvent->starts_at->translatedFormat('d · m · Y') }}</p>@endif
            <img class="jawa-gunungan" src="{{ $jawaAsset('JAWA-GUNUNGAN.png') }}" alt="" aria-hidden="true">
        </section>

        <section class="jawa-section jawa-feature" id="jawa-couple">
            <div class="jawa-feature-photo"><img src="{{ $jawaFeatureImage }}" alt="{{ $jawaBrideDisplayName }} dan {{ $jawaGroomDisplayName }}" fetchpriority="high"></div>
            <div class="jawa-feature-verse">
                <img class="jawa-gunungan" src="{{ $jawaAsset('Motions-Wayang-Asset-02-1.png') }}" alt="" aria-hidden="true">
                <h2 class="jawa-monogram">{{ mb_substr($jawaBrideDisplayName, 0, 1) }} <span>&amp;</span> {{ mb_substr($jawaGroomDisplayName, 0, 1) }}</h2>
                <p><em>"Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang. Sungguh, pada yang demikian itu benar-benar terdapat tanda-tanda (kebesaran Allah) bagi kaum yang berpikir."</em></p>
                <strong>— QS. Ar-Rum: 21 —</strong>
            </div>
        </section>

        <section class="jawa-section jawa-couple" aria-labelledby="jawa-profile-title">
            <div class="jawa-couple-panel">
                <img class="jawa-profile-gunungan" src="{{ $jawaAsset('JAWA-GUNUNGAN.png') }}" alt="" aria-hidden="true">
                <h2 class="jawa-profile-heading" id="jawa-profile-title">We Are<br>Getting Married!</h2>
                <p class="jawa-intro-verse">{{ $invitation->opening_text ?: 'Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan. Ya Allah semoga ridho-Mu tercurah mengiringi pernikahan kami.' }}</p>
                <article class="jawa-person jawa-person--bride">
                    @if ($invitation->bride_photo)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) }}" alt="{{ $jawaBrideDisplayName }}">@else<img src="{{ $jawaFeatureImage }}" alt="{{ $jawaBrideDisplayName }}">@endif
                    <h3>{{ $jawaBrideDisplayName }}</h3><p class="jawa-full-name">{{ $invitation->bride_name }}</p>
                    <p>Putri {{ $jawaOrderWords[$invitation->bride_child_order] ?? '' }} dari<br>Bapak {{ $invitation->bride_father }}<br>&amp; Ibu {{ $invitation->bride_mother }}</p>
                    @if ($invitation->bride_instagram)<a class="jawa-button" href="{{ $invitation->bride_instagram }}" target="_blank" rel="noopener">◎ Instagram</a>@endif
                </article>
                <div class="jawa-amp">&amp;</div>
                <article class="jawa-person jawa-person--groom">
                    @if ($invitation->groom_photo)<img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) }}" alt="{{ $jawaGroomDisplayName }}">@else<img src="{{ $jawaFeatureImage }}" alt="{{ $jawaGroomDisplayName }}">@endif
                    <h3>{{ $jawaGroomDisplayName }}</h3><p class="jawa-full-name">{{ $invitation->groom_name }}</p>
                    <p>Putra {{ $jawaOrderWords[$invitation->groom_child_order] ?? '' }} dari<br>Bapak {{ $invitation->groom_father }}<br>&amp; Ibu {{ $invitation->groom_mother }}</p>
                    @if ($invitation->groom_instagram)<a class="jawa-button" href="{{ $invitation->groom_instagram }}" target="_blank" rel="noopener">◎ Instagram</a>@endif
                </article>
                <img class="jawa-motif" src="{{ $jawaAsset('JAWA-MOTIF-BAWAH.png') }}" alt="" aria-hidden="true">
            </div>
        </section>

        <section class="jawa-section jawa-save-photos" aria-label="Foto mempelai sebelum Save the Date">
            <figure><img src="{{ $invitation->bride_photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->bride_photo) : $jawaFeatureImage }}" alt="{{ $jawaBrideDisplayName }}"></figure>
            <figure><img src="{{ $invitation->groom_photo ? \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->groom_photo) : $jawaFeatureImage }}" alt="{{ $jawaGroomDisplayName }}"></figure>
        </section>

        @if ($jawaFirstEvent?->starts_at)
            <section class="jawa-section jawa-date-section" id="jawa-date">
                <img class="jawa-gunungan" src="{{ $jawaAsset('JAWA-GUNUNGAN.png') }}" alt="" aria-hidden="true"><h2 class="jawa-script-title">Save The Date</h2><p>{{ $jawaBrideDisplayName }} &amp; {{ $jawaGroomDisplayName }}</p>
                <div class="jawa-countdown" data-jawa-countdown="{{ $jawaFirstEvent->starts_at->format('Y-m-d\TH:i:s') }}"><div><strong data-days>00</strong><span>Hari</span></div><div><strong data-hours>00</strong><span>Jam</span></div><div><strong data-minutes>00</strong><span>Menit</span></div><div><strong data-seconds>00</strong><span>Detik</span></div></div>
                <img class="jawa-motif" src="{{ $jawaAsset('JAWA-MOTIF-ATAS.png') }}" alt="" aria-hidden="true">
            </section>
        @endif

        @if ($invitation->events->isNotEmpty())
            <section class="jawa-section jawa-events" id="jawa-events"><p class="jawa-eyebrow">Dengan penuh kebahagiaan</p><h2 class="jawa-section-title">Rangkaian Acara</h2>
                @foreach ($invitation->events as $event)
                    <article class="jawa-event">
                        @if ($event->starts_at)<p class="jawa-eyebrow">{{ $event->starts_at->translatedFormat('l, d F Y') }}</p>@endif
                        <h3>{{ $event->title }}</h3>
                        <p>@if ($event->starts_at){{ $event->starts_at->format('H:i') }}@endif @if ($event->ends_at)– {{ $event->ends_at->format('H:i') }}@endif WIB</p>
                        <p><strong>{{ $event->venue_name }}</strong>@if ($event->address)<br>{{ $event->address }}@endif</p>
                        @if ($event->maps_url)<a class="jawa-button" href="{{ $event->maps_url }}" target="_blank" rel="noopener">Buka Maps</a>@endif
                    </article>
                @endforeach
            </section>
        @endif

        @if ($invitation->livestream_url)
            <section class="jawa-section jawa-section--paper" id="jawa-live"><article class="jawa-live-card"><div aria-hidden="true" style="font-size:42px">▣</div><h2 class="jawa-script-title">Live Streaming</h2><p class="jawa-intro-verse">Temui kami secara virtual untuk menyaksikan acara pernikahan kami melalui tautan di bawah ini:</p><a class="jawa-button jawa-stream" href="{{ $invitation->livestream_url }}" target="_blank" rel="noopener">◎ {{ $jawaBrideDisplayName }} &amp; {{ $jawaGroomDisplayName }}</a></article></section>
        @endif

        <section class="jawa-section jawa-section--paper" id="jawa-blessing"><article class="jawa-blessing-card"><h2 class="jawa-script-title">Doa Pengantin</h2><p class="jawa-blessing-arabic" lang="ar" dir="rtl">بَارَكَ اللَّهُ لَكَ وَبَارَكَ عَلَيْكَ وَجَمَعَ بَيْنَكُمَا فِي خَيْرٍ</p><p>"Semoga Allah memberkahimu dan memberkahi apa yang menjadi tanggung jawabmu, serta menyatukan kalian berdua dalam kebaikan."</p><strong>(HR. Abu Dawud no. 2130)</strong></article></section>

        @if (count($jawaGalleryImages) > 0)
            <section class="jawa-section jawa-section--dark" id="jawa-gallery"><h2 class="jawa-script-title">Our Gallery</h2><div class="jawa-gallery-grid">@foreach ($jawaGalleryImages as $image)<img loading="lazy" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image) }}" alt="Momen {{ $loop->iteration }} {{ $jawaBrideDisplayName }} dan {{ $jawaGroomDisplayName }}">@endforeach</div></section>
        @endif

        @if (! empty($invitation->love_story))
            <section class="jawa-section jawa-section--paper"><img class="jawa-profile-gunungan" src="{{ $jawaAsset('JAWA-GUNUNGAN.png') }}" alt="" aria-hidden="true"><p class="jawa-eyebrow">Perjalanan kami</p><h2 class="jawa-script-title">Love Story</h2><div class="jawa-story-list">
                @foreach ($invitation->love_story as $story)<article class="jawa-story"><h3>{{ $story['title'] }}</h3>@if (! empty($story['date']))<p class="jawa-eyebrow">{{ $story['date'] }}</p>@endif<p>{{ $story['description'] }}</p></article>@endforeach
            </div><img class="jawa-motif" src="{{ $jawaAsset('JAWA-MOTIF-BAWAH.png') }}" alt="" aria-hidden="true"></section>
        @endif

        @if ($invitation->gifts->isNotEmpty() || ($invitation->gift_bank_name && $invitation->gift_account_number) || $invitation->gift_delivery_address)
            <section class="jawa-section jawa-section--dark jawa-gift-section" id="jawa-gift"><div class="jawa-gift-photo-deck" aria-hidden="true">@foreach ($jawaGiftImageUrls as $index => $imageUrl)<img class="jawa-gift-photo {{ $loop->first ? 'is-active' : '' }}" src="{{ $imageUrl }}" alt="" data-gift-photo="{{ $index }}" loading="lazy">@endforeach</div><article class="jawa-live-card"><div aria-hidden="true" style="font-size:40px">♧</div><h2 class="jawa-script-title">Wedding Gift</h2><p class="jawa-intro-verse">Doa restu keluarga, sahabat, serta rekan-rekan semua di pernikahan kami sudah sangat cukup sebagai hadiah. Namun jika memberi merupakan tanda kasih, kami dengan senang hati menerimanya.</p><button class="jawa-button jawa-gift-toggle" type="button" aria-expanded="false" aria-controls="jawa-gift-panel">Lihat Rekening ⊕</button><div class="jawa-gift-panel" id="jawa-gift-panel" aria-hidden="true"><div class="jawa-gift-panel-inner"><div class="jawa-gifts">
                @forelse ($invitation->gifts as $gift)
                    @php($provider = strtolower(str_replace(' ', '', $gift->provider)))<article class="jawa-gift">@if (isset($jawaBankLogos[$provider]))<img width="90" src="{{ asset('images/bank/'.$jawaBankLogos[$provider]) }}" alt="{{ $gift->provider }}">@else<strong>{{ $gift->provider }}</strong>@endif<span>{{ $gift->account_number }}</span><small>a.n. {{ $gift->account_name }}</small><button type="button" data-jawa-copy="{{ $gift->account_number }}">Salin nomor rekening</button></article>
                @empty
                    @if ($invitation->gift_bank_name && $invitation->gift_account_number)@php($provider = strtolower(str_replace(' ', '', $invitation->gift_bank_name)))<article class="jawa-gift"><strong>{{ $invitation->gift_bank_name }}</strong><span>{{ $invitation->gift_account_number }}</span><small>a.n. {{ $invitation->gift_account_name }}</small><button type="button" data-jawa-copy="{{ $invitation->gift_account_number }}">Salin nomor rekening</button></article>@endif
                @endforelse
                @if ($invitation->gift_delivery_address)<article class="jawa-gift"><strong>Kirim Kado</strong><span>{{ $invitation->gift_delivery_address }}</span></article>@endif
            </div></div></div></article><p class="jawa-script-title">Terima Kasih</p><img class="jawa-motif" src="{{ $jawaAsset('JAWA-MOTIF-ATAS.png') }}" alt="" aria-hidden="true"></section>
        @endif

        <section class="jawa-section jawa-wishes-section" id="jawa-wishes"><p class="jawa-eyebrow">Wedding wishes</p><h2 class="jawa-script-title">Wishes</h2><div class="jawa-rsvp-count"><span><strong>{{ $invitation->attending_guests_count }}</strong><br>Hadir</span><span><strong>{{ $invitation->declined_guests_count }}</strong><br>Berhalangan</span></div>
            @if (session('rsvp_status'))<p role="status">{{ session('rsvp_status') }}</p>@endif
            <form class="jawa-form" method="POST" action="{{ route('invitations.public.rsvp', [$invitation->slug, $guest->token]) }}">@csrf<label for="jawa-rsvp">Konfirmasi kehadiran</label><select id="jawa-rsvp" name="rsvp_status" required><option value="">Pilih jawaban</option><option value="attending" @selected(old('rsvp_status', $guest->rsvp_status) === 'attending')>Hadir</option><option value="declined" @selected(old('rsvp_status', $guest->rsvp_status) === 'declined')>Tidak dapat hadir</option></select><label for="jawa-party-size">Jumlah yang hadir</label><select id="jawa-party-size" name="party_size"><option value="1">1 orang</option>@for ($count = 2; $count <= 10; $count++)<option value="{{ $count }}" @selected(old('party_size', $guest->party_size) == $count)>{{ $count }} orang</option>@endfor</select><button class="jawa-button" type="submit">Kirim Konfirmasi</button></form>
            @if (session('wish_status'))<p role="status">{{ session('wish_status') }}</p>@endif
            <form class="jawa-form" method="POST" action="{{ route('invitations.public.wishes.store', [$invitation->slug, $guest->token]) }}">@csrf<label for="jawa-name">Nama</label><input id="jawa-name" value="{{ $guest->name }}" disabled><label for="jawa-message">Ucapan</label><textarea id="jawa-message" name="message" maxlength="600" placeholder="Tuliskan doa terbaikmu..." required>{{ old('message') }}</textarea><button class="jawa-button" type="submit">Kirim Ucapan</button></form>
            @foreach ($invitation->wishes as $wish)<article class="jawa-wish"><strong>{{ $wish->guest->name }}</strong><p>{{ $wish->message }}</p></article>@endforeach
        </section>

        <footer class="jawa-section jawa-footer"><img src="{{ $jawaAsset('JAWA-GUNUNGAN.png') }}" alt="" aria-hidden="true"><p>{{ $invitation->closing_text ?: 'Suatu kebahagiaan dan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.' }}</p><p class="jawa-eyebrow">Kami yang berbahagia,</p><h2>{{ $jawaBrideDisplayName }} &amp; {{ $jawaGroomDisplayName }}</h2></footer>
    </main>
</div>
@if ($invitation->music_file)<audio id="jawa-music" loop preload="none" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($invitation->music_file) }}"></audio><button class="jawa-music" id="jawa-music-toggle" type="button" aria-label="Putar musik">♫</button>@endif
<script>
    const jawaOpen = document.querySelector('#jawa-open');
    const jawaMotionLayer = document.querySelector('#jawa-motion-layer');
    const jawaMotionVideo = document.querySelector('#jawa-motion-video');
    const jawaWelcome = document.querySelector('#jawa-welcome');
    const showJawaWelcome = () => {
        if (!jawaWelcome || !jawaMotionLayer || jawaWelcome.hidden === false) return;
        jawaMotionLayer.hidden = true;
        jawaMotionLayer.setAttribute('aria-hidden', 'true');
        jawaMotionVideo?.pause();
        jawaWelcome.hidden = false;
    };
    jawaOpen?.addEventListener('click', async () => {
        if (jawaOpen.disabled) return;
        jawaOpen.disabled = true;
        if (jawaMotionLayer && jawaMotionVideo) {
            jawaMotionLayer.hidden = false;
            jawaMotionLayer.setAttribute('aria-hidden', 'false');
            try {
                await jawaMotionVideo.play();
            } catch {
                showJawaWelcome();
            }
        } else {
            showJawaWelcome();
        }
    });
    jawaMotionVideo?.addEventListener('ended', showJawaWelcome);
    jawaMotionVideo?.addEventListener('error', showJawaWelcome);
    document.querySelector('#jawa-enter')?.addEventListener('click', async () => {
        if (jawaWelcome) jawaWelcome.hidden = true;
        if (jawaMotionLayer) jawaMotionLayer.hidden = true;
        document.body.classList.remove('jawa-locked');
        document.querySelector('#jawa-content').hidden = false;
        document.querySelector('#jawa-intro').scrollIntoView({ behavior: 'smooth' });
        const music = document.querySelector('#jawa-music');
        if (music) { try { await music.play(); document.querySelector('#jawa-music-toggle')?.classList.add('is-playing'); } catch {} }
        window.requestAnimationFrame(jawaReveal);
    });
    const jawaMusic = document.querySelector('#jawa-music');
    document.querySelector('#jawa-music-toggle')?.addEventListener('click', async (event) => {
        if (jawaMusic.paused) { try { await jawaMusic.play(); event.currentTarget.classList.add('is-playing'); event.currentTarget.setAttribute('aria-label', 'Jeda musik'); } catch {} }
        else { jawaMusic.pause(); event.currentTarget.classList.remove('is-playing'); event.currentTarget.setAttribute('aria-label', 'Putar musik'); }
    });
    let jawaMusicWasPlaying = false;
    document.addEventListener('visibilitychange', () => {
        if (!jawaMusic) return;
        if (document.hidden && !jawaMusic.paused) { jawaMusicWasPlaying = true; jawaMusic.pause(); }
        else if (!document.hidden && jawaMusicWasPlaying) {
            jawaMusicWasPlaying = false;
            jawaMusic.play().then(() => document.querySelector('#jawa-music-toggle')?.classList.add('is-playing')).catch(() => {});
        }
    });
    const jawaGiftToggle = document.querySelector('.jawa-gift-toggle');
    jawaGiftToggle?.addEventListener('click', () => {
        const panel = document.querySelector('#jawa-gift-panel');
        const isOpen = jawaGiftToggle.getAttribute('aria-expanded') === 'true';
        jawaGiftToggle.setAttribute('aria-expanded', String(!isOpen));
        jawaGiftToggle.textContent = isOpen ? 'Lihat Rekening' : 'Tutup Rekening';
        panel.classList.toggle('is-open', !isOpen);
        panel.setAttribute('aria-hidden', String(isOpen));
    });
    const jawaRevealItems = document.querySelectorAll('#jawa-content .jawa-section > :not(.jawa-motif):not(.jawa-motion-video), #jawa-content .jawa-event, #jawa-content .jawa-person, #jawa-content .jawa-story, #jawa-content .jawa-wish');
    jawaRevealItems.forEach((item) => item.classList.add('jawa-reveal'));
    function jawaReveal() {
        const viewportHeight = window.innerHeight;
        jawaRevealItems.forEach((item) => {
            const elementTop = item.getBoundingClientRect().top;
            item.classList.toggle('active', elementTop < viewportHeight);
        });
    }
    window.addEventListener('scroll', jawaReveal, { passive: true });
    document.querySelectorAll('[data-jawa-copy]').forEach((button) => button.addEventListener('click', async () => {
        try { await navigator.clipboard.writeText(button.dataset.jawaCopy); button.textContent = 'Tersalin'; } catch { button.textContent = button.dataset.jawaCopy; }
    }));
    const jawaCountdown = document.querySelector('[data-jawa-countdown]');
    if (jawaCountdown) {
        const target = new Date(jawaCountdown.dataset.jawaCountdown).getTime();
        const update = () => {
            let remaining = Math.max(0, target - Date.now());
            [['days', 86400000], ['hours', 3600000], ['minutes', 60000], ['seconds', 1000]].forEach(([unit, size]) => {
                const value = Math.floor(remaining / size);
                remaining %= size;
                jawaCountdown.querySelector(`[data-${unit}]`).textContent = String(value).padStart(2, '0');
            });
        };
        update(); window.setInterval(update, 1000);
    }
    const jawaGiftSection = document.querySelector('#jawa-gift');
    const jawaGiftPhotos = Array.from(document.querySelectorAll('[data-gift-photo]'));
    let jawaGiftScrollFrame = 0;
    const updateJawaGiftPhoto = () => {
        jawaGiftScrollFrame = 0;
        if (!jawaGiftSection || jawaGiftPhotos.length < 2) return;
        const bounds = jawaGiftSection.getBoundingClientRect();
        const travel = Math.max(1, bounds.height - window.innerHeight);
        const progress = Math.min(0.999, Math.max(0, -bounds.top / travel));
        const activePhoto = Math.min(jawaGiftPhotos.length - 1, Math.floor(progress * jawaGiftPhotos.length));
        jawaGiftPhotos.forEach((photo, index) => photo.classList.toggle('is-active', index === activePhoto));
    };
    window.addEventListener('scroll', () => {
        if (!jawaGiftScrollFrame) jawaGiftScrollFrame = window.requestAnimationFrame(updateJawaGiftPhoto);
    }, { passive: true });
    window.addEventListener('resize', updateJawaGiftPhoto, { passive: true });
</script>
</body>
</html>
