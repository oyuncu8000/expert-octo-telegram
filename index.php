<?php
// ─── AYARLAR (Cookie'den oku) ─────────────────────────────────
$theme = isset($_COOKIE['wox_theme']) ? $_COOKIE['wox_theme'] : 'dark';
$lang  = isset($_COOKIE['wox_lang'])  ? $_COOKIE['wox_lang']  : 'tr';

// Dil çevirileri
$translations = [
  'tr' => [
    'loading'        => 'Yükleniyor...',
    'home'           => 'Ana Sayfa',
    'trends'         => 'Trendler',
    'energy'         => 'Enerji Verici',
    'series'         => 'Diziler',
    'movies'         => 'Filmler',
    'mylist'         => 'Listem',
    'calendar'       => 'Takvim',
    'shorts'         => 'Shorts',
    'support'        => 'Destek Ekibi',
    'guest'          => 'Misafir',
    'logout'         => 'Çıkış',
    'watch_now'      => '▶ Şimdi İzle',
    'more_info'      => 'ℹ Daha Fazla',
    'continue_watch' => '▶ İzlemeye Devam Et',
    'clear_all'      => 'Tümünü Temizle',
    'watch'          => '▶ İzle',
    'continue'       => '▶ Devam Et',
    'remove'         => 'Kaldır',
    'all'            => 'Tümü',
    'today'          => 'Bugün',
    'this_week'      => 'Bu Hafta',
    'upcoming'       => 'Yakında',
    'date_col'       => 'Tarih',
    'show_col'       => 'Dizi / Film',
    'ep_col'         => 'Bölüm',
    'plat_col'       => 'Platform',
    'no_ep'          => '📭 Bu dönemde planlanmış bölüm bulunmuyor.',
    'android_mode'   => 'Android Modu',
    'close_mode'     => 'Modu Kapat',
    'cast_tv'        => 'TV\'ye Yansıt',
    'settings'       => 'Ayarlar',
    'settings_title' => '⚙ Ayarlar',
    'theme_label'    => '🎨 Tema',
    'dark_theme'     => '🌙 Koyu Tema',
    'light_theme'    => '☀ Açık Tema',
    'lang_label'     => '🌐 Dil',
    'save_settings'  => 'Kaydet',
    'settings_saved' => '✓ Ayarlar kaydedildi!',
    'cast_started'   => '📺 TV\'ye yansıtılıyor...',
    'cast_stopped'   => '📺 Yansıtma durduruldu',
    'cast_unavail'   => '⚠ Cast API kullanılamıyor. Tarayıcıdan paylaşın.',
    'trends_title'   => '🔥 Türkiye\'de Trendler',
    'energy_title'   => '⚡ Enerji Verici',
    'anim_title'     => '🎨 Genç Animasyonları',
    'series_title'   => '📺 Popüler Diziler',
    'movies_title'   => '🎬 Tavsiye Edilenler',
    'collections'    => '📦 Koleksiyonlar',
    'tv_channels'    => '📡 TV Kanalları',
    'mylist_title'   => '❤️ Listem',
    'cal_title'      => 'Bölüm Takvimi',
    'see_all'        => 'Tümünü Gör ›',
    'clear_history'  => 'Tüm izleme geçmişi silinsin mi?',
    'login_required' => 'Giriş Yapın',
    'login_msg'      => 'Listem özelliğini kullanmak için giriş yapmalısınız.',
    'list_empty'     => 'Listeniz Boş',
    'list_empty_msg' => 'Beğendiğiniz içeriklerin kartındaki + butonuna basın.',
    'added_list'     => '✓ Listenize eklendi!',
    'removed_list'   => '✕ Listeden çıkarıldı',
    'watching'       => '▶ İzleniyor: ',
    'error'          => '⚠ Hata oluştu.',
    'tv_mode_active' => '📺 Android Modu Aktif',
    'season'         => 'Sezon',
    'episode_lbl'    => 'Bölüm',
    'new_badge'      => 'Yeni',
    'saved_badge'    => 'Kayıtlı',
    'hero_badge'     => '🔥 #1 Türkiye\'de',
    'hero_desc'      => 'En iyi yapımları, en kaliteli görüntüyle izle. Binlerce içerik tek bir platformda seni bekliyor.',
  ],
  'en' => [
    'loading'        => 'Loading...',
    'home'           => 'Home',
    'trends'         => 'Trending',
    'energy'         => 'Action',
    'series'         => 'Series',
    'movies'         => 'Movies',
    'mylist'         => 'My List',
    'calendar'       => 'Calendar',
    'shorts'         => 'Shorts',
    'support'        => 'Support',
    'guest'          => 'Guest',
    'logout'         => 'Logout',
    'watch_now'      => '▶ Watch Now',
    'more_info'      => 'ℹ More Info',
    'continue_watch' => '▶ Continue Watching',
    'clear_all'      => 'Clear All',
    'watch'          => '▶ Watch',
    'continue'       => '▶ Continue',
    'remove'         => 'Remove',
    'all'            => 'All',
    'today'          => 'Today',
    'this_week'      => 'This Week',
    'upcoming'       => 'Upcoming',
    'date_col'       => 'Date',
    'show_col'       => 'Show / Movie',
    'ep_col'         => 'Episode',
    'plat_col'       => 'Platform',
    'no_ep'          => '📭 No episodes scheduled for this period.',
    'android_mode'   => 'Android Mode',
    'close_mode'     => 'Close Mode',
    'cast_tv'        => 'Cast to TV',
    'settings'       => 'Settings',
    'settings_title' => '⚙ Settings',
    'theme_label'    => '🎨 Theme',
    'dark_theme'     => '🌙 Dark Theme',
    'light_theme'    => '☀ Light Theme',
    'lang_label'     => '🌐 Language',
    'save_settings'  => 'Save',
    'settings_saved' => '✓ Settings saved!',
    'cast_started'   => '📺 Casting to TV...',
    'cast_stopped'   => '📺 Cast stopped',
    'cast_unavail'   => '⚠ Cast API unavailable. Use browser share.',
    'trends_title'   => '🔥 Trending in Turkey',
    'energy_title'   => '⚡ Action',
    'anim_title'     => '🎨 Animation',
    'series_title'   => '📺 Popular Series',
    'movies_title'   => '🎬 Recommended',
    'collections'    => '📦 Collections',
    'tv_channels'    => '📡 TV Channels',
    'mylist_title'   => '❤️ My List',
    'cal_title'      => 'Episode Calendar',
    'see_all'        => 'See All ›',
    'clear_history'  => 'Clear all watch history?',
    'login_required' => 'Sign In',
    'login_msg'      => 'You must sign in to use My List.',
    'list_empty'     => 'Your List is Empty',
    'list_empty_msg' => 'Press the + button on content cards.',
    'added_list'     => '✓ Added to your list!',
    'removed_list'   => '✕ Removed from list',
    'watching'       => '▶ Watching: ',
    'error'          => '⚠ An error occurred.',
    'tv_mode_active' => '📺 Android Mode Active',
    'season'         => 'Season',
    'episode_lbl'    => 'Episode',
    'new_badge'      => 'New',
    'saved_badge'    => 'Saved',
    'hero_badge'     => '🔥 #1 in Turkey',
    'hero_desc'      => 'Watch the best productions in the highest quality. Thousands of titles waiting for you on one platform.',
  ],
  'de' => [
    'loading'        => 'Wird geladen...',
    'home'           => 'Startseite',
    'trends'         => 'Trends',
    'energy'         => 'Action',
    'series'         => 'Serien',
    'movies'         => 'Filme',
    'mylist'         => 'Meine Liste',
    'calendar'       => 'Kalender',
    'shorts'         => 'Shorts',
    'support'        => 'Support',
    'guest'          => 'Gast',
    'logout'         => 'Abmelden',
    'watch_now'      => '▶ Jetzt ansehen',
    'more_info'      => 'ℹ Mehr Info',
    'continue_watch' => '▶ Weiterschauen',
    'clear_all'      => 'Alle löschen',
    'watch'          => '▶ Ansehen',
    'continue'       => '▶ Weiter',
    'remove'         => 'Entfernen',
    'all'            => 'Alle',
    'today'          => 'Heute',
    'this_week'      => 'Diese Woche',
    'upcoming'       => 'Demnächst',
    'date_col'       => 'Datum',
    'show_col'       => 'Serie / Film',
    'ep_col'         => 'Folge',
    'plat_col'       => 'Plattform',
    'no_ep'          => '📭 Keine Folgen in diesem Zeitraum geplant.',
    'android_mode'   => 'Android-Modus',
    'close_mode'     => 'Modus beenden',
    'cast_tv'        => 'Auf TV übertragen',
    'settings'       => 'Einstellungen',
    'settings_title' => '⚙ Einstellungen',
    'theme_label'    => '🎨 Thema',
    'dark_theme'     => '🌙 Dunkles Thema',
    'light_theme'    => '☀ Helles Thema',
    'lang_label'     => '🌐 Sprache',
    'save_settings'  => 'Speichern',
    'settings_saved' => '✓ Einstellungen gespeichert!',
    'cast_started'   => '📺 Wird auf TV übertragen...',
    'cast_stopped'   => '📺 Übertragung gestoppt',
    'cast_unavail'   => '⚠ Cast-API nicht verfügbar. Teilen Sie über den Browser.',
    'trends_title'   => '🔥 Trends in der Türkei',
    'energy_title'   => '⚡ Action',
    'anim_title'     => '🎨 Animation',
    'series_title'   => '📺 Beliebte Serien',
    'movies_title'   => '🎬 Empfehlungen',
    'collections'    => '📦 Sammlungen',
    'tv_channels'    => '📡 TV-Kanäle',
    'mylist_title'   => '❤️ Meine Liste',
    'cal_title'      => 'Folgen-Kalender',
    'see_all'        => 'Alle anzeigen ›',
    'clear_history'  => 'Gesamten Verlauf löschen?',
    'login_required' => 'Anmelden',
    'login_msg'      => 'Sie müssen sich anmelden, um Meine Liste zu verwenden.',
    'list_empty'     => 'Ihre Liste ist leer',
    'list_empty_msg' => 'Drücken Sie die + Taste auf den Inhaltskarten.',
    'added_list'     => '✓ Zur Liste hinzugefügt!',
    'removed_list'   => '✕ Von Liste entfernt',
    'watching'       => '▶ Schaut: ',
    'error'          => '⚠ Ein Fehler ist aufgetreten.',
    'tv_mode_active' => '📺 Android-Modus aktiv',
    'season'         => 'Staffel',
    'episode_lbl'    => 'Folge',
    'new_badge'      => 'Neu',
    'saved_badge'    => 'Gespeichert',
    'hero_badge'     => '🔥 #1 in der Türkei',
    'hero_desc'      => 'Schau die besten Produktionen in höchster Qualität. Tausende Titel auf einer Plattform.',
  ],
];

// ── WOXPLUS Ziyaretçi Takip Sistemi ──────────────────────────
// Her farklı IP 1 kişi sayılır, veriler hiç silinmez
$_wox_file = __DIR__ . '/wox_visitors.json';
$_wox_ua   = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$_wox_bots = ['googlebot','bingbot','bot','crawler','spider','curl','wget','python','scrapy'];
$_wox_is_bot = false;
foreach ($_wox_bots as $_b) {
    if (str_contains($_wox_ua, $_b)) { $_wox_is_bot = true; break; }
}
if (!$_wox_is_bot && !empty($_SERVER['REMOTE_ADDR'])) {
    $__ip   = trim(explode(',', $_SERVER['HTTP_CF_CONNECTING_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '')[0]);
    $__hash = md5($__ip);
    $__now  = time();
    $__data = file_exists($_wox_file) ? (json_decode(@file_get_contents($_wox_file), true) ?: []) : [];
    if (!isset($__data['unique_count'])) $__data['unique_count'] = 0;
    if (!isset($__data['total_hits']))   $__data['total_hits']   = 0;
    if (!isset($__data['visitors']))     $__data['visitors']     = [];
    if (!isset($__data['daily']))        $__data['daily']        = [];
    if (!isset($__data['daily_ips']))    $__data['daily_ips']    = [];
    if (!isset($__data['hourly']))       $__data['hourly']       = [];
    if (!isset($__data['monthly']))      $__data['monthly']      = [];
    if (!isset($__data['started_at']))   $__data['started_at']   = date('Y-m-d H:i:s');
    $__today = date('Y-m-d');
    $__month = date('Y-m');
    $__hkey  = $__today . '_' . date('H');
    $__data['total_hits']++;
    if (!isset($__data['hourly'][$__hkey]))   $__data['hourly'][$__hkey] = 0;
    $__data['hourly'][$__hkey]++;
    if (!isset($__data['daily'][$__today]))   $__data['daily'][$__today] = ['unique'=>0,'hits'=>0];
    $__data['daily'][$__today]['hits']++;
    if (!isset($__data['monthly'][$__month])) $__data['monthly'][$__month] = ['unique'=>0,'hits'=>0];
    $__data['monthly'][$__month]['hits']++;
    $__dkey = $__today . '_' . $__hash;
    if (!isset($__data['daily_ips'][$__dkey])) {
        $__data['daily_ips'][$__dkey] = true;
        $__data['daily'][$__today]['unique']++;
        $__data['monthly'][$__month]['unique']++;
    }
    if (!isset($__data['visitors'][$__hash])) {
        $__data['unique_count']++;
        $__data['visitors'][$__hash] = ['first_seen' => date('Y-m-d H:i:s',$__now), 'visit_count' => 1];
    } else {
        $__data['visitors'][$__hash]['visit_count'] = ($__data['visitors'][$__hash]['visit_count'] ?? 1) + 1;
        $__data['visitors'][$__hash]['last_seen']   = date('Y-m-d H:i:s',$__now);
    }
    $__data['last_updated'] = date('Y-m-d H:i:s',$__now);
    @file_put_contents($_wox_file, json_encode($__data, JSON_PRETTY_PRINT), LOCK_EX);
}

$t = $translations[$lang] ?? $translations['tr'];

// Ay isimleri (takvim için)
$months = [
  'tr' => ['Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'],
  'en' => ['January','February','March','April','May','June','July','August','September','October','November','December'],
  'de' => ['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'],
];
$days = [
  'tr' => ['Paz','Pzt','Sal','Çar','Per','Cum','Cmt'],
  'en' => ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
  'de' => ['So','Mo','Di','Mi','Do','Fr','Sa'],
];
$monthsJson = json_encode($months[$lang] ?? $months['tr']);
$daysJson   = json_encode($days[$lang]   ?? $days['tr']);
?><!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
<link rel="manifest" href="manifest.json">
<script>
if('serviceWorker' in navigator){window.addEventListener('load',function(){navigator.serviceWorker.register('sw.js').then(r=>console.log('SW:',r.scope),e=>console.log('SW err:',e));});}
</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>WOXPLUS - Film ve Dizi İzle</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;500;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}
@keyframes meshA{0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(-30px,20px) scale(1.05);}66%{transform:translate(20px,-15px) scale(0.97);}}
@keyframes meshB{0%,100%{transform:translate(0,0) scale(1.1);}40%{transform:translate(25px,30px) scale(1);}75%{transform:translate(-20px,-25px) scale(1.08);}}

/* ─── DARK THEME (default) ─── */
:root{
  --accent:#e8e8e8;--accent-bright:#ffffff;--accent-dim:rgba(255,255,255,0.07);--accent-border:rgba(255,255,255,0.12);
  --bg:#080a0c;--bg-card:#0f1115;--bg-card-2:#13161c;--bg-header:rgba(8,10,12,0.96);
  --txt:#f0f2f5;--txt-2:#8a9099;--txt-3:#3e4550;--silver:#c8cdd6;
  --border:rgba(255,255,255,0.07);--border-bright:rgba(255,255,255,0.14);
  --sh-card:0 4px 24px rgba(0,0,0,0.7);--sh-hover:0 16px 48px rgba(0,0,0,0.85),0 0 0 1px rgba(255,255,255,0.1);
  --r:10px;--r-sm:6px;--gap:10px;
  --card-w:170px;--card-h:255px;--hdr:60px;--ease:cubic-bezier(.4,0,.2,1);
  --tv-nav-w:0px;--tv-nav-expanded:200px;--mob-nav-h:62px;
  --modal-bg:rgba(8,10,12,0.97);--modal-border:rgba(255,255,255,0.12);
  --co-gradient:linear-gradient(to top,rgba(8,10,12,0.98) 0%,rgba(8,10,12,0.6) 38%,transparent 65%);
}

/* ─── LIGHT THEME ─── */
body.light-theme{
  --bg:#f0f2f5;--bg-card:#ffffff;--bg-card-2:#e8eaee;--bg-header:rgba(240,242,245,0.97);
  --txt:#0d0f12;--txt-2:#4a5260;--txt-3:#8a9099;--silver:#3e4550;
  --border:rgba(0,0,0,0.09);--border-bright:rgba(0,0,0,0.16);
  --accent:#1a1d22;--accent-bright:#0d0f12;--accent-dim:rgba(0,0,0,0.05);--accent-border:rgba(0,0,0,0.1);
  --sh-card:0 4px 24px rgba(0,0,0,0.1);--sh-hover:0 16px 48px rgba(0,0,0,0.18),0 0 0 1px rgba(0,0,0,0.08);
  --modal-bg:rgba(240,242,245,0.99);--modal-border:rgba(0,0,0,0.12);
  --co-gradient:linear-gradient(to top,rgba(240,242,245,0.98) 0%,rgba(240,242,245,0.7) 38%,transparent 65%);
}
body.light-theme::before{background:radial-gradient(ellipse 80% 50% at 20% 10%,rgba(0,0,0,0.03) 0%,transparent 60%),radial-gradient(ellipse 60% 40% at 80% 85%,rgba(0,0,0,0.02) 0%,transparent 55%);}
body.light-theme::after{background:radial-gradient(ellipse 70% 35% at 90% 20%,rgba(0,0,0,0.02) 0%,transparent 55%);}
body.light-theme .noise-overlay{opacity:0.01;}
body.light-theme .mc img,.body.light-theme .cw-card img{filter:none!important;}
body.light-theme .mc:hover img,.body.light-theme .mc.tv-focused img{filter:brightness(.5)!important;}
body.light-theme .cw-card:hover img{filter:brightness(.5)!important;}
body.light-theme .hero{background:linear-gradient(to bottom,rgba(240,242,245,0.1) 0%,rgba(240,242,245,0.7) 55%,var(--bg) 100%),linear-gradient(to right,rgba(240,242,245,0.92) 0%,rgba(240,242,245,0.4) 50%,transparent 100%),url('https://m.media-amazon.com/images/S/pv-target-images/3d947e119f92dfafdfcbd10bc3e74a980594e858fa2a68796b6898d94f1072d6.jpg') center/cover no-repeat;}
body.light-theme .co{background:var(--co-gradient);}
body.light-theme .cw-overlay{background:linear-gradient(to top,rgba(240,242,245,0.98) 0%,rgba(240,242,245,0.6) 45%,transparent 70%);}
body.light-theme .btn-lo:hover{background:rgba(200,60,60,.08);border-color:rgba(200,60,60,.25);color:#c03030;}
body.light-theme .tv-sidenav{background:rgba(240,242,245,0.99);}
body.light-theme .ls{background:var(--bg);}
body.light-theme .ad-bar{background:rgba(220,222,226,0.9);}

body{background:var(--bg);color:var(--txt);font-family:'Syne',system-ui,sans-serif;overflow-x:hidden;min-height:100vh;-webkit-font-smoothing:antialiased;transition:padding-left .35s var(--ease),background .3s,color .3s;position:relative;}
body::before{content:'';position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(ellipse 80% 50% at 20% 10%,rgba(255,255,255,0.025) 0%,transparent 60%),radial-gradient(ellipse 60% 40% at 80% 85%,rgba(200,210,230,0.02) 0%,transparent 55%),radial-gradient(ellipse 50% 60% at 50% 50%,rgba(150,165,190,0.015) 0%,transparent 70%);animation:meshA 18s ease-in-out infinite;}
body::after{content:'';position:fixed;inset:0;z-index:0;pointer-events:none;background:radial-gradient(ellipse 70% 35% at 90% 20%,rgba(255,255,255,0.018) 0%,transparent 55%),radial-gradient(ellipse 45% 55% at 10% 80%,rgba(220,225,240,0.015) 0%,transparent 60%);animation:meshB 25s ease-in-out infinite;}
.noise-overlay{position:fixed;inset:0;z-index:1;pointer-events:none;opacity:0.025;background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E");background-size:128px;}
main,header,section,nav,.hero,footer{position:relative;z-index:2;}

/* LOADING */
.ls{position:fixed;inset:0;background:var(--bg);z-index:9999;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:24px;transition:opacity .4s;}
.ls.hide{opacity:0;pointer-events:none;}
.ls-logo{display:flex;align-items:center;justify-content:center;animation:pulseLogo 1.8s ease-in-out infinite;}
.ls-logo img{width:120px;height:auto;object-fit:contain;}
@keyframes pulseLogo{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.5;transform:scale(0.97);}}
.ls-bar{width:180px;height:1px;background:rgba(255,255,255,.08);border-radius:1px;overflow:hidden;}
.ls-fill{height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.6),transparent);background-size:200% 100%;animation:ldbar 1.4s ease-in-out infinite;}
@keyframes ldbar{0%{background-position:200% 0;}100%{background-position:-200% 0;}}
.ls-txt{font-size:.65rem;color:var(--txt-3);font-weight:600;letter-spacing:.18em;text-transform:uppercase;font-family:'DM Mono',monospace;}

/* TV SIDENAV */
body.android-tv{padding-left:var(--tv-nav-w);}
body.android-tv.tv-nav-open{padding-left:var(--tv-nav-expanded);}
.tv-sidenav{position:fixed;top:0;left:0;bottom:0;width:60px;background:rgba(8,10,12,0.99);border-right:1px solid var(--border);z-index:190;display:none;flex-direction:column;align-items:center;padding-top:calc(var(--hdr) + 16px);overflow:hidden;transition:width .35s var(--ease),box-shadow .35s;box-shadow:4px 0 40px rgba(0,0,0,.8);backdrop-filter:blur(20px);}
body.android-tv .tv-sidenav{display:flex;}
body.android-tv.tv-nav-open .tv-sidenav{width:var(--tv-nav-expanded);}
.tv-si{display:flex;flex-direction:column;width:100%;padding:0 8px;}
.tv-ni{display:flex;align-items:center;gap:12px;padding:12px 10px;border-radius:var(--r-sm);cursor:pointer;white-space:nowrap;color:var(--txt-2);text-decoration:none;font-size:.78rem;font-weight:600;transition:.2s;width:100%;border:1px solid transparent;margin-bottom:4px;overflow:hidden;}
.tv-ni .icon{font-size:1.1rem;flex-shrink:0;width:28px;text-align:center;}
.tv-ni .lbl{opacity:0;transition:opacity .25s;pointer-events:none;}
body.android-tv.tv-nav-open .tv-ni .lbl{opacity:1;}
.tv-ni:hover,.tv-ni.tv-focused{background:var(--accent-dim);border-color:var(--accent-border);color:var(--txt);}
.tv-ni.active-nav{color:var(--accent-bright);}
.tv-toggle{margin-top:auto;margin-bottom:24px;width:34px;height:34px;border-radius:50%;background:rgba(255,255,255,.05);border:1px solid var(--border);color:var(--txt-2);cursor:pointer;display:flex;align-items:center;justify-content:center;transition:.3s;font-size:.8rem;}
.tv-toggle:hover{background:var(--accent-dim);color:var(--txt);}
body.android-tv.tv-nav-open .tv-toggle{transform:rotate(180deg);}
body.android-tv .focusable.tv-focused{outline:2px solid rgba(255,255,255,0.5);outline-offset:2px;transform:scale(1.07) translateY(-4px)!important;z-index:30!important;box-shadow:0 0 0 2px rgba(255,255,255,.15),var(--sh-hover)!important;}
.tv-ind{display:none;position:fixed;top:calc(var(--hdr)+10px);right:16px;z-index:500;background:rgba(255,255,255,0.05);border:1px solid var(--border-bright);color:var(--silver);padding:4px 12px;border-radius:20px;font-size:.65rem;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:'DM Mono',monospace;}
body.android-tv .tv-ind{display:block;}

/* HEADER */
header{position:fixed;top:0;left:0;right:0;z-index:200;height:var(--hdr);background:linear-gradient(180deg,rgba(8,10,12,0.98) 0%,rgba(8,10,12,0.0) 100%);display:flex;align-items:center;justify-content:space-between;padding:0 24px;transition:background .3s,border-color .3s,left .35s;border-bottom:1px solid transparent;}
body.light-theme header{background:linear-gradient(180deg,rgba(240,242,245,0.98) 0%,rgba(240,242,245,0.0) 100%);}
body.android-tv header{left:60px;}
body.android-tv.tv-nav-open header{left:var(--tv-nav-expanded);}
header.scrolled{background:var(--bg-header);border-bottom-color:var(--border);backdrop-filter:blur(24px) saturate(1.4);}
.logo{display:flex;align-items:center;height:36px;text-decoration:none;flex-shrink:0;}
.logo img{height:32px;width:auto;object-fit:contain;transition:opacity .2s;}
nav.mnav{display:flex;gap:2px;align-items:center;overflow-x:auto;scrollbar-width:none;flex:1;justify-content:center;padding:0 12px;}
nav.mnav::-webkit-scrollbar{display:none;}
nav.mnav a{color:var(--txt-3);text-decoration:none;font-size:.72rem;font-weight:600;padding:5px 11px;border-radius:5px;white-space:nowrap;transition:.2s;letter-spacing:.04em;text-transform:uppercase;font-family:'DM Mono',monospace;}
nav.mnav a:hover{color:var(--silver);background:rgba(255,255,255,.05);}
body.light-theme nav.mnav a:hover{background:rgba(0,0,0,.05);}
nav.mnav a.active{color:var(--txt);}
.hdr-r{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.upbadge{display:flex;align-items:center;gap:8px;cursor:pointer;padding:4px 11px 4px 4px;border-radius:28px;background:rgba(255,255,255,.04);border:1px solid var(--border);transition:.2s;}
body.light-theme .upbadge{background:rgba(0,0,0,.04);}
.upbadge:hover{background:rgba(255,255,255,.08);border-color:var(--border-bright);}
body.light-theme .upbadge:hover{background:rgba(0,0,0,.07);}
.uav{width:26px;height:26px;border-radius:7px;object-fit:cover;border:1px solid rgba(255,255,255,0.15);}
.uname{font-size:.72rem;font-weight:700;color:var(--txt);max-width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;letter-spacing:.02em;}
.btn-lo{background:transparent;border:1px solid var(--border);color:var(--txt-3);font-family:'DM Mono',monospace;font-size:.65rem;font-weight:500;padding:5px 11px;border-radius:5px;cursor:pointer;transition:.2s;letter-spacing:.05em;}
.btn-lo:hover{background:rgba(255,60,60,.08);border-color:rgba(255,60,60,.25);color:#e06060;}
.fav-btn{position:relative;background:rgba(255,255,255,.04);border:1px solid var(--border);color:var(--txt-2);cursor:pointer;font-size:.9rem;padding:6px 10px;border-radius:7px;transition:.2s;line-height:1;}
body.light-theme .fav-btn{background:rgba(0,0,0,.04);}
.fav-btn:hover{background:rgba(255,255,255,.09);border-color:var(--border-bright);}
.fav-cnt{position:absolute;top:-6px;right:-6px;background:var(--txt);color:var(--bg);border-radius:50%;width:17px;height:17px;font-size:9px;font-weight:800;display:flex;align-items:center;justify-content:center;font-family:'DM Mono',monospace;}

/* CAST & SETTINGS BUTTONS */
.cast-btn,.settings-btn{background:rgba(255,255,255,.04);border:1px solid var(--border);color:var(--txt-2);cursor:pointer;font-size:.78rem;font-weight:700;padding:6px 11px;border-radius:7px;transition:.2s;line-height:1;display:flex;align-items:center;gap:5px;font-family:'DM Mono',monospace;letter-spacing:.04em;white-space:nowrap;}
body.light-theme .cast-btn,body.light-theme .settings-btn{background:rgba(0,0,0,.04);}
.cast-btn:hover,.settings-btn:hover{background:rgba(255,255,255,.1);border-color:var(--border-bright);color:var(--txt);}
body.light-theme .cast-btn:hover,body.light-theme .settings-btn:hover{background:rgba(0,0,0,.08);}
.cast-btn.casting{border-color:rgba(100,200,255,0.4);color:rgba(100,200,255,1);background:rgba(100,200,255,0.07);}
@media(max-width:599px){.cast-btn span.cast-lbl,.settings-btn span.settings-lbl{display:none;}}

/* SETTINGS MODAL */
.settings-overlay{position:fixed;inset:0;z-index:8000;background:rgba(0,0,0,0.6);backdrop-filter:blur(8px);display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s;}
.settings-overlay.open{opacity:1;pointer-events:all;}
.settings-modal{background:var(--modal-bg);border:1px solid var(--modal-border);border-radius:16px;padding:28px;width:min(380px,92vw);box-shadow:0 24px 80px rgba(0,0,0,0.7);transform:scale(.94) translateY(20px);transition:transform .3s var(--ease),opacity .3s;opacity:0;}
.settings-overlay.open .settings-modal{transform:scale(1) translateY(0);opacity:1;}
.settings-modal-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
.settings-modal-title{font-size:.9rem;font-weight:800;letter-spacing:.06em;color:var(--txt);}
.settings-close{background:none;border:none;color:var(--txt-3);font-size:1.2rem;cursor:pointer;padding:4px 8px;border-radius:6px;transition:.2s;line-height:1;}
.settings-close:hover{background:var(--accent-dim);color:var(--txt);}
.settings-group{margin-bottom:20px;}
.settings-label{font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--txt-3);font-family:'DM Mono',monospace;margin-bottom:10px;display:block;}
.settings-opts{display:flex;gap:8px;flex-wrap:wrap;}
.settings-opt{padding:8px 16px;border-radius:8px;border:1px solid var(--border);background:var(--accent-dim);color:var(--txt-2);font-size:.75rem;font-weight:700;cursor:pointer;transition:.2s;font-family:'DM Mono',monospace;letter-spacing:.04em;}
.settings-opt:hover{border-color:var(--border-bright);color:var(--txt);}
.settings-opt.active{background:var(--txt);color:var(--bg);border-color:transparent;}
.settings-save{width:100%;padding:11px;background:var(--txt);color:var(--bg);border:none;border-radius:8px;font-size:.78rem;font-weight:800;cursor:pointer;font-family:'Syne',sans-serif;letter-spacing:.06em;transition:.2s;margin-top:8px;text-transform:uppercase;}
.settings-save:hover{opacity:.88;transform:translateY(-1px);}

/* HERO */
.hero{margin-top:var(--hdr);min-height:58vw;max-height:640px;background:linear-gradient(to bottom,rgba(8,10,12,0.1) 0%,rgba(8,10,12,0.6) 55%,var(--bg) 100%),linear-gradient(to right,rgba(8,10,12,0.92) 0%,rgba(8,10,12,0.4) 50%,transparent 100%),url('https://m.media-amazon.com/images/S/pv-target-images/3d947e119f92dfafdfcbd10bc3e74a980594e858fa2a68796b6898d94f1072d6.jpg') center/cover no-repeat;display:flex;align-items:flex-end;padding:0 24px 44px;position:relative;overflow:hidden;}
.hero::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 60% at 0% 50%,rgba(8,10,12,0.55) 0%,transparent 70%);pointer-events:none;}
.hero-c{max-width:500px;position:relative;z-index:1;}
.hero-badge{display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.14);color:var(--silver);padding:3px 12px;border-radius:20px;font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;margin-bottom:14px;font-family:'DM Mono',monospace;backdrop-filter:blur(8px);}
.hero h1{font-family:'Bebas Neue',sans-serif;font-size:clamp(2.8rem,7vw,5.5rem);line-height:.95;letter-spacing:.02em;margin-bottom:14px;background:linear-gradient(165deg,#ffffff 0%,#a8b0bf 60%,#6a7280 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;filter:drop-shadow(0 2px 20px rgba(0,0,0,0.5));}
body.light-theme .hero h1{background:linear-gradient(165deg,#0d0f12 0%,#3e4550 60%,#6a7280 100%);-webkit-background-clip:text;background-clip:text;}
.hero p{font-size:clamp(.78rem,2vw,.88rem);color:var(--txt-2);margin-bottom:24px;line-height:1.7;max-width:380px;font-weight:400;}
.hero-acts{display:flex;gap:10px;flex-wrap:wrap;}
.btn-play,.btn-more{border:none;padding:11px 22px;border-radius:var(--r-sm);font-size:.78rem;font-weight:700;cursor:pointer;display:flex;align-items:center;gap:7px;font-family:'Syne',sans-serif;transition:.25s;letter-spacing:.04em;text-transform:uppercase;}
.btn-play{background:var(--txt);color:var(--bg);box-shadow:0 4px 20px rgba(240,242,245,0.15);}
.btn-play:hover{background:#ffffff;transform:translateY(-2px);box-shadow:0 8px 30px rgba(255,255,255,0.2);}
body.light-theme .btn-play:hover{background:#0d0f12;color:#fff;}
.btn-more{background:rgba(255,255,255,.07);color:var(--silver);border:1px solid rgba(255,255,255,.13);backdrop-filter:blur(8px);}
body.light-theme .btn-more{background:rgba(0,0,0,.07);color:var(--txt-2);border-color:rgba(0,0,0,.13);}
.btn-more:hover{background:rgba(255,255,255,.12);transform:translateY(-2px);}
body.light-theme .btn-more:hover{background:rgba(0,0,0,.12);}

/* MAIN */
main{padding:30px 24px 90px;}
.sec{margin-bottom:42px;}
.sec-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
.sec-title{font-size:.78rem;font-weight:700;display:flex;align-items:center;gap:9px;letter-spacing:.08em;text-transform:uppercase;color:var(--silver);font-family:'DM Mono',monospace;}
.badge{font-size:.55rem;background:rgba(255,255,255,0.06);color:var(--txt-3);border:1px solid var(--border);padding:2px 8px;border-radius:20px;font-weight:700;letter-spacing:.12em;text-transform:uppercase;font-family:'DM Mono',monospace;}
body.light-theme .badge{background:rgba(0,0,0,.06);}
.see-all{color:var(--txt-2);font-size:.65rem;font-weight:600;text-decoration:none;opacity:0;transition:.25s;letter-spacing:.06em;text-transform:uppercase;font-family:'DM Mono',monospace;border-bottom:1px solid transparent;}
.see-all:hover{color:var(--txt);border-bottom-color:var(--border-bright);}
.sec:hover .see-all{opacity:1;}

/* CARDS */
.sl-c{position:relative;}
.sl-w{overflow:hidden;}
.sl{display:flex;gap:var(--gap);transition:transform .4s var(--ease);will-change:transform;}
.mc{flex:0 0 var(--card-w);width:var(--card-w);height:var(--card-h);border-radius:var(--r);overflow:hidden;position:relative;cursor:pointer;background:var(--bg-card);border:1px solid var(--border);box-shadow:var(--sh-card);transition:transform .3s var(--ease),border-color .3s,box-shadow .3s;}
.mc::before{content:'';position:absolute;inset:0;z-index:1;background:linear-gradient(135deg,rgba(255,255,255,0.03) 0%,transparent 60%);pointer-events:none;opacity:0;transition:opacity .3s;}
.mc:hover{transform:scale(1.05) translateY(-5px);z-index:10;border-color:rgba(255,255,255,0.18);box-shadow:var(--sh-hover);}
body.light-theme .mc:hover{border-color:rgba(0,0,0,0.18);}
.mc:hover::before{opacity:1;}
.mc img{width:100%;height:100%;object-fit:cover;display:block;pointer-events:none;transition:filter .3s;}
.mc:hover img,.mc.tv-focused img{filter:brightness(.35) saturate(.6);}
.mc.tv-focused .co{opacity:1;}
.co{position:absolute;inset:0;z-index:2;background:var(--co-gradient);opacity:0;transition:opacity .3s;display:flex;flex-direction:column;justify-content:flex-end;padding:12px;}
.mc:hover .co{opacity:1;}
.ct{font-size:.78rem;font-weight:700;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;letter-spacing:.01em;}
.cm{display:flex;align-items:center;gap:4px;flex-wrap:wrap;font-size:.62rem;color:var(--txt-3);margin-bottom:10px;font-family:'DM Mono',monospace;}
.cr{color:var(--silver);font-weight:600;}
.ca{display:flex;gap:5px;}
.cb{border:none;border-radius:var(--r-sm);font-size:.65rem;font-weight:700;cursor:pointer;font-family:'Syne',sans-serif;display:flex;align-items:center;justify-content:center;gap:3px;transition:.18s;padding:7px 0;letter-spacing:.04em;}
.cb-p{flex:1;background:var(--txt);color:var(--bg);}
.cb-p:hover{background:#ffffff;}
body.light-theme .cb-p:hover{background:#000000;color:#fff;}
.cb-f{flex:0 0 32px;width:32px;background:rgba(255,255,255,.06);color:var(--txt-3);border:1px solid rgba(255,255,255,.1);}
body.light-theme .cb-f{background:rgba(0,0,0,.06);border-color:rgba(0,0,0,.1);}
.cb-f:hover{background:rgba(255,255,255,.12);color:var(--txt);}
.cb-f.active{background:rgba(255,255,255,0.1);border-color:rgba(255,255,255,0.25);color:var(--txt);}
body.light-theme .cb-f.active{background:rgba(0,0,0,.1);border-color:rgba(0,0,0,.25);}
.cn{position:absolute;top:8px;left:8px;z-index:3;background:rgba(8,10,12,0.85);border:1px solid var(--border);color:var(--txt-2);font-size:.55rem;font-weight:700;width:20px;height:20px;border-radius:3px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(6px);font-family:'DM Mono',monospace;}
body.light-theme .cn{background:rgba(240,242,245,0.9);}
.sl-arr{position:absolute;top:50%;transform:translateY(-50%);width:36px;height:82%;background:rgba(8,10,12,0.9);border:1px solid var(--border);color:var(--txt-2);font-size:.85rem;cursor:pointer;z-index:20;display:none;align-items:center;justify-content:center;opacity:0;transition:.25s;backdrop-filter:blur(12px);}
body.light-theme .sl-arr{background:rgba(240,242,245,0.9);}
@media(hover:hover){.sl-arr{display:flex;}.sl-c:hover .sl-arr{opacity:1;}}
.sl-arr:hover{background:rgba(15,17,21,.95);color:var(--txt);}
body.light-theme .sl-arr:hover{background:rgba(220,222,226,.98);}
.sl-arr.l{left:-36px;border-radius:0 var(--r) var(--r) 0;}
.sl-arr.r{right:-36px;border-radius:var(--r) 0 0 var(--r);}

/* FAV EMPTY */
.empty-fav{display:flex;flex-direction:column;align-items:center;padding:48px 20px;text-align:center;border:1px dashed rgba(255,255,255,.06);border-radius:14px;background:rgba(255,255,255,.012);color:var(--txt-3);}
body.light-theme .empty-fav{border-color:rgba(0,0,0,.08);background:rgba(0,0,0,.02);}
.empty-fav .icon{font-size:2rem;margin-bottom:12px;opacity:.35;}
.empty-fav h3{color:var(--txt-2);margin-bottom:8px;font-size:.85rem;font-weight:600;letter-spacing:.04em;}
.empty-fav p{font-size:.74rem;line-height:1.7;max-width:240px;color:var(--txt-3);}

/* TOAST */
.toast{position:fixed;z-index:9999;bottom:24px;right:20px;left:20px;max-width:300px;margin:0 auto;background:rgba(15,17,21,0.98);border:1px solid var(--border-bright);color:var(--silver);padding:11px 15px;border-radius:8px;font-size:.78rem;font-weight:500;box-shadow:0 12px 40px rgba(0,0,0,.7);border-left:2px solid rgba(255,255,255,0.3);backdrop-filter:blur(20px);display:flex;align-items:center;gap:9px;transform:translateY(80px) scale(.97);opacity:0;transition:all .3s var(--ease);pointer-events:none;font-family:'DM Mono',monospace;letter-spacing:.04em;}
body.light-theme .toast{background:rgba(240,242,245,0.98);color:var(--txt);border-left-color:rgba(0,0,0,0.3);}
.toast.show{transform:translateY(0) scale(1);opacity:1;}
.sec-div{height:1px;background:var(--border);margin:4px 0 34px;}
::-webkit-scrollbar{width:4px;}::-webkit-scrollbar-track{background:var(--bg);}::-webkit-scrollbar-thumb{background:#1e2228;border-radius:4px;}

/* AD BAR */
.ad-bar{background:rgba(15,17,21,0.8);border:1px solid var(--border);border-radius:10px;padding:12px 18px;margin-bottom:30px;display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;backdrop-filter:blur(12px);}
.ad-ph{background:rgba(255,255,255,.02);border:1px dashed rgba(255,255,255,.07);border-radius:7px;padding:14px 32px;text-align:center;font-size:.65rem;color:var(--txt-3);font-family:'DM Mono',monospace;letter-spacing:.06em;}
body.light-theme .ad-ph{background:rgba(0,0,0,.02);border-color:rgba(0,0,0,.07);}
.ad-cl{background:none;border:none;color:var(--txt-3);cursor:pointer;font-size:1rem;padding:4px;transition:.2s;}
.ad-cl:hover{color:var(--txt-2);}

/* CONTINUE WATCHING */
.cw-sec{margin-bottom:42px;animation:cwFadeIn .5s var(--ease) both;}
@keyframes cwFadeIn{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
.cw-card{flex:0 0 210px;width:210px;height:122px;border-radius:10px;overflow:hidden;position:relative;cursor:pointer;background:var(--bg-card);border:1px solid var(--border);box-shadow:var(--sh-card);transition:transform .28s var(--ease),border-color .28s,box-shadow .28s;flex-shrink:0;}
.cw-card:hover{transform:scale(1.04) translateY(-4px);z-index:10;border-color:var(--border-bright);box-shadow:var(--sh-hover);}
.cw-card img{width:100%;height:100%;object-fit:cover;display:block;transition:filter .28s;}
.cw-card:hover img{filter:brightness(.35) saturate(.6);}
.cw-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(8,10,12,0.98) 0%,rgba(8,10,12,0.5) 45%,transparent 70%);opacity:0;transition:opacity .28s;display:flex;flex-direction:column;justify-content:flex-end;padding:9px 10px 11px;}
body.light-theme .cw-overlay{background:linear-gradient(to top,rgba(240,242,245,0.98) 0%,rgba(240,242,245,0.6) 45%,transparent 70%);}
.cw-card:hover .cw-overlay{opacity:1;}
.cw-title{font-size:.75rem;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:2px;letter-spacing:.01em;}
.cw-meta{font-size:.6rem;color:var(--txt-2);margin-bottom:7px;font-family:'DM Mono',monospace;}
.cw-actions{display:flex;gap:5px;}
.cw-btn-play{flex:1;background:var(--txt);color:var(--bg);border:none;border-radius:5px;font-size:.62rem;font-weight:800;padding:5px 4px;cursor:pointer;font-family:'Syne',sans-serif;display:flex;align-items:center;justify-content:center;gap:3px;transition:.15s;letter-spacing:.04em;}
.cw-btn-play:hover{opacity:.85;}
.cw-btn-rm{width:26px;height:26px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);color:var(--txt-2);border-radius:5px;cursor:pointer;font-size:.7rem;display:flex;align-items:center;justify-content:center;transition:.15s;flex-shrink:0;}
body.light-theme .cw-btn-rm{background:rgba(0,0,0,.06);border-color:rgba(0,0,0,.1);}
.cw-btn-rm:hover{background:rgba(255,60,60,.15);border-color:rgba(255,60,60,.3);color:#e06060;}
.cw-prog-wrap{position:absolute;bottom:0;left:0;right:0;height:2px;background:rgba(255,255,255,.08);}
.cw-prog-bar{height:100%;background:linear-gradient(90deg,rgba(255,255,255,0.6),rgba(200,210,230,0.3));border-radius:0 1px 1px 0;transition:width .3s;}
.cw-prog-label{position:absolute;top:6px;left:7px;background:rgba(8,10,12,.85);border:1px solid var(--border);color:var(--txt-2);font-size:.55rem;font-weight:700;padding:1px 6px;border-radius:8px;backdrop-filter:blur(6px);font-family:'DM Mono',monospace;}
body.light-theme .cw-prog-label{background:rgba(240,242,245,.9);}
.cw-rm-corner{position:absolute;top:6px;right:7px;width:20px;height:20px;border-radius:50%;background:rgba(8,10,12,.8);border:1px solid rgba(255,255,255,.1);color:var(--txt-3);font-size:.6rem;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:.2s;z-index:5;opacity:0;}
body.light-theme .cw-rm-corner{background:rgba(240,242,245,.85);}
.cw-card:hover .cw-rm-corner{opacity:1;}
.cw-rm-corner:hover{background:rgba(255,60,60,.25);border-color:rgba(255,60,60,.4);color:#e06060;}

/* CALENDAR */
.cal-sec{margin-top:50px;margin-bottom:60px;}
.cal-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
.cal-title{font-size:.78rem;font-weight:700;display:flex;align-items:center;gap:10px;letter-spacing:.08em;text-transform:uppercase;color:var(--silver);font-family:'DM Mono',monospace;}
.cmn{display:flex;align-items:center;gap:7px;}
.cmn button{background:rgba(255,255,255,.04);border:1px solid var(--border);color:var(--txt-2);width:30px;height:30px;border-radius:6px;cursor:pointer;font-size:.8rem;transition:.2s;display:flex;align-items:center;justify-content:center;}
body.light-theme .cmn button{background:rgba(0,0,0,.04);}
.cmn button:hover{background:rgba(255,255,255,.08);color:var(--txt);border-color:var(--border-bright);}
body.light-theme .cmn button:hover{background:rgba(0,0,0,.08);}
.cml{font-size:.78rem;font-weight:700;color:var(--silver);min-width:100px;text-align:center;font-family:'DM Mono',monospace;letter-spacing:.06em;text-transform:uppercase;}
.ctw{overflow-x:auto;border-radius:12px;border:1px solid var(--border);background:rgba(15,17,21,0.6);backdrop-filter:blur(12px);}
body.light-theme .ctw{background:rgba(255,255,255,0.7);}
.ct2{width:100%;border-collapse:collapse;min-width:580px;}
.ct2 th{padding:11px 16px;font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--txt-3);border-bottom:1px solid var(--border);text-align:left;background:rgba(255,255,255,.018);font-family:'DM Mono',monospace;}
body.light-theme .ct2 th{background:rgba(0,0,0,.018);}
.ct2 td{padding:9px 16px;border-bottom:1px solid rgba(255,255,255,.03);vertical-align:middle;font-size:.8rem;}
body.light-theme .ct2 td{border-bottom-color:rgba(0,0,0,.04);}
.ct2 tr:last-child td{border-bottom:none;}
.ct2 tr:hover td{background:rgba(255,255,255,.025);}
body.light-theme .ct2 tr:hover td{background:rgba(0,0,0,.025);}
.cal-poster{width:38px;height:55px;object-fit:cover;border-radius:5px;border:1px solid var(--border);flex-shrink:0;}
.csc{display:flex;align-items:center;gap:11px;}
.csn{font-weight:700;color:var(--txt);font-size:.82rem;letter-spacing:.01em;}
.csm{font-size:.65rem;color:var(--txt-3);margin-top:2px;font-family:'DM Mono',monospace;}
.ceb{display:inline-flex;align-items:center;gap:4px;background:rgba(255,255,255,0.05);border:1px solid var(--border-bright);color:var(--silver);padding:2px 9px;border-radius:20px;font-size:.65rem;font-weight:700;white-space:nowrap;font-family:'DM Mono',monospace;letter-spacing:.04em;}
body.light-theme .ceb{background:rgba(0,0,0,.05);}
.ceb.new{background:rgba(255,255,255,0.07);border-color:rgba(255,255,255,0.2);color:var(--txt);}
body.light-theme .ceb.new{background:rgba(0,0,0,.07);border-color:rgba(0,0,0,.18);}
.cdc{font-weight:600;color:var(--txt-2);white-space:nowrap;font-size:.78rem;font-family:'DM Mono',monospace;}
.cdc .cday{font-size:1rem;font-weight:800;color:var(--txt);display:block;letter-spacing:.02em;}
.cdc .cwdy{font-size:.6rem;color:var(--txt-3);text-transform:uppercase;letter-spacing:.08em;}
.cdt .cday{color:var(--accent-bright);}
.cpf{font-size:.65rem;color:var(--txt-3);white-space:nowrap;font-family:'DM Mono',monospace;}
.cpf span{background:rgba(255,255,255,.05);border:1px solid var(--border);padding:2px 8px;border-radius:4px;}
body.light-theme .cpf span{background:rgba(0,0,0,.05);}
.cale{text-align:center;padding:40px 20px;color:var(--txt-3);font-size:.78rem;font-family:'DM Mono',monospace;letter-spacing:.06em;}
.caltabs{display:flex;gap:5px;flex-wrap:wrap;}
.caltab{padding:4px 13px;border-radius:20px;font-size:.65rem;font-weight:700;cursor:pointer;border:1px solid var(--border);background:transparent;color:var(--txt-3);font-family:'DM Mono',monospace;transition:.2s;letter-spacing:.06em;text-transform:uppercase;}
.caltab.active{background:rgba(255,255,255,.08);border-color:var(--border-bright);color:var(--txt);}
body.light-theme .caltab.active{background:rgba(0,0,0,.08);}
.caltab:hover{background:rgba(255,255,255,.05);color:var(--txt-2);}
body.light-theme .caltab:hover{background:rgba(0,0,0,.05);}

/* ANDROID BTN */
.and-btn{position:fixed;bottom:24px;left:20px;z-index:9990;background:rgba(15,17,21,0.95);border:1px solid var(--border-bright);color:var(--silver);padding:9px 15px;border-radius:28px;font-size:.7rem;font-weight:700;font-family:'DM Mono',monospace;cursor:pointer;display:flex;align-items:center;gap:7px;box-shadow:0 4px 24px rgba(0,0,0,0.5);transition:.2s;letter-spacing:.05em;backdrop-filter:blur(12px);}
body.light-theme .and-btn{background:rgba(240,242,245,0.97);}
.and-btn:hover{box-shadow:0 6px 32px rgba(0,0,0,0.65);transform:translateY(-1px);}
.and-btn.active{border-color:rgba(255,255,255,0.25);color:var(--txt);}

@media(min-width:600px){:root{--card-w:185px;--card-h:278px;--hdr:64px;}header{padding:0 30px;}.hero{padding:0 30px 48px;}main{padding:32px 30px 90px;}}
@media(min-width:1024px){:root{--card-w:198px;--card-h:298px;--hdr:66px;}header{padding:0 4%;}.hero{min-height:480px;max-height:660px;padding:0 4% 56px;}main{padding:34px 4% 90px;}}
@media(min-width:1600px){:root{--card-w:218px;--card-h:328px;}}
@media(max-width:599px){
  :root{--card-w:130px;--card-h:195px;--gap:8px;}
  .mc{border-radius:8px;}.mc:hover{transform:scale(1.04) translateY(-3px);}
  .ct{font-size:.7rem;}.cm{font-size:.58rem;gap:3px;}.cb{padding:5px 0;}.cb-p{font-size:.6rem;}.cb-f{flex:0 0 28px;width:28px;}.cn{font-size:.5rem;width:18px;height:18px;top:5px;left:5px;}.co{padding:9px;}
  .hero{min-height:62vw;padding:0 16px 30px;}.hero h1{font-size:2.6rem;}.hero p{font-size:.78rem;max-width:100%;}
  .btn-play,.btn-more{padding:9px 16px;font-size:.72rem;}
  main{padding:20px 16px calc(var(--mob-nav-h) + 32px)!important;}
  .sec-title{font-size:.68rem;}.sec-hdr{margin-bottom:11px;}
  header{padding:0 16px;}.logo img{height:28px;}nav.mnav{display:none;}
  .cw-card{flex:0 0 170px;width:170px;height:100px;}.cw-title{font-size:.7rem;}.cw-meta{font-size:.57rem;}
}
/* MOBİL BOTTOM NAV */
.mob-nav{display:none;position:fixed;bottom:0;left:0;right:0;height:var(--mob-nav-h);z-index:300;background:rgba(8,10,12,0.97);backdrop-filter:blur(28px) saturate(1.8);-webkit-backdrop-filter:blur(28px) saturate(1.8);border-top:1px solid var(--border);box-shadow:0 -8px 40px rgba(0,0,0,0.7);}
body.light-theme .mob-nav{background:rgba(240,242,245,0.97);}
@media(max-width:767px){.mob-nav{display:flex;}main{padding-bottom:calc(var(--mob-nav-h) + 32px)!important;}.toast{bottom:calc(var(--mob-nav-h) + 10px);}.and-btn{bottom:calc(var(--mob-nav-h) + 10px);}}
.mob-nav-inner{display:flex;width:100%;height:100%;align-items:stretch;padding:0 4px;}
.mob-ni{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;text-decoration:none;color:var(--txt-3);font-size:.55rem;font-weight:700;letter-spacing:.04em;text-transform:uppercase;border:none;background:transparent;cursor:pointer;font-family:'DM Mono',monospace;padding:8px 2px 10px;position:relative;transition:color .22s var(--ease);-webkit-tap-highlight-color:transparent;overflow:hidden;}
.mob-ni.mob-active,.mob-ni:focus-visible{color:var(--txt);}
.mob-ni::before{content:'';position:absolute;top:0;left:50%;transform:translateX(-50%) scaleX(0);width:24px;height:1px;background:rgba(255,255,255,0.6);border-radius:0 0 2px 2px;transition:transform .28s var(--ease),opacity .28s;opacity:0;}
body.light-theme .mob-ni::before{background:rgba(0,0,0,0.5);}
.mob-ni.mob-active::before{transform:translateX(-50%) scaleX(1);opacity:1;}
.mob-ni-ico{width:24px;height:24px;display:flex;align-items:center;justify-content:center;position:relative;transition:transform .22s var(--ease);}
.mob-ni:active .mob-ni-ico{transform:scale(0.85);}
.mob-ni.mob-active .mob-ni-ico{filter:drop-shadow(0 0 5px rgba(255,255,255,0.3));}
body.light-theme .mob-ni.mob-active .mob-ni-ico{filter:drop-shadow(0 0 5px rgba(0,0,0,0.2));}
.mob-ni svg{width:19px;height:19px;stroke:currentColor;fill:none;stroke-width:1.6;stroke-linecap:round;stroke-linejoin:round;transition:stroke .22s;}
.mob-ni-badge{position:absolute;top:-2px;right:-4px;background:var(--txt);color:var(--bg);border-radius:50%;width:13px;height:13px;font-size:7px;font-weight:900;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--bg);line-height:1;font-family:'DM Mono',monospace;}
.mob-ni-ripple{position:absolute;inset:0;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.08) 0%,transparent 70%);transform:scale(0);opacity:0;pointer-events:none;transition:transform .4s var(--ease),opacity .4s;}
body.light-theme .mob-ni-ripple{background:radial-gradient(circle,rgba(0,0,0,0.06) 0%,transparent 70%);}
.mob-ni:active .mob-ni-ripple{transform:scale(3);opacity:1;}
.mob-ni-lbl{font-size:.52rem;font-weight:700;letter-spacing:.05em;line-height:1;transition:color .22s;}
</style>
</head>
<body class="<?= $theme === 'light' ? 'light-theme' : '' ?>">
<div class="noise-overlay"></div>

<!-- LOADING -->
<div class="ls" id="ls">
  <div class="ls-logo"><img src="https://yourfiles.cloud/uploads/d4380759d9fbe11bdf5c47e65f91921c/%2B-removebg-preview.png" alt="WOXPLUS"></div>
  <div class="ls-bar"><div class="ls-fill"></div></div>
  <div class="ls-txt"><?= htmlspecialchars($t['loading']) ?></div>
</div>

<!-- SETTINGS MODAL -->
<div class="settings-overlay" id="settingsOverlay" onclick="if(event.target===this)closeSettings()">
  <div class="settings-modal">
    <div class="settings-modal-hdr">
      <span class="settings-modal-title"><?= htmlspecialchars($t['settings_title']) ?></span>
      <button class="settings-close" onclick="closeSettings()">✕</button>
    </div>
    <div class="settings-group">
      <span class="settings-label"><?= htmlspecialchars($t['theme_label']) ?></span>
      <div class="settings-opts">
        <button class="settings-opt <?= $theme === 'dark' ? 'active' : '' ?>" data-val="dark" onclick="selectOpt(this,'theme')"><?= htmlspecialchars($t['dark_theme']) ?></button>
        <button class="settings-opt <?= $theme === 'light' ? 'active' : '' ?>" data-val="light" onclick="selectOpt(this,'theme')"><?= htmlspecialchars($t['light_theme']) ?></button>
      </div>
    </div>
    <div class="settings-group">
      <span class="settings-label"><?= htmlspecialchars($t['lang_label']) ?></span>
      <div class="settings-opts">
        <button class="settings-opt <?= $lang === 'tr' ? 'active' : '' ?>" data-val="tr" onclick="selectOpt(this,'lang')">🇹🇷 Türkçe</button>
        <button class="settings-opt <?= $lang === 'en' ? 'active' : '' ?>" data-val="en" onclick="selectOpt(this,'lang')">🇬🇧 English</button>
        <button class="settings-opt <?= $lang === 'de' ? 'active' : '' ?>" data-val="de" onclick="selectOpt(this,'lang')">🇩🇪 Deutsch</button>
      </div>
    </div>
    <button class="settings-save" onclick="saveSettings()"><?= htmlspecialchars($t['save_settings']) ?></button>
  </div>
</div>

<div id="main-app" style="opacity:0;transition:opacity .4s">

<!-- TV SIDENAV -->
<nav class="tv-sidenav" id="tvNav">
  <div class="tv-si">
    <a href="#" class="tv-ni active-nav focusable" data-sec="top"><span class="icon">🏠</span><span class="lbl"><?= htmlspecialchars($t['home']) ?></span></a>
    <a href="#trends" class="tv-ni focusable"><span class="icon">🔥</span><span class="lbl"><?= htmlspecialchars($t['trends']) ?></span></a>
    <a href="#action" class="tv-ni focusable"><span class="icon">⚡</span><span class="lbl"><?= htmlspecialchars($t['energy']) ?></span></a>
    <a href="#series" class="tv-ni focusable"><span class="icon">📺</span><span class="lbl"><?= htmlspecialchars($t['series']) ?></span></a>
    <a href="#movies" class="tv-ni focusable"><span class="icon">🎬</span><span class="lbl"><?= htmlspecialchars($t['movies']) ?></span></a>
    <a href="#favorites" class="tv-ni focusable"><span class="icon">❤️</span><span class="lbl"><?= htmlspecialchars($t['mylist']) ?></span></a>
    <a href="#calendar" class="tv-ni focusable"><span class="icon">📅</span><span class="lbl"><?= htmlspecialchars($t['calendar']) ?></span></a>
  </div>
  <button class="tv-toggle" id="tvTog">❯</button>
</nav>
<div class="tv-ind">📺 Android <?= htmlspecialchars($t['android_mode']) ?></div>

<!-- HEADER -->
<header id="hdr">
  <a href="index.php" class="logo"><img src="https://yourfiles.cloud/uploads/d4380759d9fbe11bdf5c47e65f91921c/%2B-removebg-preview.png" alt="WOXPLUS"></a>
  <nav class="mnav">
    <a href="#" class="active"><?= htmlspecialchars($t['home']) ?></a>
    <a href="/gl.php"><?= htmlspecialchars($t['shorts']) ?></a>
    <a href="/destek-ekibi"><?= htmlspecialchars($t['support']) ?></a>
    <a href="#movies"><?= htmlspecialchars($t['movies']) ?></a>
    <a href="#favorites"><?= htmlspecialchars($t['mylist']) ?></a>
    <a href="#calendar">📅 <?= htmlspecialchars($t['calendar']) ?></a>
  </nav>
  <div class="hdr-r">
    <div class="upbadge">
      <img class="uav" src="https://m.media-amazon.com/images/G/01/CST/Prism/Avatars/img_profile_avatar_animals_panda_circ.png" alt="">
      <span class="uname"><?= htmlspecialchars($t['guest']) ?></span>
    </div>
    <!-- TV'ye Yansıt Butonu -->
    <button class="cast-btn" id="castBtn" onclick="toggleCast()" title="<?= htmlspecialchars($t['cast_tv']) ?>">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 8.4C2 6 4.686 4 8 4h8c3.314 0 6 2 6 4.4v7.2C22 18 19.314 20 16 20h-4"/><path d="M2 15.6C2 18 4.686 20 8 20"/><circle cx="5" cy="20" r="2"/></svg>
      <span class="cast-lbl"><?= htmlspecialchars($t['cast_tv']) ?></span>
    </button>
    <!-- Ayarlar Butonu -->
    <button class="settings-btn" onclick="openSettings()" title="<?= htmlspecialchars($t['settings']) ?>">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
      <span class="settings-lbl"><?= htmlspecialchars($t['settings']) ?></span>
    </button>
    <button class="btn-lo" onclick="doLogout()"><?= htmlspecialchars($t['logout']) ?></button>
    <button class="fav-btn" onclick="document.getElementById('favorites').scrollIntoView({behavior:'smooth'})" title="<?= htmlspecialchars($t['mylist']) ?>">
      ❤️<span class="fav-cnt" id="fav-cnt">0</span>
    </button>
  </div>
</header>

<!-- HERO -->
<section class="hero">
  <div class="hero-c">
    <div class="hero-badge"><?= htmlspecialchars($t['hero_badge']) ?></div>
    <h1>Shin chan<br>Spin-off</h1>
    <p><?= htmlspecialchars($t['hero_desc']) ?></p>
    <div class="hero-acts">
      <button class="btn-play" onclick="window.open('https://www.netflix.com','_blank')"><?= htmlspecialchars($t['watch_now']) ?></button>
      <button class="btn-more"><?= htmlspecialchars($t['more_info']) ?></button>
    </div>
  </div>
</section>

<main>

<!-- AD BAR -->
<div class="ad-bar" id="ad-bar">
  <div class="ad-ph">🎯 Reklam Alanı — 728×90</div>
  <div style="font-size:.72rem;color:var(--txt-3);font-family:'DM Mono',monospace;">
    <strong style="color:var(--txt-2)">Üyelik</strong> — Bitiş: <strong style="color:var(--silver)"></strong>
  </div>
  <button class="ad-cl" onclick="this.closest('.ad-bar').style.display='none'">✕</button>
</div>

<!-- İZLEMEYE DEVAM ET -->
<section class="sec cw-sec" id="continue-watching" style="display:none">
  <div class="sec-hdr">
    <div class="sec-title"><?= htmlspecialchars($t['continue_watch']) ?> <span class="badge" id="cw-badge">0</span></div>
    <a class="see-all" href="#" onclick="cwClearAll(event)"><?= htmlspecialchars($t['clear_all']) ?></a>
  </div>
  <div class="sl-c">
    <button class="sl-arr l">❮</button>
    <div class="sl-w"><div class="sl" id="cw-sl"></div></div>
    <button class="sl-arr r">❯</button>
  </div>
</section>

<!-- TRENDLER -->
<section class="sec" id="trends">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['trends_title']) ?> <span class="badge"><?= htmlspecialchars($t['new_badge']) ?></span></div><a class="see-all" href="#"><?= htmlspecialchars($t['see_all']) ?></a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
  <div class="mc focusable">
  <img src="https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p12506111_b_v8_ab.jpg" alt="Beavis And Butthead" loading="lazy">
  <div class="cn">1</div>
  <div class="co"><div class="ct">Beavis And Butthead</div><div class="cm"><span>2016</span><span>•</span><span>Sci-Fi</span><span class="cr">★ 8.7</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,1,'Beavis And Butthead','https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p12506111_b_v8_ab.jpg','http://playcloudmovie0.ct.ws/player4.html','2016','Sci-Fi','8.7')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="1" onclick="toggleFav(this,1,'Beavis And Butthead','https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p12506111_b_v8_ab.jpg','http://playcloudmovie0.ct.ws/player4.html','2016','Sci-Fi','8.7')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://mediaproxy.tvtropes.org/width/1200/https://static.tvtropes.org/pmwiki/pub/images/ben_10_ultimate_alien.png" alt="Ben 10 Ultimate Alien" loading="lazy">
  <div class="cn">2</div>
  <div class="co"><div class="ct">Ben 10 Ultimate Alien</div><div class="cm"><span>2016</span><span>•</span><span>Drama</span><span class="cr">★ 8.7</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,2,'Ben 10 Ultimate Alien','https://mediaproxy.tvtropes.org/width/1200/https://static.tvtropes.org/pmwiki/pub/images/ben_10_ultimate_alien.png','/ben10u.html','2016','Drama','8.7')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="2" onclick="toggleFav(this,2,'Ben 10 Ultimate Alien','https://mediaproxy.tvtropes.org/width/1200/https://static.tvtropes.org/pmwiki/pub/images/ben_10_ultimate_alien.png','/ben10u.html','2016','Drama','8.7')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://m.media-amazon.com/images/I/813YVUNJ7xL.jpg" alt="Mighty Nein" loading="lazy">
  <div class="cn">3</div>
  <div class="co"><div class="ct">Mighty Nein</div><div class="cm"><span>2021</span><span>•</span><span>Thriller</span><span class="cr">★ 8.0</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,3,'Mighty Nein','https://m.media-amazon.com/images/I/813YVUNJ7xL.jpg','http://playnetflixcloud.ct.ws/la.html','2021','Thriller','8.0')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="3" onclick="toggleFav(this,3,'Mighty Nein','https://m.media-amazon.com/images/I/813YVUNJ7xL.jpg','http://playnetflixcloud.ct.ws/la.html','2021','Thriller','8.0')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://i.redd.it/13-years-ago-today-ben-10-alien-force-premiered-on-cartoon-v0-eq7sgbxh81u61.jpg?width=780&format=pjpg&auto=webp&s=d68478a1eb7fd11f85145a82896d3400e6d52b40" alt="Ben10 Alien Force" loading="lazy">
  <div class="cn">4</div>
  <div class="co"><div class="ct">Ben10 Alien Force</div><div class="cm"><span>2017</span><span>•</span><span>Crime</span><span class="cr">★ 8.4</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,4,'Ben10 Alien Force','https://i.redd.it/13-years-ago-today-ben-10-alien-force-premiered-on-cartoon-v0-eq7sgbxh81u61.jpg?width=780&format=pjpg&auto=webp&s=d68478a1eb7fd11f85145a82896d3400e6d52b40','/ben10a.html','2017','Crime','8.4')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="4" onclick="toggleFav(this,4,'Ben10 Alien Force','https://i.redd.it/13-years-ago-today-ben-10-alien-force-premiered-on-cartoon-v0-eq7sgbxh81u61.jpg?width=780&format=pjpg&auto=webp&s=d68478a1eb7fd11f85145a82896d3400e6d52b40','/ben10a.html','2017','Crime','8.4')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://img1.hulu.com/user/v3/artwork/91de62df-0394-4e17-85a8-e843bd730ede?base_image_bucket_name=image_manager&base_image=019a9e0b-b1b1-7762-8a2a-837d1cb00d44&size=458x687&format=webp" alt="Gumball 2025" loading="lazy">
  <div class="cn">5</div>
  <div class="co"><div class="ct">Gumball 2025</div><div class="cm"><span>2015</span><span>•</span><span>Crime</span><span class="cr">★ 8.8</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,5,'Gumball 2025','https://img1.hulu.com/user/v3/artwork/91de62df-0394-4e17-85a8-e843bd730ede?base_image_bucket_name=image_manager&base_image=019a9e0b-b1b1-7762-8a2a-837d1cb00d44&size=458x687&format=webp','/gumball2025.php','2015','Crime','8.8')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="5" onclick="toggleFav(this,5,'Gumball 2025','https://img1.hulu.com/user/v3/artwork/91de62df-0394-4e17-85a8-e843bd730ede?base_image_bucket_name=image_manager&base_image=019a9e0b-b1b1-7762-8a2a-837d1cb00d44&size=458x687&format=webp','/gumball2025.php','2015','Crime','8.8')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://m.media-amazon.com/images/M/MV5BOGIyNGRiNzgtOWQxZC00YzJmLThlZTYtYTMyMDk0YWZjMTk5XkEyXkFqcGc@._V1_QL75_UX190_CR0,0,190,281_.jpg" alt="Alien Earth" loading="lazy">
  <div class="cn">6</div>
  <div class="co"><div class="ct">Alien Earth</div><div class="cm"><span>2017</span><span>•</span><span>Mystery</span><span class="cr">★ 8.8</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,6,'Alien Earth','https://m.media-amazon.com/images/M/MV5BOGIyNGRiNzgtOWQxZC00YzJmLThlZTYtYTMyMDk0YWZjMTk5XkEyXkFqcGc@._V1_QL75_UX190_CR0,0,190,281_.jpg','https://netflixfree.xo.je/alien.html?i=1','2017','Mystery','8.8')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="6" onclick="toggleFav(this,6,'Alien Earth','https://m.media-amazon.com/images/M/MV5BOGIyNGRiNzgtOWQxZC00YzJmLThlZTYtYTMyMDk0YWZjMTk5XkEyXkFqcGc@._V1_QL75_UX190_CR0,0,190,281_.jpg','https://netflixfree.xo.je/alien.html?i=1','2017','Mystery','8.8')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://m.media-amazon.com/images/M/MV5BZGJjMmI3ZDMtZTgyNi00MTZhLWE2ZjAtN2Q4YTUyMTg4OGY1XkEyXkFqcGc@._V1_.jpg" alt="Steven Universe" loading="lazy">
  <div class="cn">7</div>
  <div class="co"><div class="ct">Steven Universe</div><div class="cm"><span>2017</span><span>•</span><span>Action</span><span class="cr">★ 8.2</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,7,'Steven Universe','https://m.media-amazon.com/images/M/MV5BZGJjMmI3ZDMtZTgyNi00MTZhLWE2ZjAtN2Q4YTUyMTg4OGY1XkEyXkFqcGc@._V1_.jpg','http://playcloudmovie0.ct.ws/player3.html','2017','Action','8.2')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="7" onclick="toggleFav(this,7,'Steven Universe','https://m.media-amazon.com/images/M/MV5BZGJjMmI3ZDMtZTgyNi00MTZhLWE2ZjAtN2Q4YTUyMTg4OGY1XkEyXkFqcGc@._V1_.jpg','http://playcloudmovie0.ct.ws/player3.html','2017','Action','8.2')">+</button></div></div></div>

  <div class="mc focusable">
  <img src="https://tr.web.img3.acsta.net/pictures/17/05/22/16/49/588696.jpg" alt="Prison Break" loading="lazy">
  <div class="cn">8</div>
  <div class="co"><div class="ct">Prison Break</div><div class="cm"><span>2020</span><span>•</span><span>Romance</span><span class="cr">★ 7.3</span></div>
  <div class="ca"><button class="cb cb-p" onclick="playContent(this,8,'Prison Break','https://tr.web.img3.acsta.net/pictures/17/05/22/16/49/588696.jpg','https://playnetflixcloud.ct.ws/break.html','2020','Romance','7.3')">▶ <?= htmlspecialchars($t['watch']) ?></button>
  <button class="cb cb-f" data-id="8" onclick="toggleFav(this,8,'Prison Break','https://tr.web.img3.acsta.net/pictures/17/05/22/16/49/588696.jpg','https://playnetflixcloud.ct.ws/break.html','2020','Romance','7.3')">+</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- ENERJİ VERİCİ -->
<section class="sec" id="action">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['energy_title']) ?></div><a class="see-all" href="#"><?= htmlspecialchars($t['see_all']) ?></a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqsjwgekj9azQpg2ML2znpkXNU8zyAIKnMZg&s" alt="Wicked" loading="lazy"><div class="co"><div class="ct">Wicked</div><div class="cm"><span>2020</span><span>•</span><span>Action</span><span class="cr">★ 6.7</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,9,'Wicked','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqsjwgekj9azQpg2ML2znpkXNU8zyAIKnMZg&s','https://playnetflixcloud.ct.ws/wicked.html','2020','Action','6.7')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="9" onclick="toggleFav(this,9,'Wicked','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSqsjwgekj9azQpg2ML2znpkXNU8zyAIKnMZg&s','https://playnetflixcloud.ct.ws/wicked.html','2020','Action','6.7')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrRzkKBDEzf7TMbh6-29wCujSxzn1IhpAS1g&s" alt="Superman" loading="lazy"><div class="co"><div class="ct">Superman</div><div class="cm"><span>2021</span><span>•</span><span>Action</span><span class="cr">★ 5.7</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,10,'Superman','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrRzkKBDEzf7TMbh6-29wCujSxzn1IhpAS1g&s','https://playnetflixcloud.ct.ws/superman.html','2021','Action','5.7')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="10" onclick="toggleFav(this,10,'Superman','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrRzkKBDEzf7TMbh6-29wCujSxzn1IhpAS1g&s','https://playnetflixcloud.ct.ws/superman.html','2021','Action','5.7')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNFjOhue5IVD_HNTQArIo05K8dAXC_L7TOhw&s" alt="Transformers Prime" loading="lazy"><div class="co"><div class="ct">Transformers Prime</div><div class="cm"><span>2020</span><span>•</span><span>Action</span><span class="cr">★ 6.6</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,11,'Transformers Prime','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNFjOhue5IVD_HNTQArIo05K8dAXC_L7TOhw&s','https://playnetflixcloud.ct.ws/prime.html','2020','Action','6.6')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="11" onclick="toggleFav(this,11,'Transformers Prime','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNFjOhue5IVD_HNTQArIo05K8dAXC_L7TOhw&s','https://playnetflixcloud.ct.ws/prime.html','2020','Action','6.6')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BZmMwMDlkNTEtMmQzZS00ODQ0LWJlZmItOTgwYWMwZGM4MzFiXkEyXkFqcGc@._V1_.jpg" alt="Bojack Horseman" loading="lazy"><div class="co"><div class="ct">Bojack Horseman</div><div class="cm"><span>2019</span><span>•</span><span>Action</span><span class="cr">★ 6.1</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,12,'Bojack Horseman','https://m.media-amazon.com/images/M/MV5BZmMwMDlkNTEtMmQzZS00ODQ0LWJlZmItOTgwYWMwZGM4MzFiXkEyXkFqcGc@._V1_.jpg','https://www.netflix.com/title/80187340','2019','Action','6.1')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="12" onclick="toggleFav(this,12,'Bojack Horseman','https://m.media-amazon.com/images/M/MV5BZmMwMDlkNTEtMmQzZS00ODQ0LWJlZmItOTgwYWMwZGM4MzFiXkEyXkFqcGc@._V1_.jpg','https://www.netflix.com/title/80187340','2019','Action','6.1')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BZjc5ZDRmOTktMTdjMC00OTQyLTk4NDktN2Y3OWY0ZDNjZTc1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Central Park" loading="lazy"><div class="co"><div class="ct">Central Park</div><div class="cm"><span>2020</span><span>•</span><span>Action</span><span class="cr">★ 6.0</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,13,'Central Park','https://m.media-amazon.com/images/M/MV5BZjc5ZDRmOTktMTdjMC00OTQyLTk4NDktN2Y3OWY0ZDNjZTc1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','http://playcloudmovie0.ct.ws/player6.html','2020','Action','6.0')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="13" onclick="toggleFav(this,13,'Central Park','https://m.media-amazon.com/images/M/MV5BZjc5ZDRmOTktMTdjMC00OTQyLTk4NDktN2Y3OWY0ZDNjZTc1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','http://playcloudmovie0.ct.ws/player6.html','2020','Action','6.0')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQfUdHdoMyvXfvIZWQGfnteU8X5C_52CRHEig&s" alt="Adventure Time" loading="lazy"><div class="co"><div class="ct">Adventure Time</div><div class="cm"><span>2020</span><span>•</span><span>Action</span><span class="cr">★ 6.0</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,30,'Adventure Time','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQfUdHdoMyvXfvIZWQGfnteU8X5C_52CRHEig&s','/adventuretime.html','2020','Action','6.0')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="30" onclick="toggleFav(this,30,'Adventure Time','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQfUdHdoMyvXfvIZWQGfnteU8X5C_52CRHEig&s','/adventuretime.html','2020','Action','6.0')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BYWQwMGRhNGEtZTNhMy00MzVjLWJhMjItYjcwMDljMTkyNTg2XkEyXkFqcGc@._V1_.jpg" alt="The Walking Dead" loading="lazy"><div class="co"><div class="ct">The Walking Dead</div><div class="cm"><span>2020</span><span>•</span><span>Action</span><span class="cr">★ 6.0</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,31,'The Walking Dead','https://m.media-amazon.com/images/M/MV5BYWQwMGRhNGEtZTNhMy00MzVjLWJhMjItYjcwMDljMTkyNTg2XkEyXkFqcGc@._V1_.jpg','/walking.html','2020','Action','6.0')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="31" onclick="toggleFav(this,31,'The Walking Dead','https://m.media-amazon.com/images/M/MV5BYWQwMGRhNGEtZTNhMy00MzVjLWJhMjItYjcwMDljMTkyNTg2XkEyXkFqcGc@._V1_.jpg','/walking.html','2020','Action','6.0')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYqdmwnE0QopCQ4S3pNXw9yWh5cwCxktCjUQ&s" alt="Stranger Things" loading="lazy"><div class="co"><div class="ct">Stranger Things</div><div class="cm"><span>2021</span><span>•</span><span>Action</span><span class="cr">★ 6.3</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,14,'Stranger Things','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYqdmwnE0QopCQ4S3pNXw9yWh5cwCxktCjUQ&s','https://netflixfree.xo.je/stranger.html','2021','Action','6.3')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="14" onclick="toggleFav(this,14,'Stranger Things','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYqdmwnE0QopCQ4S3pNXw9yWh5cwCxktCjUQ&s','https://netflixfree.xo.je/stranger.html','2021','Action','6.3')">+</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- GENÇ ANİMASYONLARI -->
<section class="sec" id="animation">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['anim_title']) ?></div><a class="see-all" href="#"><?= htmlspecialchars($t['see_all']) ?></a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BOGVlYjgyYjItN2M2MC00YzhkLThlNGQtOTdjZDQ2MDY1YTQ5XkEyXkFqcGc@._V1_.jpg" alt="Universal Basic Guys" loading="lazy"><div class="co"><div class="ct">Universal Basic Guys</div><div class="cm"><span>2022</span><span>•</span><span>Comedy</span><span class="cr">★ 8.1</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,28,'Universal Basic Guys','https://m.media-amazon.com/images/M/MV5BOGVlYjgyYjItN2M2MC00YzhkLThlNGQtOTdjZDQ2MDY1YTQ5XkEyXkFqcGc@._V1_.jpg','/universal.php','2022','Comedy','8.1')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="28" onclick="toggleFav(this,28,'Universal Basic Guys','https://m.media-amazon.com/images/M/MV5BOGVlYjgyYjItN2M2MC00YzhkLThlNGQtOTdjZDQ2MDY1YTQ5XkEyXkFqcGc@._V1_.jpg','/universal.php','2022','Comedy','8.1')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg" alt="Family Guy" loading="lazy"><div class="co"><div class="ct">Family Guy</div><div class="cm"><span>2020</span><span>•</span><span>Romance</span><span class="cr">★ 7.2</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,29,'Family Guy','https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg','/familyguy.html','2020','Romance','7.2')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="29" onclick="toggleFav(this,29,'Family Guy','https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg','/familyguy.html','2020','Romance','7.2')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="The Simpsons" loading="lazy"><div class="co"><div class="ct">The Simpsons</div><div class="cm"><span>2013</span><span>•</span><span>Crime</span><span class="cr">★ 8.8</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,30,'The Simpsons','https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/thesimpsonss.html','2013','Crime','8.8')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="30" onclick="toggleFav(this,30,'The Simpsons','https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/thesimpsonss.html','2013','Crime','8.8')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BZTYxZjA0MjQtZTViNi00ZWI2LWFmNGUtMzIxZWVjYTE4M2JkXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="The Greath North" loading="lazy"><div class="co"><div class="ct">The Greath North</div><div class="cm"><span>2019</span><span>•</span><span>Fantasy</span><span class="cr">★ 8.2</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,31,'The Greath North','https://m.media-amazon.com/images/M/MV5BZTYxZjA0MjQtZTViNi00ZWI2LWFmNGUtMzIxZWVjYTE4M2JkXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/great.php','2019','Fantasy','8.2')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="31" onclick="toggleFav(this,31,'The Greath North','https://m.media-amazon.com/images/M/MV5BZTYxZjA0MjQtZTViNi00ZWI2LWFmNGUtMzIxZWVjYTE4M2JkXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/great.php','2019','Fantasy','8.2')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://upload.wikimedia.org/wikipedia/en/thumb/6/66/Beavis_and_Butt-head_2022_film_poster.jpg/250px-Beavis_and_Butt-head_2022_film_poster.jpg" alt="Beavis ve Butthead Filmi 2" loading="lazy"><div class="co"><div class="ct">Beavis ve Butthead Filmi 2</div><div class="cm"><span>2021</span><span>•</span><span>Crime</span><span class="cr">★ 7.5</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,38,'Beavis ve Butthead Filmi 2','https://upload.wikimedia.org/wikipedia/en/thumb/6/66/Beavis_and_Butt-head_2022_film_poster.jpg/250px-Beavis_and_Butt-head_2022_film_poster.jpg','/beavism.php','2021','Crime','7.5')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="38" onclick="toggleFav(this,38,'Beavis ve Butthead Filmi 2','https://upload.wikimedia.org/wikipedia/en/thumb/6/66/Beavis_and_Butt-head_2022_film_poster.jpg/250px-Beavis_and_Butt-head_2022_film_poster.jpg','/beavism.php','2021','Crime','7.5')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://www.blackstonepublishing.com/cdn/shop/files/bhdr-Rectangle-cover.jpg?v=1771613067" alt="Shogun" loading="lazy"><div class="co"><div class="ct">Shogun</div><div class="cm"><span>2021</span><span>•</span><span>Crime</span><span class="cr">★ 7.5</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,39,'Beavis ve Butthead Filmi 1','https://www.blackstonepublishing.com/cdn/shop/files/bhdr-Rectangle-cover.jpg?v=1771613067','/shogun.php','2021','Crime','7.5')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="39" onclick="toggleFav(this,39,'Beavis ve Butthead Filmi 1','https://www.blackstonepublishing.com/cdn/shop/files/bhdr-Rectangle-cover.jpg?v=1771613067','/shogun.php','2021','Crime','7.5')">+</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- DİZİLER -->
<section class="sec" id="series">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['series_title']) ?></div><a class="see-all" href="#"><?= htmlspecialchars($t['see_all']) ?></a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7AUQ1ap545wJq1Op_9GPLFAV15boesLoyZA&s" alt="Breaking Bad" loading="lazy"><div class="co"><div class="ct">Breaking Bad</div><div class="cm"><span>2022</span><span>•</span><span>Comedy</span><span class="cr">★ 8.1</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,15,'Breaking Bad','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7AUQ1ap545wJq1Op_9GPLFAV15boesLoyZA&s','https://playnetflixcloud.ct.ws/break.html','2022','Comedy','8.1')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="15" onclick="toggleFav(this,15,'Breaking Bad','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7AUQ1ap545wJq1Op_9GPLFAV15boesLoyZA&s','https://playnetflixcloud.ct.ws/break.html','2022','Comedy','8.1')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BMjA3ODMxMzM5NF5BMl5BanBnXkFtZTgwMDM1NjU0OTE@._V1_FMjpg_UX1000_.jpg" alt="Bones" loading="lazy"><div class="co"><div class="ct">Bones</div><div class="cm"><span>2020</span><span>•</span><span>Romance</span><span class="cr">★ 7.2</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,16,'Family Guy','https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg','/bones.php','2020','Romance','7.2')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="16" onclick="toggleFav(this,16,'Family Guy','https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg','/bones.php','2020','Romance','7.2')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://miam-animation.com/images/Vignettes_GoatGirl" alt="Goat Girl" loading="lazy"><div class="co"><div class="ct">Goat Girl</div><div class="cm"><span>2013</span><span>•</span><span>Crime</span><span class="cr">★ 8.8</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,17,'The Simpsons','https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','http://playcloudmovie0.ct.ws/playerbeta.php','2013','Crime','8.8')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="17" onclick="toggleFav(this,17,'The Simpsons','https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','http://playcloudmovie0.ct.ws/playerbeta.php','2013','Crime','8.8')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwnomNThFwvxl-kirrn19NypwmVsfNohzDyg&s" alt="ICarly" loading="lazy"><div class="co"><div class="ct">ICarly</div><div class="cm"><span>2019</span><span>•</span><span>Fantasy</span><span class="cr">★ 8.2</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,18,'ICarly','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwnomNThFwvxl-kirrn19NypwmVsfNohzDyg&s','/icarly.html','2019','Fantasy','8.2')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="18" onclick="toggleFav(this,18,'ICarly','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwnomNThFwvxl-kirrn19NypwmVsfNohzDyg&s','/icarly.html','2019','Fantasy','8.2')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://i.redd.it/1es0su8z2y9c1.jpeg" alt="One Piece" loading="lazy"><div class="co"><div class="ct">One Piece</div><div class="cm"><span>2021</span><span>•</span><span>Crime</span><span class="cr">★ 7.5</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,19,'One Piece','https://i.redd.it/1es0su8z2y9c1.jpeg','/onepiece.html','2021','Crime','7.5')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="19" onclick="toggleFav(this,19,'One Piece','https://i.redd.it/1es0su8z2y9c1.jpeg','/onepiece.html','2021','Crime','7.5')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://upload.wikimedia.org/wikipedia/en/d/d6/Young_Sherlock_poster.jpg" alt="Young Sherlock" loading="lazy"><div class="co"><div class="ct">Young Sherlock</div><div class="cm"><span>2021</span><span>•</span><span>Crime</span><span class="cr">★ 7.5</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,1119,'Young Sherlock','https://upload.wikimedia.org/wikipedia/en/d/d6/Young_Sherlock_poster.jpg','/sher.html','2021','Crime','7.5')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="1119" onclick="toggleFav(this,1119,'Young Sherlock','https://upload.wikimedia.org/wikipedia/en/d/d6/Young_Sherlock_poster.jpg','/sher.html','2021','Crime','7.5')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BZDNiZDk0M2ItNWM4Zi00YjQ0LWJjOGItMDFlMmQ2NTcwZTcxXkEyXkFqcGc@._V1_.jpg" alt="Ninja Kaplumbağalar 2012" loading="lazy"><div class="co"><div class="ct">Ninja Kaplumbağalar 2012</div><div class="cm"><span>2021</span><span>•</span><span>Crime</span><span class="cr">★ 7.5</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,1089,'Ninja Kaplumbağalar 2012','https://m.media-amazon.com/images/M/MV5BZDNiZDk0M2ItNWM4Zi00YjQ0LWJjOGItMDFlMmQ2NTcwZTcxXkEyXkFqcGc@._V1_.jpg','/tmnt.html','2021','Crime','7.5')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="1089" onclick="toggleFav(this,1089,'Ninja Kaplumbağalar 2012','https://m.media-amazon.com/images/M/MV5BZDNiZDk0M2ItNWM4Zi00YjQ0LWJjOGItMDFlMmQ2NTcwZTcxXkEyXkFqcGc@._V1_.jpg','/tmnt.html','2021','Crime','7.5')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BOTg4MjU4YzYtNTIwYy00ODgyLTg3YTQtY2ViMGIzYWQwNTFiXkEyXkFqcGc@._V1_.jpg" alt="Vampirina 2026" loading="lazy"><div class="co"><div class="ct">Vampirina 2026</div><div class="cm"><span>2019</span><span>•</span><span>Comedy</span><span class="cr">★ 8.3</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,20,'Vampirina 2026','https://m.media-amazon.com/images/M/MV5BOTg4MjU4YzYtNTIwYy00ODgyLTg3YTQtY2ViMGIzYWQwNTFiXkEyXkFqcGc@._V1_.jpg','http://playcloudmovie0.ct.ws/player2.html','2019','Comedy','8.3')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="20" onclick="toggleFav(this,20,'Vampirina 2026','https://m.media-amazon.com/images/M/MV5BOTg4MjU4YzYtNTIwYy00ODgyLTg3YTQtY2ViMGIzYWQwNTFiXkEyXkFqcGc@._V1_.jpg','http://playcloudmovie0.ct.ws/player2.html','2019','Comedy','8.3')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BODcwOTg2MDE3NF5BMl5BanBnXkFtZTgwNTUyNTY1NjM@._V1_FMjpg_UX1000_.jpg" alt="DareDevil 2025" loading="lazy"><div class="co"><div class="ct">DareDevil 2025</div><div class="cm"><span>2019</span><span>•</span><span>Comedy</span><span class="cr">★ 8.3</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,20,'Vampirina 2026','https://m.media-amazon.com/images/M/MV5BOTg4MjU4YzYtNTIwYy00ODgyLTg3YTQtY2ViMGIzYWQwNTFiXkEyXkFqcGc@._V1_.jpg','https://playcloudmovie0.ct.ws/daredevil1.php?i=3','2019','Comedy','8.3')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="20" onclick="toggleFav(this,20,'Vampirina 2026','https://m.media-amazon.com/images/M/MV5BOTg4MjU4YzYtNTIwYy00ODgyLTg3YTQtY2ViMGIzYWQwNTFiXkEyXkFqcGc@._V1_.jpg','https://playcloudmovie0.ct.ws/daredevil1.php?i=3','2019','Comedy','8.3')">+</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- TAVSİYE EDİLENLER -->
<section class="sec" id="movies">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['movies_title']) ?></div><a class="see-all" href="#"><?= htmlspecialchars($t['see_all']) ?></a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BMWU1OGEwNmQtNGM3MS00YTYyLThmYmMtN2FjYzQzNzNmNTE0XkEyXkFqcGc@._V1_QL75_UX190_CR0,2,190,281_.jpg" alt="Demon Slayer" loading="lazy"><div class="co"><div class="ct">Demon Slayer</div><div class="cm"><span>2018</span><span>•</span><span>Horror</span><span class="cr">★ 6.6</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,21,'Demon Slayer','https://m.media-amazon.com/images/M/MV5BMWU1OGEwNmQtNGM3MS00YTYyLThmYmMtN2FjYzQzNzNmNTE0XkEyXkFqcGc@._V1_QL75_UX190_CR0,2,190,281_.jpg','/naruto.html','2018','Horror','6.6')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="21" onclick="toggleFav(this,21,'Demon Slayer','https://m.media-amazon.com/images/M/MV5BMWU1OGEwNmQtNGM3MS00YTYyLThmYmMtN2FjYzQzNzNmNTE0XkEyXkFqcGc@._V1_QL75_UX190_CR0,2,190,281_.jpg','/naruto.html','2018','Horror','6.6')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BY2QzODA5OTQtYWJlNi00ZjIzLThhNTItMDMwODhlYzYzMjA2XkEyXkFqcGc@._V1_.jpg" alt="Benim Kahraman Akademim" loading="lazy"><div class="co"><div class="ct">Benim Kahraman Akademim</div><div class="cm"><span>2018</span><span>•</span><span>Horror</span><span class="cr">★ 6.6</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,32,'Benim Kahraman Akademim','https://m.media-amazon.com/images/M/MV5BY2QzODA5OTQtYWJlNi00ZjIzLThhNTItMDMwODhlYzYzMjA2XkEyXkFqcGc@._V1_.jpg','/myhero.html','2018','Horror','6.6')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="32" onclick="toggleFav(this,32,'Benim Kahraman Akademim','https://m.media-amazon.com/images/M/MV5BY2QzODA5OTQtYWJlNi00ZjIzLThhNTItMDMwODhlYzYzMjA2XkEyXkFqcGc@._V1_.jpg','/myhero.html','2018','Horror','6.6')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BMzE0ZDU1MzQtNTNlYS00YjNlLWE2ODktZmFmNDYzMTBlZTBmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Pokemon" loading="lazy"><div class="co"><div class="ct">Pokemon</div><div class="cm"><span>2018</span><span>•</span><span>Horror</span><span class="cr">★ 6.6</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,33,'Pokemon','https://m.media-amazon.com/images/M/MV5BMzE0ZDU1MzQtNTNlYS00YjNlLWE2ODktZmFmNDYzMTBlZTBmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/pokemoon.html','2018','Horror','6.6')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="33" onclick="toggleFav(this,33,'Pokemon','https://m.media-amazon.com/images/M/MV5BMzE0ZDU1MzQtNTNlYS00YjNlLWE2ODktZmFmNDYzMTBlZTBmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/pokemoon.html','2018','Horror','6.6')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BYTgyMzA5MjEtNDY3Ny00ZDkyLWJhYzEtYzI2Nzk5Mzc3ZDk1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Dragon Ball Super" loading="lazy"><div class="co"><div class="ct">Dragon Ball Super</div><div class="cm"><span>2018</span><span>•</span><span>Horror</span><span class="cr">★ 6.6</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,34,'Dragon Ball Super','https://m.media-amazon.com/images/M/MV5BYTgyMzA5MjEtNDY3Ny00ZDkyLWJhYzEtYzI2Nzk5Mzc3ZDk1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/dragonball.html','2018','Horror','6.6')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="34" onclick="toggleFav(this,34,'Dragon Ball Super','https://m.media-amazon.com/images/M/MV5BYTgyMzA5MjEtNDY3Ny00ZDkyLWJhYzEtYzI2Nzk5Mzc3ZDk1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/dragonball.html','2018','Horror','6.6')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://upload.wikimedia.org/wikipedia/tr/4/43/Doctor_Who_Series_14.jpg" alt="Doctor Who" loading="lazy"><div class="co"><div class="ct">Doctor Who</div><div class="cm"><span>2019</span><span>•</span><span>Crime</span><span class="cr">★ 7.8</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,22,'Doctor Who','https://upload.wikimedia.org/wikipedia/tr/4/43/Doctor_Who_Series_14.jpg','https://playnetflixcloud.ct.ws/who.html','2019','Crime','7.8')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="22" onclick="toggleFav(this,22,'Doctor Who','https://upload.wikimedia.org/wikipedia/tr/4/43/Doctor_Who_Series_14.jpg','https://playnetflixcloud.ct.ws/who.html','2019','Crime','7.8')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BOWY1Y2ZlNzctMzIwMi00NTM3LWJiNDUtMTZmYWY0Y2NmZmE2XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Star Trek" loading="lazy"><div class="co"><div class="ct">Star Trek</div><div class="cm"><span>2019</span><span>•</span><span>Drama</span><span class="cr">★ 7.9</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,23,'Star Trek','https://m.media-amazon.com/images/M/MV5BOWY1Y2ZlNzctMzIwMi00NTM3LWJiNDUtMTZmYWY0Y2NmZmE2XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/startrekk.php','2019','Drama','7.9')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="23" onclick="toggleFav(this,23,'Star Trek','https://m.media-amazon.com/images/M/MV5BOWY1Y2ZlNzctMzIwMi00NTM3LWJiNDUtMTZmYWY0Y2NmZmE2XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/startrekk.php','2019','Drama','7.9')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BNjYxNDgxM2MtYzNmNi00ODYwLWI0ZmEtZDM3M2QwZGQ3MWI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Futurama" loading="lazy"><div class="co"><div class="ct">Futurama</div><div class="cm"><span>2019</span><span>•</span><span>Drama</span><span class="cr">★ 7.9</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,35,'Futurama','https://m.media-amazon.com/images/M/MV5BNjYxNDgxM2MtYzNmNi00ODYwLWI0ZmEtZDM3M2QwZGQ3MWI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/futurama.html','2019','Drama','7.9')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="35" onclick="toggleFav(this,35,'Futurama','https://m.media-amazon.com/images/M/MV5BNjYxNDgxM2MtYzNmNi00ODYwLWI0ZmEtZDM3M2QwZGQ3MWI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/futurama.html','2019','Drama','7.9')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BMDA3ZTY0MmQtMjc5YS00ODdkLWIxNDEtNjg4MTdmNGIzNjI4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Sonic Prime" loading="lazy"><div class="co"><div class="ct">Sonic Prime</div><div class="cm"><span>2019</span><span>•</span><span>Drama</span><span class="cr">★ 7.9</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,36,'Sonic Prime','https://m.media-amazon.com/images/M/MV5BMDA3ZTY0MmQtMjc5YS00ODdkLWIxNDEtNjg4MTdmNGIzNjI4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/sonicprime.html','2019','Drama','7.9')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="36" onclick="toggleFav(this,36,'Sonic Prime','https://m.media-amazon.com/images/M/MV5BMDA3ZTY0MmQtMjc5YS00ODdkLWIxNDEtNjg4MTdmNGIzNjI4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/sonicprime.html','2019','Drama','7.9')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BNDJlMGI1MDYtZDM0MS00NDYzLWIyMmUtZTY5MjY3MzJiN2QwXkEyXkFqcGc@._V1_.jpg" alt="Regular Show" loading="lazy"><div class="co"><div class="ct">Regular Show</div><div class="cm"><span>2018</span><span>•</span><span>Drama</span><span class="cr">★ 7.7</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,24,'Regular Show','https://m.media-amazon.com/images/M/MV5BNDJlMGI1MDYtZDM0MS00NDYzLWIyMmUtZTY5MjY3MzJiN2QwXkEyXkFqcGc@._V1_.jpg','/regularshow.html','2018','Drama','7.7')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="24" onclick="toggleFav(this,24,'Regular Show','https://m.media-amazon.com/images/M/MV5BNDJlMGI1MDYtZDM0MS00NDYzLWIyMmUtZTY5MjY3MzJiN2QwXkEyXkFqcGc@._V1_.jpg','/regularshow.html','2018','Drama','7.7')">+</button></div></div></div>
  <div class="mc focusable"><img src="https://m.media-amazon.com/images/M/MV5BZWQ1NGE4YjgtOGJjZS00OTZjLWI0MGUtMDUxYjY2M2E4MjNjXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg" alt="Bob Burgers" loading="lazy"><div class="co"><div class="ct">Bob Burgers</div><div class="cm"><span>2018</span><span>•</span><span>Drama</span><span class="cr">★ 7.7</span></div><div class="ca"><button class="cb cb-p" onclick="playContent(this,27,'Bob Burgers','https://m.media-amazon.com/images/M/MV5BZWQ1NGE4YjgtOGJjZS00OTZjLWI0MGUtMDUxYjY2M2E4MjNjXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/bobs.php','2018','Drama','7.7')">▶ <?= htmlspecialchars($t['watch']) ?></button><button class="cb cb-f" data-id="27" onclick="toggleFav(this,27,'Bob Burgers','https://m.media-amazon.com/images/M/MV5BZWQ1NGE4YjgtOGJjZS00OTZjLWI0MGUtMDUxYjY2M2E4MjNjXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/bobs.php','2018','Drama','7.7')">+</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- KOLEKSİYONLAR -->
<section class="sec">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['collections']) ?></div></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/06921a43bb9cadd695ac8f015f474755/LIVE%20TV.png" alt="Belgesel" loading="lazy"><div class="co"><div class="ct">Belgesel</div><div class="ca"><button class="cb cb-p" onclick="window.open('/livetv','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/6eea4d43f99883b58f6ccc1365b0d59a/LIVE%20TV%20%281%29.png" alt="Dizi" loading="lazy"><div class="co"><div class="ct">Dizi</div><div class="ca"><button class="cb cb-p" onclick="window.open('/livetv','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/4e69a92222a3fd7571604f6cf0c86eca/LIVE%20TV%20%282%29.png" alt="Çocuk" loading="lazy"><div class="co"><div class="ct">Çocuk</div><div class="ca"><button class="cb cb-p" onclick="window.open('/livetv','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/df7d32b61f3d688adbfe91bd4464dc62/NA%20%281%29.png" alt="FireSERIES HD" loading="lazy"><div class="co"><div class="ct">FireSERIES HD</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/teve.php','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- TV KANALLARI -->
<section class="sec">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['tv_channels']) ?></div></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/3c864b05720e1bfb474578fb2416a4c1/NA.png" alt="Belgesel TV" loading="lazy"><div class="co"><div class="ct">Belgesel TV</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/doc.php','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/b8de23432b002de52d7f92b75a3618c1/Ads%C4%B1z%20tasar%C4%B1m.png" alt="Central Comedy" loading="lazy"><div class="co"><div class="ct">North Comedy TV HD</div><div class="ca"><button class="cb cb-p" onclick="window.open('https://buy.stripe.com/test_5kQbJ0afq9d49KebbM7wA0x','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/57e304b470809081357c18300943b255/Ads%C4%B1z%20tasar%C4%B1m.png" alt="ÇocukTV" loading="lazy"><div class="co"><div class="ct">ÇocukTV</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/cocuk.php','_blank')">▶ <?= htmlspecialchars($t['watch']) ?></button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<div class="sec-div"></div>

<!-- LİSTEM -->
<section class="sec" id="favorites">
  <div class="sec-hdr"><div class="sec-title"><?= htmlspecialchars($t['mylist_title']) ?> <span class="badge"><?= htmlspecialchars($t['saved_badge']) ?></span></div></div>
  <div id="fav-sec">
    <div class="empty-fav"><div class="icon">🔒</div><h3><?= htmlspecialchars($t['login_required']) ?></h3><p><?= htmlspecialchars($t['login_msg']) ?></p></div>
  </div>
</section>

<!-- TAKVİM -->
<section class="sec cal-sec" id="calendar">
  <div class="cal-hdr">
    <div class="cal-title"><span>📅</span><?= htmlspecialchars($t['cal_title']) ?></div>
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
      <div class="caltabs">
        <button class="caltab active" onclick="calF('all',this)"><?= htmlspecialchars($t['all']) ?></button>
        <button class="caltab" onclick="calF('today',this)"><?= htmlspecialchars($t['today']) ?></button>
        <button class="caltab" onclick="calF('week',this)"><?= htmlspecialchars($t['this_week']) ?></button>
        <button class="caltab" onclick="calF('upcoming',this)"><?= htmlspecialchars($t['upcoming']) ?></button>
      </div>
      <div class="cmn">
        <button onclick="calPrev()">❮</button>
        <span class="cml" id="cml">Mart 2026</span>
        <button onclick="calNext()">❯</button>
      </div>
    </div>
  </div>
  <div class="ctw">
    <table class="ct2">
      <thead><tr>
        <th><?= htmlspecialchars($t['date_col']) ?></th>
        <th><?= htmlspecialchars($t['show_col']) ?></th>
        <th><?= htmlspecialchars($t['ep_col']) ?></th>
        <th><?= htmlspecialchars($t['plat_col']) ?></th>
      </tr></thead>
      <tbody id="cal-body"></tbody>
    </table>
  </div>
</section>

</main>

<button class="and-btn" id="andBtn" onclick="toggleTV()">
  <span>📺</span><span id="and-lbl"><?= htmlspecialchars($t['android_mode']) ?></span>
</button>

<!-- MOBİL BOTTOM NAV -->
<nav class="mob-nav" id="mobNav" aria-label="Ana Navigasyon">
  <div class="mob-nav-inner">
    <a href="#" class="mob-ni mob-active" id="mni-home" onclick="mobSetActive(this)" aria-label="<?= htmlspecialchars($t['home']) ?>">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V9.5z"/><polyline points="9 21 9 12 15 12 15 21"/></svg></div>
      <span class="mob-ni-lbl"><?= htmlspecialchars($t['home']) ?></span><div class="mob-ni-ripple"></div>
    </a>
    <a href="/gl.php" class="mob-ni" id="mni-shorts" onclick="mobSetActive(this)" aria-label="Shorts">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><polygon points="10 15.5 14 13 10 10.5 10 15.5" fill="currentColor" stroke="none"/></svg></div>
      <span class="mob-ni-lbl"><?= htmlspecialchars($t['shorts']) ?></span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#series" class="mob-ni" id="mni-series" onclick="mobSetActive(this)" aria-label="<?= htmlspecialchars($t['series']) ?>">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><line x1="7" y1="8" x2="7" y2="12"/><polygon points="10 8 16 10 10 12 10 8" fill="currentColor" stroke="none"/></svg></div>
      <span class="mob-ni-lbl"><?= htmlspecialchars($t['series']) ?></span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#movies" class="mob-ni" id="mni-movies" onclick="mobSetActive(this)" aria-label="<?= htmlspecialchars($t['movies']) ?>">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="7" y1="4" x2="7" y2="20"/><line x1="17" y1="4" x2="17" y2="20"/><line x1="2" y1="9" x2="22" y2="9"/><line x1="2" y1="15" x2="22" y2="15"/></svg></div>
      <span class="mob-ni-lbl"><?= htmlspecialchars($t['movies']) ?></span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#favorites" class="mob-ni" id="mni-fav" onclick="mobSetActive(this)" aria-label="<?= htmlspecialchars($t['mylist']) ?>">
      <div class="mob-ni-ico">
        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        <span class="mob-ni-badge" id="mob-fav-cnt" style="display:none">0</span>
      </div>
      <span class="mob-ni-lbl"><?= htmlspecialchars($t['mylist']) ?></span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#calendar" class="mob-ni" id="mni-cal" onclick="mobSetActive(this)" aria-label="<?= htmlspecialchars($t['calendar']) ?>">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
      <span class="mob-ni-lbl"><?= htmlspecialchars($t['calendar']) ?></span><div class="mob-ni-ripple"></div>
    </a>
  </div>
</nav>

</div><!-- /main-app -->
<div class="toast" id="toast"></div>

<script>
// ─── PHP → JS ─────────────────────────────────────────────────
const FAV_IDS = [];
const PHP_CONTINUE = [];
const HAS_DB = false;
const LANG = <?= json_encode($lang) ?>;
const THEME = <?= json_encode($theme) ?>;
const STR = {
  watch:        <?= json_encode($t['watch']) ?>,
  continue:     <?= json_encode($t['continue']) ?>,
  remove:       <?= json_encode($t['remove']) ?>,
  added_list:   <?= json_encode($t['added_list']) ?>,
  removed_list: <?= json_encode($t['removed_list']) ?>,
  watching:     <?= json_encode($t['watching']) ?>,
  error:        <?= json_encode($t['error']) ?>,
  tv_active:    <?= json_encode($t['tv_mode_active']) ?>,
  close_mode:   <?= json_encode($t['close_mode']) ?>,
  android_mode: <?= json_encode($t['android_mode']) ?>,
  cast_started: <?= json_encode($t['cast_started']) ?>,
  cast_stopped: <?= json_encode($t['cast_stopped']) ?>,
  cast_unavail: <?= json_encode($t['cast_unavail']) ?>,
  settings_saved:<?= json_encode($t['settings_saved']) ?>,
  season:       <?= json_encode($t['season']) ?>,
  episode_lbl:  <?= json_encode($t['episode_lbl']) ?>,
  no_ep:        <?= json_encode($t['no_ep']) ?>,
  clear_history:<?= json_encode($t['clear_history']) ?>,
  login_req:    <?= json_encode($t['login_required']) ?>,
  login_msg:    <?= json_encode($t['login_msg']) ?>,
  list_empty:   <?= json_encode($t['list_empty']) ?>,
  list_empty_msg:<?= json_encode($t['list_empty_msg']) ?>,
};
const TRM = <?= $monthsJson ?>;
const TRD = <?= $daysJson ?>;

const LS_FAV_KEY = 'wox_favs';
const LS_CW_KEY  = 'wox_cw';
function lsGet(key){try{return JSON.parse(localStorage.getItem(key)||'null');}catch(e){return null;}}
function lsSet(key,val){try{localStorage.setItem(key,JSON.stringify(val));}catch(e){}}

if(!HAS_DB){const lsFavs=lsGet(LS_FAV_KEY)||[];lsFavs.forEach(id=>FAV_IDS.push(String(id)));}

// ─── LOADING ─────────────────────────────────────────────────
window.addEventListener('load',()=>{
  setTimeout(()=>{
    document.getElementById('ls').classList.add('hide');
    const app=document.getElementById('main-app');
    if(app)setTimeout(()=>app.style.opacity='1',100);
    // localStorage'dan devam listesini yükle
    if(!HAS_DB){
      const lsCW=lsGet(LS_CW_KEY)||[];
      if(lsCW.length){lsCW.forEach(item=>cwAddCard(item.id,item.title,item.img,item.url,item.year,item.genre,item.rating,item.progress||5,true));}
    }
  },900);
});

// ─── SCROLL HEADER ───────────────────────────────────────────
window.addEventListener('scroll',()=>{document.getElementById('hdr')?.classList.toggle('scrolled',scrollY>40);},{passive:true});

// ─── SLIDER ──────────────────────────────────────────────────
function initSlider(c){
  const sl=c.querySelector('.sl');if(!sl)return;
  const lBtn=c.querySelector('.sl-arr.l'),rBtn=c.querySelector('.sl-arr.r');
  const isCW=c.closest('#continue-watching')!==null;
  const cW=isCW?210:(parseInt(getComputedStyle(document.documentElement).getPropertyValue('--card-w'))||170);
  const gap=parseInt(getComputedStyle(document.documentElement).getPropertyValue('--gap'))||10;
  const step=cW+gap;let pos=0;
  const vis=()=>Math.max(1,Math.floor(c.offsetWidth/step));
  const mx=()=>Math.max(0,(sl.querySelectorAll(isCW?'.cw-card':'.mc').length-vis())*step);
  if(rBtn)rBtn.onclick=()=>{pos=Math.min(pos+vis()*step,mx());sl.style.transform=`translateX(-${pos}px)`;};
  if(lBtn)lBtn.onclick=()=>{pos=Math.max(0,pos-vis()*step);sl.style.transform=`translateX(-${pos}px)`;};
  let tx=0;
  sl.addEventListener('touchstart',e=>{tx=e.touches[0].clientX;},{passive:true});
  sl.addEventListener('touchend',e=>{const d=tx-e.changedTouches[0].clientX;if(Math.abs(d)>40){pos=d>0?Math.min(pos+step*2,mx()):Math.max(0,pos-step*2);sl.style.transform=`translateX(-${pos}px)`;}},{passive:true});
}
document.querySelectorAll('.sl-c').forEach(initSlider);

// ─── TV'YE YANSIТ ────────────────────────────────────────────
let castSession = null;
const castBtn = document.getElementById('castBtn');

function toggleCast(){
  if(typeof cast === 'undefined' || !cast.framework){
    // Chromecast API yoksa — native share API dene
    if(navigator.share){
      navigator.share({title:'WOXPLUS',url:window.location.href}).catch(()=>{});
      showToast(STR.cast_started);
    } else {
      showToast(STR.cast_unavail);
    }
    return;
  }
  const ctx = cast.framework.CastContext.getInstance();
  if(castSession){
    ctx.endCurrentSession(true);
    castSession = null;
    castBtn.classList.remove('casting');
    showToast(STR.cast_stopped);
  } else {
    ctx.requestSession().then(()=>{
      castSession = ctx.getCurrentSession();
      castBtn.classList.add('casting');
      showToast(STR.cast_started);
    }).catch(()=>{showToast(STR.cast_unavail);});
  }
}
// Google Cast SDK yükle
(function(){
  const s=document.createElement('script');
  s.src='https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1';
  s.async=true;
  s.onload=()=>{
    if(window.__onGCastApiAvailable){window.__onGCastApiAvailable(true);}
  };
  document.head.appendChild(s);
})();
window['__onGCastApiAvailable']=function(isAvailable){
  if(isAvailable && cast && cast.framework){
    cast.framework.CastContext.getInstance().setOptions({
      receiverApplicationId: chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID,
      autoJoinPolicy: chrome.cast.AutoJoinPolicy.ORIGIN_SCOPED
    });
  }
};

// ─── AYARLAR ─────────────────────────────────────────────────
let pendingTheme = THEME;
let pendingLang  = LANG;

function openSettings(){document.getElementById('settingsOverlay').classList.add('open');}
function closeSettings(){document.getElementById('settingsOverlay').classList.remove('open');}

function selectOpt(btn,type){
  const group = btn.closest('.settings-opts');
  group.querySelectorAll('.settings-opt').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  if(type==='theme') pendingTheme=btn.dataset.val;
  if(type==='lang')  pendingLang=btn.dataset.val;
}

function saveSettings(){
  // Cookie'ye kaydet (1 yıl)
  const exp = new Date(Date.now()+365*24*3600*1000).toUTCString();
  document.cookie='wox_theme='+pendingTheme+';path=/;expires='+exp;
  document.cookie='wox_lang='+pendingLang+';path=/;expires='+exp;
  showToast(STR.settings_saved);
  closeSettings();
  setTimeout(()=>window.location.reload(),700);
}

// ESC ile kapat
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeSettings();});

// ─── İZLEMEYE DEVAM ET ───────────────────────────────────────
function cwPlay(e,mid,url){
  e.stopPropagation();
  window.open(url,'_blank');
  const card=document.querySelector(`.cw-card[data-cw-id="${mid}"]`);
  if(card){
    const bar=card.querySelector('.cw-prog-bar');
    const lbl=card.querySelector('.cw-prog-label');
    const newProg=Math.min(99,parseInt(bar.style.width||'5')+Math.floor(Math.random()*10+5));
    bar.style.width=newProg+'%';
    if(lbl)lbl.textContent=newProg+'%';
    let lsCW=lsGet(LS_CW_KEY)||[];
    const idx=lsCW.findIndex(x=>String(x.id)===String(mid));
    if(idx>-1){lsCW[idx].progress=newProg;lsSet(LS_CW_KEY,lsCW);}
  }
}
function cwRemove(e,mid){
  e.stopPropagation();
  const card=document.querySelector(`.cw-card[data-cw-id="${mid}"]`);
  if(card){
    card.style.transition='transform .3s, opacity .3s';
    card.style.transform='scale(.85) translateY(-8px)';
    card.style.opacity='0';
    setTimeout(()=>{
      card.remove();
      const remaining=document.querySelectorAll('.cw-card').length;
      document.getElementById('cw-badge').textContent=remaining;
      if(remaining===0)document.getElementById('continue-watching').style.display='none';
    },280);
    let lsCW2=lsGet(LS_CW_KEY)||[];
    lsCW2=lsCW2.filter(x=>String(x.id)!==String(mid));
    lsSet(LS_CW_KEY,lsCW2);
    if(!HAS_DB)return;
    const fd=new FormData();fd.append('action','remove_continue');fd.append('movie_id',mid);
    fetch('index.php',{method:'POST',body:fd}).catch(()=>{});
  }
}
function cwClearAll(e){
  e.preventDefault();
  const cards=document.querySelectorAll('.cw-card');
  if(!cards.length)return;
  if(!confirm(STR.clear_history))return;
  cards.forEach((c,i)=>{setTimeout(()=>{c.style.transition='transform .3s,opacity .3s';c.style.transform='scale(.8) translateY(-10px)';c.style.opacity='0';},i*50);});
  setTimeout(()=>{
    document.getElementById('continue-watching').style.display='none';
    lsSet(LS_CW_KEY,[]);
    cards.forEach(c=>{const mid=c.dataset.cwId;const fd=new FormData();fd.append('action','remove_continue');fd.append('movie_id',mid);fetch('index.php',{method:'POST',body:fd}).catch(()=>{});});
  },cards.length*50+300);
}
function cwAddCard(mid,title,img,url,year,genre,rating,progress,silent){
  const sec=document.getElementById('continue-watching');
  const sl=document.getElementById('cw-sl');
  const existing=sl.querySelector(`.cw-card[data-cw-id="${mid}"]`);
  if(existing)existing.remove();
  const card=document.createElement('div');
  card.className='cw-card';
  card.dataset.cwId=mid;
  card.innerHTML=`
    <img src="${img}" alt="${escHtml(title)}" loading="lazy" onerror="this.style.opacity='.3'">
    <div class="cw-prog-label">${progress}%</div>
    <button class="cw-rm-corner" onclick="cwRemove(event,'${mid}')" title="${STR.remove}">✕</button>
    <div class="cw-overlay">
      <div class="cw-title">${escHtml(title)}</div>
      <div class="cw-meta">${year} • ${genre} • ★ ${rating}</div>
      <div class="cw-actions">
        <button class="cw-btn-play" onclick="cwPlay(event,'${mid}','${escJs(url)}')">${STR.continue}</button>
        <button class="cw-btn-rm" onclick="cwRemove(event,'${mid}')" title="${STR.remove}">✕</button>
      </div>
    </div>
    <div class="cw-prog-wrap"><div class="cw-prog-bar" style="width:${progress}%"></div></div>`;
  sl.prepend(card);
  sec.style.display='';
  document.getElementById('cw-badge').textContent=sl.querySelectorAll('.cw-card').length;
  const slC=sec.querySelector('.sl-c');
  if(slC)initSlider(slC);
}
function playContent(btn,mid,title,img,url,year,genre,rating){
  const progress=Math.floor(Math.random()*20+5);
  cwAddCard(mid,title,img,url,year,genre,rating,progress,false);
  window.open(url,'_blank');
  showToast(STR.watching+title);
  let lsCW=lsGet(LS_CW_KEY)||[];
  lsCW=lsCW.filter(x=>String(x.id)!==String(mid));
  lsCW.unshift({id:mid,title,img,url,year,genre,rating,progress});
  if(lsCW.length>12)lsCW=lsCW.slice(0,12);
  lsSet(LS_CW_KEY,lsCW);
  if(!HAS_DB)return;
  const fd=new FormData();
  fd.append('action','add_continue');fd.append('movie_id',mid);fd.append('title',title);
  fd.append('img',img);fd.append('url',url);fd.append('year',year);
  fd.append('genre',genre);fd.append('rating',rating);fd.append('progress',progress);
  fetch('index.php',{method:'POST',body:fd}).catch(()=>{});
}

// ─── FAVORİ ──────────────────────────────────────────────────
const favIds=new Set(FAV_IDS.map(String));

async function toggleFav(btn,mid,title,img,url,year,genre,rating){
  const adding=!btn.classList.contains('active');
  if(!HAS_DB){
    let lsFavs=lsGet(LS_FAV_KEY)||[];
    if(adding){if(!lsFavs.includes(String(mid)))lsFavs.push(String(mid));}
    else{lsFavs=lsFavs.filter(x=>x!==String(mid));}
    lsSet(LS_FAV_KEY,lsFavs);
    _applyFavUI(btn,mid,adding,title,img,url,year,genre,rating);
    return;
  }
  const fd=new FormData();
  fd.append('action',adding?'add_fav':'remove_fav');
  fd.append('movie_id',mid);
  if(adding){fd.append('title',title);fd.append('img',img);fd.append('url',url);fd.append('year',year);fd.append('genre',genre);fd.append('rating',rating);}
  try{
    const r=await fetch('index.php',{method:'POST',body:fd});
    const d=await r.json();
    if(!d.ok){showToast('⚠ '+d.msg);return;}
    _applyFavUI(btn,mid,adding,title,img,url,year,genre,rating);
  }catch(e){showToast(STR.error);}
}
function _applyFavUI(btn,mid,adding,title,img,url,year,genre,rating){
  btn.classList.toggle('active',adding);
  btn.textContent=adding?'✓':'+';
  document.querySelectorAll(`.cb-f[data-id="${mid}"]`).forEach(b=>{b.classList.toggle('active',adding);b.textContent=adding?'✓':'+';});
  adding?favIds.add(String(mid)):favIds.delete(String(mid));
  const cnt=favIds.size;
  document.getElementById('fav-cnt').textContent=cnt;
  const mobBadge=document.getElementById('mob-fav-cnt');
  if(mobBadge){mobBadge.textContent=cnt;mobBadge.style.display=cnt>0?'flex':'none';}
  showToast(adding?STR.added_list:STR.removed_list);
  if(adding){
    const favSec=document.getElementById('fav-sec');
    let favSl=document.getElementById('fav-sl');
    if(!favSl){
      favSec.innerHTML=`<div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl" id="fav-sl"></div></div><button class="sl-arr r">❯</button></div>`;
      favSl=document.getElementById('fav-sl');
      initSlider(favSec.querySelector('.sl-c'));
    }
    const card=document.createElement('div');
    card.className='mc focusable';
    card.innerHTML=`<img src="${escHtml(img)}" alt="${escHtml(title)}" loading="lazy">
      <div class="co">
        <div class="ct">${escHtml(title)}</div>
        <div class="cm"><span>${escHtml(year)}</span><span>•</span><span>${escHtml(genre)}</span><span class="cr">★ ${escHtml(rating)}</span></div>
        <div class="ca">
          <button class="cb cb-p" onclick="playContent(this,${mid},'${escJs(title)}','${escJs(img)}','${escJs(url)}','${escJs(year)}','${escJs(genre)}','${escJs(rating)}')">${STR.watch}</button>
          <button class="cb cb-f active" data-id="${mid}" onclick="toggleFav(this,${mid},'${escJs(title)}','${escJs(img)}','${escJs(url)}','${escJs(year)}','${escJs(genre)}','${escJs(rating)}')">✓</button>
        </div>
      </div>`;
    favSl.prepend(card);
  } else {
    const card=document.querySelector(`#fav-sl .cb-f[data-id="${mid}"]`)?.closest('.mc');
    if(card){
      card.style.transition='transform .3s,opacity .3s';card.style.transform='scale(.85)';card.style.opacity='0';
      setTimeout(()=>{
        card.remove();
        if(!document.querySelector('#fav-sl .mc')){
          document.getElementById('fav-sec').innerHTML=`<div class="empty-fav"><div class="icon">📋</div><h3>${STR.list_empty}</h3><p>${STR.list_empty_msg}</p></div>`;
        }
      },280);
    }
  }
}

// ─── ÇIKIŞ ───────────────────────────────────────────────────
async function doLogout(){
  const fd=new FormData();fd.append('action','logout');
  try{await fetch('index.php',{method:'POST',body:fd});}catch(e){}
  window.location.href='auth.php';
}

// ─── TOAST ───────────────────────────────────────────────────
let tTmr;
function showToast(msg){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');clearTimeout(tTmr);tTmr=setTimeout(()=>t.classList.remove('show'),2800);}

// ─── YARDIMCI ────────────────────────────────────────────────
function escHtml(s){return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}
function escJs(s){return String(s).replace(/\\/g,'\\\\').replace(/'/g,"\\'");}

// ─── TAKVİM ──────────────────────────────────────────────────
const EPS=[
  {date:'2026-03-04',show:'Beavis Ve Butthead',img:'https://m.media-amazon.com/images/M/MV5BNzU3Mzk0ZTUtMmRkNS00MjI1LWEzNjYtNzI2MWJkN2JkNjc4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg',ep:'S01E06',s:1,e:6,plat:'Premium',isNew:true},
  {date:'2026-03-05',show:'Central Park',img:'https://m.media-amazon.com/images/M/MV5BZjc5ZDRmOTktMTdjMC00OTQyLTk4NDktN2Y3OWY0ZDNjZTc1XkEyXkFqcGc@._V1_.jpg',ep:'S01E02',s:1,e:2,plat:'Free',isNew:true},
  {date:'2026-03-06',show:'Steven Universe',img:'https://m.media-amazon.com/images/M/MV5BZGJjMmI3ZDMtZTgyNi00MTZhLWE2ZjAtN2Q4YTUyMTg4OGY1XkEyXkFqcGc@._V1_.jpg',ep:'S01E08',s:1,e:8,plat:'Free',isNew:false},
  {date:'2026-03-07',show:'Doctor Who',img:'https://upload.wikimedia.org/wikipedia/tr/4/43/Doctor_Who_Series_14.jpg',ep:'S01E02',s:1,e:2,plat:'Premium',isNew:true},
];
let calY=2026,calM=2,calFil='all';
function calF(f,btn){calFil=f;document.querySelectorAll('.caltab').forEach(t=>t.classList.remove('active'));btn.classList.add('active');renderCal();}
function calPrev(){calM--;if(calM<0){calM=11;calY--;}renderCal();}
function calNext(){calM++;if(calM>11){calM=0;calY++;}renderCal();}
function renderCal(){
  document.getElementById('cml').textContent=TRM[calM]+' '+calY;
  const today=new Date();today.setHours(0,0,0,0);
  const we=new Date(today);we.setDate(we.getDate()+7);
  let fl=EPS.filter(ep=>{
    const d=new Date(ep.date);
    if(calFil==='all')return d.getFullYear()===calY&&d.getMonth()===calM;
    if(calFil==='today')return d.getTime()===today.getTime();
    if(calFil==='week')return d>=today&&d<=we;
    if(calFil==='upcoming')return d>today;
    return true;
  }).sort((a,b)=>new Date(a.date)-new Date(b.date));
  const tb=document.getElementById('cal-body');
  if(!fl.length){tb.innerHTML=`<tr><td colspan="4" class="cale">${STR.no_ep}</td></tr>`;return;}
  tb.innerHTML=fl.map(ep=>{
    const d=new Date(ep.date);
    const iT=d.getTime()===today.getTime(),iP=d<today;
    return `<tr style="${iP?'opacity:.4;':''}">
      <td><div class="cdc${iT?' cdt':''}"><span class="cday">${String(d.getDate()).padStart(2,'0')} ${TRM[d.getMonth()].slice(0,3)}</span><span class="cwdy">${TRD[d.getDay()]}</span></div></td>
      <td><div class="csc"><img class="cal-poster" src="${ep.img}" loading="lazy" onerror="this.style.display='none'"><div><div class="csn">${ep.show}</div><div class="csm">${STR.season} ${ep.s} • ${STR.episode_lbl} ${ep.e}</div></div></div></td>
      <td><span class="ceb${ep.isNew?' new':''}">${ep.isNew?'🆕 ':''}${ep.ep}</span></td>
      <td class="cpf"><span>${ep.plat}</span></td></tr>`;
  }).join('');
}
renderCal();

// ─── MOBİL BOTTOM NAV ────────────────────────────────────────
function mobSetActive(el){document.querySelectorAll('.mob-ni').forEach(n=>n.classList.remove('mob-active'));el.classList.add('mob-active');}
(function(){
  const sections=[
    {el:null,mni:'mni-home'},
    {el:document.getElementById('series'),mni:'mni-series'},
    {el:document.getElementById('movies'),mni:'mni-movies'},
    {el:document.getElementById('favorites'),mni:'mni-fav'},
    {el:document.getElementById('calendar'),mni:'mni-cal'},
  ];
  window.addEventListener('scroll',()=>{
    let active='mni-home';
    sections.forEach(s=>{if(!s.el)return;if(s.el.getBoundingClientRect().top<=120)active=s.mni;});
    document.querySelectorAll('.mob-ni').forEach(n=>n.classList.remove('mob-active'));
    document.getElementById(active)?.classList.add('mob-active');
  },{passive:true});
})();

// ─── ANDROID TV ──────────────────────────────────────────────
let tvMode=false,tvNavOpen=false,tvRows=[],tvCur={zone:'cards',ni:0,ri:0,ci:0};
const andBtn=document.getElementById('andBtn');
const tvTog=document.getElementById('tvTog');
const tvNIs=Array.from(document.querySelectorAll('.tv-ni'));
tvTog?.addEventListener('click',()=>{tvNavOpen=!tvNavOpen;document.body.classList.toggle('tv-nav-open',tvNavOpen);});
function toggleTV(){
  tvMode=!tvMode;
  document.body.classList.toggle('android-tv',tvMode);
  andBtn?.classList.toggle('active',tvMode);
  if(andBtn)andBtn.querySelector('#and-lbl').textContent=tvMode?STR.close_mode:STR.android_mode;
  if(tvMode){rbRows();tvCur={zone:'cards',ni:0,ri:0,ci:0};setFoc();showToast(STR.tv_active);}else{clrFoc();}
}
function rbRows(){tvRows=[];document.querySelectorAll('.sec:not([style*="display:none"]) .sl-c').forEach(slc=>{const cs=Array.from(slc.querySelectorAll('.mc.focusable,.cw-card'));if(cs.length)tvRows.push({sec:slc,cs});});}
function clrFoc(){document.querySelectorAll('.tv-focused').forEach(e=>e.classList.remove('tv-focused'));}
function setFoc(){
  clrFoc();
  if(tvCur.zone==='nav'){tvNIs[tvCur.ni]?.classList.add('tv-focused');return;}
  const row=tvRows[tvCur.ri];if(!row)return;
  tvCur.ci=Math.min(tvCur.ci,row.cs.length-1);
  row.cs[tvCur.ci]?.classList.add('tv-focused');
  row.cs[tvCur.ci]?.scrollIntoView({behavior:'smooth',block:'nearest',inline:'center'});
}
document.addEventListener('keydown',e=>{
  if(!tvMode)return;
  const m={ArrowRight:'r',ArrowLeft:'l',ArrowDown:'d',ArrowUp:'u',Enter:'e',' ':'e',Backspace:'b',Escape:'b'};
  const dir=m[e.key];if(!dir)return;e.preventDefault();
  const r=tvRows[tvCur.ri];
  if(tvCur.zone==='nav'){
    if(dir==='u')tvCur.ni=Math.max(0,tvCur.ni-1);
    else if(dir==='d')tvCur.ni=Math.min(tvNIs.length-1,tvCur.ni+1);
    else if(dir==='r'||dir==='b')tvCur.zone='cards';
    else if(dir==='e')tvNIs[tvCur.ni]?.click();
    setFoc();return;
  }
  if(dir==='r'&&tvCur.ci<(r?.cs.length??1)-1)tvCur.ci++;
  else if(dir==='l'&&tvCur.ci>0)tvCur.ci--;
  else if(dir==='l')tvCur.zone='nav';
  else if(dir==='d'&&tvCur.ri<tvRows.length-1){tvCur.ri++;tvCur.ci=Math.min(tvCur.ci,(tvRows[tvCur.ri]?.cs.length??1)-1);}
  else if(dir==='u'&&tvCur.ri>0){tvCur.ri--;tvCur.ci=Math.min(tvCur.ci,(tvRows[tvCur.ri]?.cs.length??1)-1);}
  else if(dir==='e'){tvRows[tvCur.ri]?.cs[tvCur.ci]?.querySelector('.cw-btn-play,.cb-p')?.click();}
  else if(dir==='b')tvCur.zone='nav';
  setFoc();
});
</script>
</body>
</html>
