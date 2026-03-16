<?php
// ─── SESSION & AUTH ──────────────────────────────────────────
session_start();

// Kullanıcı bilgileri (DB entegrasyonu için hazır)
$HAS_DB    = false;
$USER_NAME = $_SESSION['username'] ?? 'Misafir';
$USER_AVA  = $_SESSION['avatar']   ?? 'https://api.dicebear.com/7.x/fun-emoji/svg?seed=kids';
$FAV_IDS   = []; // DB'den çekilir
$PHP_CONTINUE = []; // DB'den çekilir

// AJAX handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'logout') {
        session_destroy();
        echo json_encode(['ok' => true]);
        exit;
    }
    echo json_encode(['ok' => true]);
    exit;
}

// Settings cookie
$THEME = $_COOKIE['wox_theme'] ?? 'dark';
$LANG  = $_COOKIE['wox_lang']  ?? 'tr';

$STR = [
    'watch'        => '▶ İzle',
    'continue'     => '▶ Devam Et',
    'remove'       => 'Kaldır',
    'added_list'   => '✓ Listene eklendi! 🌟',
    'removed_list' => '✕ Listeden çıkarıldı',
    'watching'     => '▶ İzleniyor: ',
    'error'        => '⚠ Hata oluştu.',
    'tv_active'    => '📺 Android Modu Aktif',
    'close_mode'   => 'Kapat',
    'android_mode' => 'Android Modu',
    'cast_started' => '📺 TV\'ye yansıtılıyor...',
    'cast_stopped' => '📺 Yansıtma durduruldu',
    'cast_unavail' => '⚠ Cast kullanılamıyor.',
    'settings_saved'=> '✓ Ayarlar kaydedildi!',
    'season'       => 'Sezon',
    'episode_lbl'  => 'Bölüm',
    'no_ep'        => '🎪 Bu dönemde planlanmış bölüm yok.',
    'clear_history'=> 'Tüm izleme geçmişi silinsin mi?',
    'login_req'    => 'Giriş Yapın',
    'login_msg'    => 'Listem özelliğini kullanmak için giriş yapmalısınız.',
    'list_empty'   => 'Listeni Doldur!',
    'list_empty_msg'=> 'Sevdiğin içeriklerin + butonuna bas!',
];

function jStr($s){ return addslashes($s); }
function esc($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

$theme_class = ($THEME === 'light') ? 'light-theme' : '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<link rel="manifest" href="manifest.json">
<script>
if('serviceWorker' in navigator){window.addEventListener('load',function(){navigator.serviceWorker.register('sw.js').then(r=>console.log('SW:',r.scope),e=>console.log('SW err:',e));});}
</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>WOXPLUS Kids - Çocuklar için En İyi İçerikler!</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800;900&family=Baloo+2:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
html{scroll-behavior:smooth;}

/* ══════════════════════════════════════════════
   FLOATING SHAPES ANIMATIONS
══════════════════════════════════════════════ */
@keyframes float1{0%,100%{transform:translate(0,0) rotate(0deg);}33%{transform:translate(-20px,15px) rotate(8deg);}66%{transform:translate(15px,-10px) rotate(-5deg);}}
@keyframes float2{0%,100%{transform:translate(0,0) rotate(0deg);}40%{transform:translate(20px,20px) rotate(-12deg);}75%{transform:translate(-15px,-18px) rotate(6deg);}}
@keyframes float3{0%,100%{transform:translateY(0) scale(1);}50%{transform:translateY(-18px) scale(1.06);}}
@keyframes wiggle{0%,100%{transform:rotate(-3deg);}50%{transform:rotate(3deg);}}
@keyframes bounce-in{0%{transform:scale(0) rotate(-15deg);opacity:0;}60%{transform:scale(1.15) rotate(3deg);}80%{transform:scale(0.93);}100%{transform:scale(1) rotate(0);opacity:1;}}
@keyframes sparkle{0%,100%{transform:scale(0) rotate(0);opacity:0;}50%{transform:scale(1.2) rotate(180deg);opacity:1;}}
@keyframes rainbow-txt{0%{color:#ff6b6b;}14%{color:#ffa94d;}28%{color:#ffd43b;}42%{color:#69db7c;}57%{color:#4dabf7;}71%{color:#748ffc;}85%{color:#da77f2;}100%{color:#ff6b6b;}}
@keyframes spin-slow{from{transform:rotate(0)}to{transform:rotate(360deg)}}
@keyframes pop{0%,100%{transform:scale(1);}50%{transform:scale(1.12);}}
@keyframes star-fall{0%{transform:translateY(-100px) rotate(0);opacity:0;}10%{opacity:1;}100%{transform:translateY(110vh) rotate(720deg);opacity:0;}}
@keyframes slide-up{from{transform:translateY(30px);opacity:0;}to{transform:translateY(0);opacity:1;}}
@keyframes pulse-glow{0%,100%{box-shadow:0 0 0 0 rgba(255,180,50,0.4);}50%{box-shadow:0 0 0 12px rgba(255,180,50,0);}}
@keyframes ldbar{0%{background-position:200% 0;}100%{background-position:-200% 0;}}
@keyframes pulseLogo{0%,100%{transform:scale(1) rotate(-2deg);}50%{transform:scale(1.06) rotate(2deg);}}
@keyframes meshA{0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(-30px,20px) scale(1.05);}66%{transform:translate(20px,-15px) scale(0.97);}}
@keyframes cwFadeIn{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}

/* ══════════════════════════════════════════════
   CSS VARIABLES — DARK (DEFAULT)
══════════════════════════════════════════════ */
:root{
  /* Kids palette */
  --k-yellow:#FFD43B;
  --k-orange:#FF922B;
  --k-pink:#F06595;
  --k-purple:#845EF7;
  --k-blue:#339AF0;
  --k-teal:#20C997;
  --k-green:#51CF66;
  --k-red:#FF6B6B;

  /* Dark theme */
  --bg:#0D0A1A;
  --bg-card:#1A1530;
  --bg-card-2:#211D3A;
  --bg-header:rgba(13,10,26,0.97);
  --txt:#F8F0FF;
  --txt-2:#B8A9D9;
  --txt-3:#5E4F8A;
  --silver:#D0C4F0;
  --border:rgba(132,94,247,0.18);
  --border-bright:rgba(132,94,247,0.35);
  --accent:var(--k-yellow);
  --accent-dim:rgba(255,212,59,0.08);
  --accent-border:rgba(255,212,59,0.25);
  --sh-card:0 6px 28px rgba(0,0,0,0.65);
  --sh-hover:0 18px 52px rgba(0,0,0,0.8),0 0 0 2px rgba(132,94,247,0.3);
  --r:14px;
  --r-sm:8px;
  --gap:12px;
  --card-w:172px;
  --card-h:258px;
  --hdr:64px;
  --ease:cubic-bezier(.4,0,.2,1);
  --tv-nav-w:0px;
  --tv-nav-expanded:200px;
  --mob-nav-h:66px;
  --modal-bg:rgba(18,14,36,0.98);
  --modal-border:rgba(132,94,247,0.3);
  --co-gradient:linear-gradient(to top,rgba(13,10,26,0.98) 0%,rgba(13,10,26,0.7) 40%,transparent 68%);
  --hero-grad:linear-gradient(to bottom,rgba(13,10,26,0.05) 0%,rgba(13,10,26,0.65) 55%,var(--bg) 100%),linear-gradient(to right,rgba(13,10,26,0.92) 0%,rgba(13,10,26,0.45) 52%,transparent 100%);
  --noise-op:0.03;
  --bg-bubbles:rgba(255,212,59,0.04),rgba(132,94,247,0.05);
}

/* ══════════════════════════════════════════════
   LIGHT THEME
══════════════════════════════════════════════ */
body.light-theme{
  --bg:#FFF8E7;
  --bg-card:#FFFFFF;
  --bg-card-2:#FFF0F5;
  --bg-header:rgba(255,248,231,0.98);
  --txt:#1A0A30;
  --txt-2:#5A3E7A;
  --txt-3:#A090C0;
  --silver:#4A2E7A;
  --border:rgba(132,94,247,0.2);
  --border-bright:rgba(132,94,247,0.4);
  --sh-card:0 6px 28px rgba(100,60,200,0.12);
  --sh-hover:0 18px 52px rgba(100,60,200,0.2),0 0 0 2px rgba(132,94,247,0.25);
  --modal-bg:rgba(255,250,240,0.99);
  --co-gradient:linear-gradient(to top,rgba(255,248,231,0.98) 0%,rgba(255,248,231,0.75) 42%,transparent 68%);
  --hero-grad:linear-gradient(to bottom,rgba(255,248,231,0.05) 0%,rgba(255,248,231,0.65) 55%,var(--bg) 100%),linear-gradient(to right,rgba(255,248,231,0.92) 0%,rgba(255,248,231,0.45) 52%,transparent 100%);
  --noise-op:0.008;
  --accent-dim:rgba(255,212,59,0.12);
}
body.light-theme .ls{background:var(--bg);}
body.light-theme .mc img{filter:none!important;}
body.light-theme .mc:hover img,.mc.tv-focused img{filter:brightness(.4)!important;}
body.light-theme .cw-card img{filter:none!important;}
body.light-theme .cw-card:hover img{filter:brightness(.4)!important;}
body.light-theme .tv-sidenav{background:rgba(255,248,231,0.99);}
body.light-theme .ad-bar{background:rgba(255,240,200,0.9);}
body.light-theme .btn-lo:hover{background:rgba(255,80,80,.1);border-color:rgba(255,80,80,.3);color:#cc2020;}

/* ══════════════════════════════════════════════
   BASE
══════════════════════════════════════════════ */
body{
  background:var(--bg);
  color:var(--txt);
  font-family:'Nunito',system-ui,sans-serif;
  overflow-x:hidden;
  min-height:100vh;
  -webkit-font-smoothing:antialiased;
  transition:padding-left .35s var(--ease),background .3s,color .3s;
  position:relative;
  cursor:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24'%3E%3Ctext y='20' font-size='20'%3E⭐%3C/text%3E%3C/svg%3E") 12 12, auto;
}

/* Floating background bubbles */
body::before{
  content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
  background:
    radial-gradient(ellipse 70% 50% at 10% 15%,rgba(132,94,247,0.12) 0%,transparent 55%),
    radial-gradient(ellipse 50% 40% at 85% 80%,rgba(255,148,59,0.09) 0%,transparent 55%),
    radial-gradient(ellipse 60% 45% at 50% 50%,rgba(255,212,59,0.06) 0%,transparent 65%);
  animation:meshA 20s ease-in-out infinite;
}
body::after{
  content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
  background:
    radial-gradient(ellipse 45% 35% at 90% 15%,rgba(51,154,240,0.08) 0%,transparent 55%),
    radial-gradient(ellipse 40% 50% at 5% 85%,rgba(240,101,149,0.07) 0%,transparent 55%);
}

/* Floating decorative shapes */
.deco-shapes{position:fixed;inset:0;z-index:1;pointer-events:none;overflow:hidden;}
.deco-shape{position:absolute;opacity:0.18;font-size:2rem;}
.deco-shape:nth-child(1){top:8%;left:3%;animation:float1 12s ease-in-out infinite;}
.deco-shape:nth-child(2){top:15%;right:4%;animation:float2 15s ease-in-out infinite;}
.deco-shape:nth-child(3){top:40%;left:1%;animation:float3 10s ease-in-out infinite;}
.deco-shape:nth-child(4){top:60%;right:2%;animation:float1 14s ease-in-out infinite 2s;}
.deco-shape:nth-child(5){bottom:20%;left:5%;animation:float3 11s ease-in-out infinite 1s;}
.deco-shape:nth-child(6){bottom:30%;right:5%;animation:float2 13s ease-in-out infinite 3s;}
.deco-shape:nth-child(7){top:75%;left:48%;animation:float1 16s ease-in-out infinite 0.5s;}

.noise-overlay{
  position:fixed;inset:0;z-index:1;pointer-events:none;
  opacity:var(--noise-op);
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size:200px;
}

main,header,section,nav,.hero,footer,.deco-shapes{position:relative;z-index:2;}

/* ══════════════════════════════════════════════
   LOADING SCREEN
══════════════════════════════════════════════ */
.ls{
  position:fixed;inset:0;background:var(--bg);z-index:9999;
  display:flex;flex-direction:column;align-items:center;justify-content:center;gap:20px;
  transition:opacity .5s;
}
.ls.hide{opacity:0;pointer-events:none;}
.ls-logo{animation:pulseLogo 1.6s ease-in-out infinite;}
.ls-logo img{width:110px;height:auto;object-fit:contain;filter:drop-shadow(0 0 20px rgba(255,212,59,0.5));}
.ls-emojis{display:flex;gap:16px;font-size:1.6rem;}
.ls-emojis span{animation:bounce-in .5s var(--ease) both;}
.ls-emojis span:nth-child(1){animation-delay:.05s;}
.ls-emojis span:nth-child(2){animation-delay:.15s;}
.ls-emojis span:nth-child(3){animation-delay:.25s;}
.ls-emojis span:nth-child(4){animation-delay:.35s;}
.ls-emojis span:nth-child(5){animation-delay:.45s;}
.ls-bar{width:200px;height:5px;background:rgba(132,94,247,0.15);border-radius:10px;overflow:hidden;}
.ls-fill{height:100%;background:linear-gradient(90deg,var(--k-purple),var(--k-pink),var(--k-yellow),var(--k-blue));background-size:300% 100%;animation:ldbar 1.2s ease-in-out infinite;border-radius:10px;}
.ls-txt{font-size:.75rem;color:var(--txt-3);font-weight:800;letter-spacing:.15em;text-transform:uppercase;font-family:'Fredoka',sans-serif;}

/* ══════════════════════════════════════════════
   STAR PARTICLES
══════════════════════════════════════════════ */
.star-particle{
  position:fixed;z-index:0;pointer-events:none;font-size:1.2rem;
  animation:star-fall linear both;
}

/* ══════════════════════════════════════════════
   TV SIDENAV
══════════════════════════════════════════════ */
body.android-tv{padding-left:var(--tv-nav-w);}
body.android-tv.tv-nav-open{padding-left:var(--tv-nav-expanded);}
.tv-sidenav{
  position:fixed;top:0;left:0;bottom:0;width:60px;
  background:rgba(13,10,26,0.99);
  border-right:2px solid var(--border);
  z-index:190;display:none;flex-direction:column;align-items:center;
  padding-top:calc(var(--hdr) + 16px);overflow:hidden;
  transition:width .35s var(--ease),box-shadow .35s;
  box-shadow:4px 0 40px rgba(0,0,0,.8);
  backdrop-filter:blur(20px);
}
body.android-tv .tv-sidenav{display:flex;}
body.android-tv.tv-nav-open .tv-sidenav{width:var(--tv-nav-expanded);}
.tv-si{display:flex;flex-direction:column;width:100%;padding:0 8px;}
.tv-ni{
  display:flex;align-items:center;gap:12px;padding:12px 10px;
  border-radius:12px;cursor:pointer;white-space:nowrap;
  color:var(--txt-2);text-decoration:none;font-size:.8rem;font-weight:700;
  transition:.2s;width:100%;border:1px solid transparent;margin-bottom:4px;overflow:hidden;
  font-family:'Fredoka',sans-serif;
}
.tv-ni .icon{font-size:1.2rem;flex-shrink:0;width:28px;text-align:center;}
.tv-ni .lbl{opacity:0;transition:opacity .25s;pointer-events:none;}
body.android-tv.tv-nav-open .tv-ni .lbl{opacity:1;}
.tv-ni:hover,.tv-ni.tv-focused{background:var(--accent-dim);border-color:var(--accent-border);color:var(--k-yellow);}
.tv-ni.active-nav{color:var(--k-yellow);}
.tv-toggle{
  margin-top:auto;margin-bottom:24px;width:36px;height:36px;border-radius:50%;
  background:rgba(132,94,247,0.1);border:1px solid var(--border);
  color:var(--txt-2);cursor:pointer;display:flex;align-items:center;justify-content:center;
  transition:.3s;font-size:.8rem;
}
.tv-toggle:hover{background:var(--accent-dim);color:var(--k-yellow);}
body.android-tv.tv-nav-open .tv-toggle{transform:rotate(180deg);}
body.android-tv .focusable.tv-focused{
  outline:3px solid rgba(255,212,59,0.7);outline-offset:3px;
  transform:scale(1.08) translateY(-4px)!important;z-index:30!important;
  box-shadow:0 0 0 3px rgba(255,212,59,.2),var(--sh-hover)!important;
}
.tv-ind{
  display:none;position:fixed;top:calc(var(--hdr)+10px);right:16px;z-index:500;
  background:rgba(132,94,247,0.15);border:2px solid var(--border-bright);
  color:var(--k-yellow);padding:4px 14px;border-radius:20px;
  font-size:.65rem;font-weight:800;letter-spacing:1.5px;text-transform:uppercase;
  font-family:'Fredoka',sans-serif;
}
body.android-tv .tv-ind{display:block;}

/* ══════════════════════════════════════════════
   HEADER
══════════════════════════════════════════════ */
header{
  position:fixed;top:0;left:0;right:0;z-index:200;height:var(--hdr);
  background:linear-gradient(180deg,rgba(13,10,26,0.98) 0%,transparent 100%);
  display:flex;align-items:center;justify-content:space-between;
  padding:0 24px;
  transition:background .3s,border-color .3s,left .35s;
  border-bottom:1px solid transparent;
}
body.light-theme header{background:linear-gradient(180deg,rgba(255,248,231,0.98) 0%,transparent 100%);}
body.android-tv header{left:60px;}
body.android-tv.tv-nav-open header{left:var(--tv-nav-expanded);}
header.scrolled{
  background:var(--bg-header);
  border-bottom-color:var(--border);
  backdrop-filter:blur(24px) saturate(1.5);
}

/* Logo */
.logo{display:flex;align-items:center;height:44px;text-decoration:none;flex-shrink:0;gap:6px;}
.logo img{height:36px;width:auto;object-fit:contain;filter:drop-shadow(0 2px 8px rgba(255,212,59,0.4));transition:.2s;}
.logo:hover img{transform:scale(1.05) rotate(-3deg);}
.logo-kids-badge{
  font-family:'Fredoka',sans-serif;font-size:.75rem;font-weight:700;
  background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;padding:2px 9px;border-radius:20px;letter-spacing:.04em;
  animation:pop 2s ease-in-out infinite;
}

/* Nav */
nav.mnav{display:flex;gap:2px;align-items:center;overflow-x:auto;scrollbar-width:none;flex:1;justify-content:center;padding:0 12px;}
nav.mnav::-webkit-scrollbar{display:none;}
nav.mnav a{
  color:var(--txt-3);text-decoration:none;font-size:.78rem;font-weight:800;
  padding:6px 12px;border-radius:20px;white-space:nowrap;transition:.2s;
  letter-spacing:.02em;font-family:'Fredoka',sans-serif;display:flex;align-items:center;gap:4px;
}
nav.mnav a:hover{color:var(--k-yellow);background:rgba(255,212,59,0.08);}
nav.mnav a.active{color:var(--txt);background:rgba(132,94,247,0.12);}

/* Header right */
.hdr-r{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.upbadge{
  display:flex;align-items:center;gap:7px;cursor:pointer;
  padding:4px 12px 4px 4px;border-radius:30px;
  background:rgba(132,94,247,0.08);border:1.5px solid var(--border);
  transition:.2s;
}
.upbadge:hover{background:rgba(132,94,247,0.14);border-color:var(--border-bright);transform:scale(1.03);}
.uav{width:28px;height:28px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,212,59,0.5);}
.uname{font-size:.75rem;font-weight:800;color:var(--txt);max-width:80px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-family:'Fredoka',sans-serif;}
.btn-lo{
  background:transparent;border:1.5px solid var(--border);color:var(--txt-3);
  font-family:'Fredoka',sans-serif;font-size:.72rem;font-weight:700;
  padding:5px 12px;border-radius:20px;cursor:pointer;transition:.2s;
}
.btn-lo:hover{background:rgba(255,80,80,.1);border-color:rgba(255,80,80,.3);color:var(--k-red);}
.fav-btn{
  position:relative;background:rgba(240,101,149,0.1);border:1.5px solid rgba(240,101,149,0.25);
  color:var(--k-pink);cursor:pointer;font-size:1rem;padding:6px 10px;
  border-radius:12px;transition:.25s;line-height:1;
}
.fav-btn:hover{background:rgba(240,101,149,0.2);transform:scale(1.1) rotate(-5deg);animation:pulse-glow .6s;}
.fav-cnt{
  position:absolute;top:-7px;right:-7px;
  background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;border-radius:50%;width:18px;height:18px;
  font-size:9px;font-weight:900;display:flex;align-items:center;justify-content:center;
  font-family:'Fredoka',sans-serif;border:1.5px solid var(--bg);
}

/* Cast & Settings */
.cast-btn,.settings-btn{
  background:rgba(132,94,247,0.08);border:1.5px solid var(--border);
  color:var(--txt-2);cursor:pointer;font-size:.75rem;font-weight:800;
  padding:6px 12px;border-radius:12px;transition:.2s;line-height:1;
  display:flex;align-items:center;gap:5px;
  font-family:'Fredoka',sans-serif;letter-spacing:.03em;white-space:nowrap;
}
.cast-btn:hover,.settings-btn:hover{
  background:rgba(132,94,247,0.15);border-color:var(--border-bright);color:var(--k-purple);
  transform:translateY(-1px);
}
.cast-btn.casting{border-color:rgba(51,154,240,0.4);color:var(--k-blue);background:rgba(51,154,240,0.08);}
@media(max-width:599px){.cast-btn span.cast-lbl,.settings-btn span.settings-lbl{display:none;}}

/* ══════════════════════════════════════════════
   SETTINGS MODAL
══════════════════════════════════════════════ */
.settings-overlay{
  position:fixed;inset:0;z-index:8000;
  background:rgba(0,0,0,0.65);backdrop-filter:blur(12px);
  display:flex;align-items:center;justify-content:center;
  opacity:0;pointer-events:none;transition:opacity .3s;
}
.settings-overlay.open{opacity:1;pointer-events:all;}
.settings-modal{
  background:var(--modal-bg);border:2px solid var(--modal-border);
  border-radius:24px;padding:28px;width:min(400px,92vw);
  box-shadow:0 24px 80px rgba(0,0,0,0.7),0 0 0 1px rgba(255,212,59,0.06);
  transform:scale(.9) translateY(24px);transition:transform .35s var(--ease),opacity .35s;opacity:0;
}
.settings-overlay.open .settings-modal{transform:scale(1) translateY(0);opacity:1;}
.settings-modal-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;}
.settings-modal-title{font-size:1rem;font-weight:800;color:var(--txt);font-family:'Fredoka',sans-serif;display:flex;align-items:center;gap:8px;}
.settings-close{background:rgba(132,94,247,0.1);border:1px solid var(--border);color:var(--txt-3);font-size:1rem;cursor:pointer;padding:4px 10px;border-radius:8px;transition:.2s;line-height:1;}
.settings-close:hover{background:rgba(255,80,80,0.12);color:var(--k-red);}
.settings-group{margin-bottom:20px;}
.settings-label{font-size:.7rem;font-weight:900;letter-spacing:.1em;text-transform:uppercase;color:var(--txt-3);font-family:'Fredoka',sans-serif;margin-bottom:10px;display:block;}
.settings-opts{display:flex;gap:8px;flex-wrap:wrap;}
.settings-opt{
  padding:9px 18px;border-radius:20px;border:1.5px solid var(--border);
  background:rgba(132,94,247,0.06);color:var(--txt-2);
  font-size:.78rem;font-weight:800;cursor:pointer;transition:.2s;
  font-family:'Fredoka',sans-serif;
}
.settings-opt:hover{border-color:var(--border-bright);color:var(--txt);}
.settings-opt.active{
  background:linear-gradient(135deg,var(--k-purple),var(--k-pink));
  color:#fff;border-color:transparent;
  box-shadow:0 4px 16px rgba(132,94,247,0.3);
}
.settings-save{
  width:100%;padding:12px;
  background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;border:none;border-radius:14px;
  font-size:.85rem;font-weight:900;cursor:pointer;
  font-family:'Fredoka',sans-serif;letter-spacing:.06em;
  transition:.2s;margin-top:8px;text-transform:uppercase;
  box-shadow:0 4px 16px rgba(255,180,50,0.3);
}
.settings-save:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(255,180,50,0.4);}

/* ══════════════════════════════════════════════
   HERO
══════════════════════════════════════════════ */
.hero{
  margin-top:var(--hdr);
  min-height:58vw;max-height:640px;
  background:var(--hero-grad),url('https://m.media-amazon.com/images/S/pv-target-images/3d947e119f92dfafdfcbd10bc3e74a980594e858fa2a68796b6898d94f1072d6.jpg') center/cover no-repeat;
  display:flex;align-items:flex-end;padding:0 24px 48px;
  position:relative;overflow:hidden;
}
.hero::before{
  content:'';position:absolute;inset:0;
  background:radial-gradient(ellipse 70% 60% at 0% 50%,rgba(13,10,26,0.6) 0%,transparent 70%);
  pointer-events:none;
}
/* Decorative star overlay on hero */
.hero::after{
  content:'✨ 🌟 ⭐ 💫';
  position:absolute;top:20px;right:30px;font-size:1.5rem;
  opacity:0.5;animation:float3 4s ease-in-out infinite;
  pointer-events:none;
}
.hero-c{max-width:520px;position:relative;z-index:1;animation:slide-up .6s var(--ease) both;}
.hero-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:linear-gradient(135deg,rgba(255,212,59,0.2),rgba(132,94,247,0.2));
  border:1.5px solid rgba(255,212,59,0.4);
  color:var(--k-yellow);padding:4px 14px;border-radius:20px;
  font-size:.65rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase;
  margin-bottom:16px;font-family:'Fredoka',sans-serif;backdrop-filter:blur(8px);
}
.hero h1{
  font-family:'Baloo 2',sans-serif;
  font-size:clamp(3rem,7vw,5.5rem);line-height:.95;font-weight:800;
  margin-bottom:16px;
  background:linear-gradient(135deg,#FFD43B 0%,#FF922B 35%,#F06595 65%,#845EF7 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
  filter:drop-shadow(0 3px 20px rgba(255,212,59,0.3));
}
body.light-theme .hero h1{
  background:linear-gradient(135deg,#C07A00 0%,#C04A00 35%,#A01060 65%,#5030B0 100%);
  -webkit-background-clip:text;background-clip:text;
}
.hero p{font-size:clamp(.82rem,2vw,.95rem);color:var(--txt-2);margin-bottom:26px;line-height:1.7;max-width:400px;font-weight:600;}
.hero-acts{display:flex;gap:10px;flex-wrap:wrap;}
.btn-play,.btn-more{
  border:none;padding:12px 24px;border-radius:14px;
  font-size:.85rem;font-weight:900;cursor:pointer;
  display:flex;align-items:center;gap:8px;font-family:'Fredoka',sans-serif;
  transition:.25s;letter-spacing:.03em;text-transform:uppercase;
}
.btn-play{
  background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;
  box-shadow:0 6px 24px rgba(255,180,50,0.35);
}
.btn-play:hover{transform:translateY(-3px) scale(1.04);box-shadow:0 12px 32px rgba(255,180,50,0.45);}
.btn-more{
  background:rgba(132,94,247,0.12);color:var(--silver);
  border:1.5px solid rgba(132,94,247,0.3);backdrop-filter:blur(8px);
}
.btn-more:hover{background:rgba(132,94,247,0.2);transform:translateY(-3px);}

/* ══════════════════════════════════════════════
   MAIN & SECTIONS
══════════════════════════════════════════════ */
main{padding:30px 24px 90px;}
.sec{margin-bottom:46px;}
.sec-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;}
.sec-title{
  font-size:.85rem;font-weight:900;display:flex;align-items:center;gap:10px;
  color:var(--txt);font-family:'Fredoka',sans-serif;letter-spacing:.04em;
}
.badge{
  font-size:.58rem;
  background:linear-gradient(135deg,rgba(132,94,247,0.15),rgba(240,101,149,0.15));
  color:var(--k-purple);border:1px solid rgba(132,94,247,0.25);
  padding:2px 9px;border-radius:20px;font-weight:900;letter-spacing:.1em;
  text-transform:uppercase;font-family:'Fredoka',sans-serif;
}
.see-all{
  color:var(--txt-3);font-size:.7rem;font-weight:800;text-decoration:none;
  opacity:0;transition:.25s;letter-spacing:.04em;text-transform:uppercase;
  font-family:'Fredoka',sans-serif;
  background:rgba(132,94,247,0.08);border:1px solid var(--border);
  padding:4px 12px;border-radius:20px;
}
.see-all:hover{color:var(--k-purple);border-color:var(--border-bright);background:rgba(132,94,247,0.14);}
.sec:hover .see-all{opacity:1;}

/* ══════════════════════════════════════════════
   CARDS
══════════════════════════════════════════════ */
.sl-c{position:relative;}
.sl-w{overflow:hidden;}
.sl{display:flex;gap:var(--gap);transition:transform .4s var(--ease);will-change:transform;}

.mc{
  flex:0 0 var(--card-w);width:var(--card-w);height:var(--card-h);
  border-radius:18px;overflow:hidden;position:relative;cursor:pointer;
  background:var(--bg-card);border:2px solid var(--border);
  box-shadow:var(--sh-card);
  transition:transform .3s var(--ease),border-color .3s,box-shadow .3s;
}
.mc::before{
  content:'';position:absolute;inset:0;z-index:1;
  background:linear-gradient(135deg,rgba(255,255,255,0.04) 0%,transparent 60%);
  pointer-events:none;opacity:0;transition:opacity .3s;
}
.mc:hover{transform:scale(1.06) translateY(-6px) rotate(.5deg);z-index:10;border-color:var(--k-yellow);box-shadow:var(--sh-hover),0 0 20px rgba(255,212,59,0.15);}
.mc:hover::before{opacity:1;}
.mc img{width:100%;height:100%;object-fit:cover;display:block;pointer-events:none;transition:filter .3s;}
.mc:hover img,.mc.tv-focused img{filter:brightness(.3) saturate(.5);}
.mc.tv-focused .co{opacity:1;}

/* Card overlay */
.co{
  position:absolute;inset:0;z-index:2;
  background:var(--co-gradient);
  opacity:0;transition:opacity .3s;
  display:flex;flex-direction:column;justify-content:flex-end;padding:12px;
}
.mc:hover .co{opacity:1;}
.ct{font-size:.8rem;font-weight:900;margin-bottom:4px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;font-family:'Fredoka',sans-serif;}
.cm{display:flex;align-items:center;gap:4px;flex-wrap:wrap;font-size:.63rem;color:var(--txt-3);margin-bottom:10px;font-family:'Nunito',monospace;font-weight:700;}
.cr{color:var(--k-yellow);font-weight:900;}
.ca{display:flex;gap:5px;}
.cb{
  border:none;border-radius:10px;font-size:.68rem;font-weight:900;cursor:pointer;
  font-family:'Fredoka',sans-serif;display:flex;align-items:center;justify-content:center;
  gap:3px;transition:.18s;padding:7px 0;letter-spacing:.03em;
}
.cb-p{flex:1;background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));color:#1A0A30;}
.cb-p:hover{transform:scale(1.05);filter:brightness(1.08);}
.cb-f{flex:0 0 32px;width:32px;background:rgba(240,101,149,0.12);color:var(--k-pink);border:1.5px solid rgba(240,101,149,0.25);}
.cb-f:hover{background:rgba(240,101,149,0.22);color:var(--k-pink);}
.cb-f.active{background:rgba(240,101,149,0.2);border-color:var(--k-pink);color:var(--k-pink);}

/* Card number badge */
.cn{
  position:absolute;top:8px;left:8px;z-index:3;
  background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;font-size:.6rem;font-weight:900;
  width:22px;height:22px;border-radius:6px;
  display:flex;align-items:center;justify-content:center;
  font-family:'Fredoka',sans-serif;
  box-shadow:0 2px 8px rgba(0,0,0,0.3);
}

/* Slider arrows */
.sl-arr{
  position:absolute;top:50%;transform:translateY(-50%);width:38px;height:80%;
  background:rgba(13,10,26,0.92);border:2px solid var(--border-bright);
  color:var(--k-yellow);font-size:1rem;cursor:pointer;z-index:20;
  display:none;align-items:center;justify-content:center;
  opacity:0;transition:.25s;backdrop-filter:blur(12px);
}
body.light-theme .sl-arr{background:rgba(255,248,231,0.92);}
@media(hover:hover){.sl-arr{display:flex;}.sl-c:hover .sl-arr{opacity:1;}}
.sl-arr:hover{background:rgba(132,94,247,0.2);color:var(--k-purple);}
.sl-arr.l{left:-38px;border-radius:0 14px 14px 0;}
.sl-arr.r{right:-38px;border-radius:14px 0 0 14px;}

/* ══════════════════════════════════════════════
   FAVORITES EMPTY STATE
══════════════════════════════════════════════ */
.empty-fav{
  display:flex;flex-direction:column;align-items:center;padding:52px 20px;text-align:center;
  border:2px dashed rgba(132,94,247,0.2);border-radius:20px;
  background:rgba(132,94,247,0.04);color:var(--txt-3);
}
.empty-fav .icon{font-size:3rem;margin-bottom:14px;animation:wiggle 2s ease-in-out infinite;}
.empty-fav h3{color:var(--txt-2);margin-bottom:8px;font-size:.95rem;font-weight:900;font-family:'Fredoka',sans-serif;}
.empty-fav p{font-size:.78rem;line-height:1.7;max-width:240px;color:var(--txt-3);font-weight:600;}

/* ══════════════════════════════════════════════
   TOAST
══════════════════════════════════════════════ */
.toast{
  position:fixed;z-index:9999;bottom:24px;right:20px;left:20px;max-width:320px;margin:0 auto;
  background:rgba(26,21,48,0.98);border:2px solid rgba(132,94,247,0.35);
  color:var(--k-yellow);padding:12px 16px;border-radius:14px;
  font-size:.8rem;font-weight:800;
  box-shadow:0 12px 40px rgba(0,0,0,.7),0 0 20px rgba(132,94,247,0.15);
  border-left:3px solid var(--k-yellow);
  backdrop-filter:blur(20px);display:flex;align-items:center;gap:10px;
  transform:translateY(80px) scale(.95);opacity:0;
  transition:all .35s var(--ease);pointer-events:none;
  font-family:'Fredoka',sans-serif;
}
body.light-theme .toast{background:rgba(255,248,231,0.98);color:var(--k-purple);border-left-color:var(--k-purple);}
.toast.show{transform:translateY(0) scale(1);opacity:1;}

/* Divider */
.sec-div{height:2px;background:linear-gradient(90deg,transparent,rgba(132,94,247,0.2),rgba(255,212,59,0.2),transparent);margin:4px 0 38px;}

/* Scrollbar */
::-webkit-scrollbar{width:5px;}
::-webkit-scrollbar-track{background:var(--bg);}
::-webkit-scrollbar-thumb{background:rgba(132,94,247,0.3);border-radius:5px;}

/* ══════════════════════════════════════════════
   AD BAR
══════════════════════════════════════════════ */
.ad-bar{
  background:rgba(26,21,48,0.8);border:2px solid var(--border);border-radius:16px;
  padding:12px 18px;margin-bottom:32px;
  display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;
  backdrop-filter:blur(12px);
}
.ad-ph{
  background:rgba(132,94,247,0.06);border:1px dashed rgba(132,94,247,0.2);
  border-radius:10px;padding:12px 32px;text-align:center;
  font-size:.65rem;color:var(--txt-3);font-family:'Fredoka',sans-serif;letter-spacing:.06em;
}
.ad-cl{background:none;border:none;color:var(--txt-3);cursor:pointer;font-size:1.1rem;padding:4px;transition:.2s;border-radius:6px;}
.ad-cl:hover{color:var(--k-red);background:rgba(255,80,80,0.1);}

/* ══════════════════════════════════════════════
   CONTINUE WATCHING
══════════════════════════════════════════════ */
.cw-sec{margin-bottom:46px;animation:cwFadeIn .5s var(--ease) both;}
.cw-card{
  flex:0 0 210px;width:210px;height:122px;border-radius:14px;overflow:hidden;
  position:relative;cursor:pointer;background:var(--bg-card);
  border:2px solid var(--border);box-shadow:var(--sh-card);
  transition:transform .28s var(--ease),border-color .28s,box-shadow .28s;flex-shrink:0;
}
.cw-card:hover{transform:scale(1.04) translateY(-5px);z-index:10;border-color:var(--k-yellow);box-shadow:var(--sh-hover);}
.cw-card img{width:100%;height:100%;object-fit:cover;display:block;transition:filter .28s;}
.cw-card:hover img{filter:brightness(.3) saturate(.5);}
.cw-overlay{
  position:absolute;inset:0;
  background:linear-gradient(to top,rgba(13,10,26,0.98) 0%,rgba(13,10,26,0.5) 45%,transparent 70%);
  opacity:0;transition:opacity .28s;display:flex;flex-direction:column;justify-content:flex-end;padding:9px 10px 11px;
}
body.light-theme .cw-overlay{background:linear-gradient(to top,rgba(255,248,231,0.98) 0%,rgba(255,248,231,0.6) 45%,transparent 70%);}
.cw-card:hover .cw-overlay{opacity:1;}
.cw-title{font-size:.78rem;font-weight:900;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:2px;font-family:'Fredoka',sans-serif;}
.cw-meta{font-size:.62rem;color:var(--txt-2);margin-bottom:7px;font-weight:700;}
.cw-actions{display:flex;gap:5px;}
.cw-btn-play{
  flex:1;background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;border:none;border-radius:7px;font-size:.65rem;font-weight:900;
  padding:5px 4px;cursor:pointer;font-family:'Fredoka',sans-serif;
  display:flex;align-items:center;justify-content:center;gap:3px;transition:.15s;
}
.cw-btn-play:hover{filter:brightness(1.08);transform:scale(1.04);}
.cw-btn-rm{
  width:26px;height:26px;background:rgba(255,80,80,0.1);
  border:1px solid rgba(255,80,80,0.2);color:var(--k-red);
  border-radius:7px;cursor:pointer;font-size:.7rem;
  display:flex;align-items:center;justify-content:center;transition:.15s;flex-shrink:0;
}
.cw-btn-rm:hover{background:rgba(255,80,80,.25);border-color:rgba(255,80,80,.4);}
.cw-prog-wrap{position:absolute;bottom:0;left:0;right:0;height:3px;background:rgba(132,94,247,0.15);}
.cw-prog-bar{height:100%;background:linear-gradient(90deg,var(--k-yellow),var(--k-orange));border-radius:0 2px 2px 0;transition:width .3s;}
.cw-prog-label{
  position:absolute;top:6px;left:7px;
  background:rgba(13,10,26,.88);border:1px solid rgba(255,212,59,0.25);
  color:var(--k-yellow);font-size:.55rem;font-weight:900;
  padding:1px 7px;border-radius:8px;backdrop-filter:blur(6px);font-family:'Fredoka',sans-serif;
}
body.light-theme .cw-prog-label{background:rgba(255,248,231,.9);color:var(--k-orange);}
.cw-rm-corner{
  position:absolute;top:6px;right:7px;width:22px;height:22px;border-radius:50%;
  background:rgba(255,80,80,0.15);border:1px solid rgba(255,80,80,0.25);
  color:var(--k-red);font-size:.65rem;cursor:pointer;
  display:flex;align-items:center;justify-content:center;transition:.2s;z-index:5;opacity:0;
}
.cw-card:hover .cw-rm-corner{opacity:1;}
.cw-rm-corner:hover{background:rgba(255,80,80,.3);border-color:rgba(255,80,80,.5);}

/* ══════════════════════════════════════════════
   CALENDAR
══════════════════════════════════════════════ */
.cal-sec{margin-top:50px;margin-bottom:60px;}
.cal-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;}
.cal-title{font-size:.85rem;font-weight:900;display:flex;align-items:center;gap:10px;color:var(--txt);font-family:'Fredoka',sans-serif;}
.cmn{display:flex;align-items:center;gap:7px;}
.cmn button{
  background:rgba(132,94,247,0.08);border:1.5px solid var(--border);
  color:var(--k-purple);width:32px;height:32px;border-radius:10px;cursor:pointer;
  font-size:.85rem;transition:.2s;display:flex;align-items:center;justify-content:center;
}
.cmn button:hover{background:rgba(132,94,247,0.18);border-color:var(--border-bright);}
.cml{font-size:.82rem;font-weight:900;color:var(--txt);min-width:110px;text-align:center;font-family:'Fredoka',sans-serif;letter-spacing:.04em;}
.ctw{
  overflow-x:auto;border-radius:16px;
  border:2px solid var(--border);
  background:rgba(26,21,48,0.6);backdrop-filter:blur(14px);
}
body.light-theme .ctw{background:rgba(255,255,255,0.75);}
.ct2{width:100%;border-collapse:collapse;min-width:580px;}
.ct2 th{
  padding:12px 16px;font-size:.65rem;font-weight:900;letter-spacing:.1em;text-transform:uppercase;
  color:var(--k-purple);border-bottom:2px solid var(--border);text-align:left;
  background:rgba(132,94,247,0.06);font-family:'Fredoka',sans-serif;
}
.ct2 td{padding:10px 16px;border-bottom:1px solid rgba(132,94,247,0.06);vertical-align:middle;font-size:.82rem;font-weight:700;}
.ct2 tr:last-child td{border-bottom:none;}
.ct2 tr:hover td{background:rgba(132,94,247,0.04);}
.cal-poster{width:38px;height:55px;object-fit:cover;border-radius:7px;border:2px solid var(--border);flex-shrink:0;}
.csc{display:flex;align-items:center;gap:11px;}
.csn{font-weight:900;color:var(--txt);font-size:.84rem;font-family:'Fredoka',sans-serif;}
.csm{font-size:.65rem;color:var(--txt-3);margin-top:2px;font-weight:700;}
.ceb{
  display:inline-flex;align-items:center;gap:4px;
  background:rgba(132,94,247,0.1);border:1.5px solid rgba(132,94,247,0.25);
  color:var(--k-purple);padding:3px 10px;border-radius:20px;
  font-size:.67rem;font-weight:900;white-space:nowrap;font-family:'Fredoka',sans-serif;
}
.ceb.new{background:rgba(255,212,59,0.12);border-color:rgba(255,212,59,0.35);color:var(--k-yellow);}
.cdc{font-weight:800;color:var(--txt-2);white-space:nowrap;font-size:.8rem;}
.cday{font-size:1rem;font-weight:900;color:var(--txt);display:block;font-family:'Fredoka',sans-serif;}
.cwdy{font-size:.62rem;color:var(--txt-3);text-transform:uppercase;letter-spacing:.08em;font-weight:700;}
.cdt .cday{color:var(--k-yellow);}
.cpf{font-size:.67rem;color:var(--txt-3);white-space:nowrap;}
.cpf span{background:rgba(132,94,247,0.08);border:1px solid var(--border);padding:3px 9px;border-radius:6px;font-weight:800;font-family:'Fredoka',sans-serif;}
.cale{text-align:center;padding:40px 20px;color:var(--txt-3);font-size:.82rem;font-family:'Fredoka',sans-serif;letter-spacing:.04em;}
.caltabs{display:flex;gap:5px;flex-wrap:wrap;}
.caltab{
  padding:5px 14px;border-radius:20px;font-size:.68rem;font-weight:900;cursor:pointer;
  border:1.5px solid var(--border);background:transparent;color:var(--txt-3);
  font-family:'Fredoka',sans-serif;transition:.2s;letter-spacing:.03em;text-transform:uppercase;
}
.caltab.active{
  background:linear-gradient(135deg,rgba(132,94,247,0.2),rgba(240,101,149,0.15));
  border-color:rgba(132,94,247,0.4);color:var(--txt);
}
.caltab:hover{background:rgba(132,94,247,0.08);color:var(--txt-2);}

/* ══════════════════════════════════════════════
   ANDROID MODE BUTTON
══════════════════════════════════════════════ */
.and-btn{
  position:fixed;bottom:24px;left:20px;z-index:9990;
  background:rgba(26,21,48,0.95);border:2px solid var(--border-bright);
  color:var(--k-purple);padding:9px 16px;border-radius:20px;
  font-size:.72rem;font-weight:900;font-family:'Fredoka',sans-serif;
  cursor:pointer;display:flex;align-items:center;gap:7px;
  box-shadow:0 4px 24px rgba(0,0,0,0.5);transition:.2s;
  backdrop-filter:blur(12px);
}
body.light-theme .and-btn{background:rgba(255,248,231,0.97);}
.and-btn:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(132,94,247,0.25);}
.and-btn.active{border-color:var(--k-yellow);color:var(--k-yellow);}

/* ══════════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════════ */
@media(min-width:600px){:root{--card-w:188px;--card-h:282px;--hdr:66px;}header{padding:0 30px;}.hero{padding:0 30px 52px;}main{padding:32px 30px 90px;}}
@media(min-width:1024px){:root{--card-w:200px;--card-h:300px;--hdr:68px;}header{padding:0 4%;}.hero{min-height:480px;max-height:660px;padding:0 4% 60px;}main{padding:36px 4% 90px;}}
@media(min-width:1600px){:root{--card-w:220px;--card-h:330px;}}

@media(max-width:599px){
  :root{--card-w:132px;--card-h:198px;--gap:9px;}
  .mc{border-radius:12px;}.mc:hover{transform:scale(1.04) translateY(-3px);}
  .ct{font-size:.72rem;}.cm{font-size:.6rem;gap:3px;}.cb{padding:5px 0;}.cb-p{font-size:.62rem;}.cb-f{flex:0 0 28px;width:28px;}.cn{font-size:.52rem;width:19px;height:19px;top:5px;left:5px;}.co{padding:9px;}
  .hero{min-height:64vw;padding:0 16px 34px;}.hero h1{font-size:2.8rem;}.hero p{font-size:.8rem;max-width:100%;}
  .btn-play,.btn-more{padding:10px 18px;font-size:.78rem;}
  main{padding:20px 16px calc(var(--mob-nav-h) + 32px)!important;}
  .sec-title{font-size:.75rem;}.sec-hdr{margin-bottom:12px;}
  header{padding:0 16px;}.logo img{height:30px;}nav.mnav{display:none;}
  .cw-card{flex:0 0 170px;width:170px;height:100px;}.cw-title{font-size:.72rem;}.cw-meta{font-size:.58rem;}
  .deco-shape{display:none;}
}

/* ══════════════════════════════════════════════
   MOBILE BOTTOM NAV
══════════════════════════════════════════════ */
.mob-nav{
  display:none;position:fixed;bottom:0;left:0;right:0;height:var(--mob-nav-h);z-index:300;
  background:rgba(13,10,26,0.97);
  backdrop-filter:blur(28px) saturate(1.8);-webkit-backdrop-filter:blur(28px) saturate(1.8);
  border-top:2px solid var(--border);box-shadow:0 -8px 40px rgba(0,0,0,0.7);
}
body.light-theme .mob-nav{background:rgba(255,248,231,0.97);}
@media(max-width:767px){
  .mob-nav{display:flex;}
  main{padding-bottom:calc(var(--mob-nav-h) + 32px)!important;}
  .toast{bottom:calc(var(--mob-nav-h) + 10px);}
  .and-btn{bottom:calc(var(--mob-nav-h) + 10px);}
}
.mob-nav-inner{display:flex;width:100%;height:100%;align-items:stretch;padding:0 4px;}
.mob-ni{
  flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;
  text-decoration:none;color:var(--txt-3);font-size:.52rem;font-weight:900;
  letter-spacing:.04em;text-transform:uppercase;border:none;background:transparent;
  cursor:pointer;font-family:'Fredoka',sans-serif;padding:8px 2px 10px;position:relative;
  transition:color .22s var(--ease);-webkit-tap-highlight-color:transparent;overflow:hidden;
}
.mob-ni.mob-active,.mob-ni:focus-visible{color:var(--k-yellow);}
.mob-ni::before{
  content:'';position:absolute;top:0;left:50%;transform:translateX(-50%) scaleX(0);
  width:28px;height:2px;background:linear-gradient(90deg,var(--k-yellow),var(--k-orange));
  border-radius:0 0 3px 3px;transition:transform .28s var(--ease),opacity .28s;opacity:0;
}
.mob-ni.mob-active::before{transform:translateX(-50%) scaleX(1);opacity:1;}
.mob-ni-ico{width:24px;height:24px;display:flex;align-items:center;justify-content:center;position:relative;transition:transform .22s var(--ease);}
.mob-ni:active .mob-ni-ico{transform:scale(0.8);}
.mob-ni.mob-active .mob-ni-ico{filter:drop-shadow(0 0 6px rgba(255,212,59,0.4));}
.mob-ni svg{width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;transition:stroke .22s;}
.mob-ni-badge{
  position:absolute;top:-2px;right:-4px;
  background:linear-gradient(135deg,var(--k-yellow),var(--k-orange));
  color:#1A0A30;border-radius:50%;width:14px;height:14px;
  font-size:7.5px;font-weight:900;display:flex;align-items:center;justify-content:center;
  border:1.5px solid var(--bg);line-height:1;font-family:'Fredoka',sans-serif;
}
.mob-ni-ripple{
  position:absolute;inset:0;border-radius:50%;
  background:radial-gradient(circle,rgba(255,212,59,0.12) 0%,transparent 70%);
  transform:scale(0);opacity:0;pointer-events:none;transition:transform .4s var(--ease),opacity .4s;
}
.mob-ni:active .mob-ni-ripple{transform:scale(3);opacity:1;}
.mob-ni-lbl{font-size:.52rem;font-weight:900;letter-spacing:.04em;line-height:1;transition:color .22s;}

/* ══════════════════════════════════════════════
   FUN FEATURE BANNER
══════════════════════════════════════════════ */
.fun-banner{
  background:linear-gradient(135deg,rgba(132,94,247,0.12),rgba(255,148,59,0.10),rgba(240,101,149,0.12));
  border:2px solid rgba(132,94,247,0.2);border-radius:20px;padding:16px 20px;
  margin-bottom:32px;display:flex;align-items:center;gap:16px;flex-wrap:wrap;
  position:relative;overflow:hidden;
}
.fun-banner::before{
  content:'🎠 🎪 🎡 🎢';position:absolute;right:16px;top:50%;
  transform:translateY(-50%);font-size:1.2rem;opacity:0.4;
  animation:float3 5s ease-in-out infinite;
}
.fun-banner-txt{font-family:'Fredoka',sans-serif;font-size:.82rem;font-weight:700;color:var(--txt-2);}
.fun-banner-txt strong{color:var(--k-yellow);}
</style>
</head>
<body class="<?= esc($theme_class) ?>">

<!-- DECORATIVE FLOATING SHAPES -->
<div class="deco-shapes">
  <span class="deco-shape">⭐</span>
  <span class="deco-shape">🌈</span>
  <span class="deco-shape">🎈</span>
  <span class="deco-shape">✨</span>
  <span class="deco-shape">🦋</span>
  <span class="deco-shape">🌟</span>
  <span class="deco-shape">🎀</span>
</div>
<div class="noise-overlay"></div>

<!-- LOADING -->
<div class="ls" id="ls">
  <div class="ls-logo"><img src="https://yourfiles.cloud/uploads/d4380759d9fbe11bdf5c47e65f91921c/%2B-removebg-preview.png" alt="WOXPLUS Kids"></div>
  <div class="ls-emojis">
    <span>🎬</span><span>🌟</span><span>🎭</span><span>🎪</span><span>✨</span>
  </div>
  <div class="ls-bar"><div class="ls-fill"></div></div>
  <div class="ls-txt">Yükleniyor... 🚀</div>
</div>

<!-- SETTINGS MODAL -->
<div class="settings-overlay" id="settingsOverlay" onclick="if(event.target===this)closeSettings()">
  <div class="settings-modal">
    <div class="settings-modal-hdr">
      <span class="settings-modal-title">⚙️ Ayarlar</span>
      <button class="settings-close" onclick="closeSettings()">✕</button>
    </div>
    <div class="settings-group">
      <span class="settings-label">🎨 Tema</span>
      <div class="settings-opts">
        <button class="settings-opt <?= $THEME==='dark'?'active':'' ?>" data-val="dark" onclick="selectOpt(this,'theme')">🌙 Gece Modu</button>
        <button class="settings-opt <?= $THEME==='light'?'active':'' ?>" data-val="light" onclick="selectOpt(this,'theme')">☀️ Gündüz Modu</button>
      </div>
    </div>
    <div class="settings-group">
      <span class="settings-label">🌐 Dil</span>
      <div class="settings-opts">
        <button class="settings-opt <?= $LANG==='tr'?'active':'' ?>" data-val="tr" onclick="selectOpt(this,'lang')">🇹🇷 Türkçe</button>
        <button class="settings-opt <?= $LANG==='en'?'active':'' ?>" data-val="en" onclick="selectOpt(this,'lang')">🇬🇧 English</button>
        <button class="settings-opt <?= $LANG==='de'?'active':'' ?>" data-val="de" onclick="selectOpt(this,'lang')">🇩🇪 Deutsch</button>
      </div>
    </div>
    <button class="settings-save" onclick="saveSettings()">💾 Kaydet!</button>
  </div>
</div>

<div id="main-app" style="opacity:0;transition:opacity .45s">

<!-- TV SIDENAV -->
<nav class="tv-sidenav" id="tvNav">
  <div class="tv-si">
    <a href="#" class="tv-ni active-nav focusable" data-sec="top"><span class="icon">🏠</span><span class="lbl">Ana Sayfa</span></a>
    <a href="#trends" class="tv-ni focusable"><span class="icon">🔥</span><span class="lbl">Trendler</span></a>
    <a href="#action" class="tv-ni focusable"><span class="icon">⚡</span><span class="lbl">Enerji Verici</span></a>
    <a href="#series" class="tv-ni focusable"><span class="icon">📺</span><span class="lbl">Diziler</span></a>
    <a href="#movies" class="tv-ni focusable"><span class="icon">🎬</span><span class="lbl">Filmler</span></a>
    <a href="#favorites" class="tv-ni focusable"><span class="icon">❤️</span><span class="lbl">Listem</span></a>
    <a href="#calendar" class="tv-ni focusable"><span class="icon">📅</span><span class="lbl">Takvim</span></a>
  </div>
  <button class="tv-toggle" id="tvTog">❯</button>
</nav>
<div class="tv-ind">📺 Android Modu</div>

<!-- HEADER -->
<header id="hdr">
  <a href="index.php" class="logo">
    <img src="https://yourfiles.cloud/uploads/d4380759d9fbe11bdf5c47e65f91921c/%2B-removebg-preview.png" alt="WOXPLUS Kids">
    <span class="logo-kids-badge">KIDS</span>
  </a>
  <nav class="mnav">
    <a href="#" class="active">🏠 Ana Sayfa</a>
    <a href="/gl.php">🎬 Shorts</a>
    <a href="/destek-ekibi">💬 Destek</a>
    <a href="#movies">🎭 Filmler</a>
    <a href="#favorites">❤️ Listem</a>
    <a href="#calendar">📅 Takvim</a>
  </nav>
  <div class="hdr-r">
    <div class="upbadge">
      <img class="uav" src="<?= esc($USER_AVA) ?>" alt="<?= esc($USER_NAME) ?>">
      <span class="uname"><?= esc($USER_NAME) ?></span>
    </div>
    <button class="cast-btn" id="castBtn" onclick="toggleCast()" title="TV'ye Yansıt">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 8.4C2 6 4.686 4 8 4h8c3.314 0 6 2 6 4.4v7.2C22 18 19.314 20 16 20h-4"/><path d="M2 15.6C2 18 4.686 20 8 20"/><circle cx="5" cy="20" r="2"/></svg>
      <span class="cast-lbl">📺 Yansıt</span>
    </button>
    <button class="settings-btn" onclick="openSettings()" title="Ayarlar">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
      <span class="settings-lbl">⚙️ Ayarlar</span>
    </button>
    <button class="btn-lo" onclick="doLogout()">Çıkış 👋</button>
    <button class="fav-btn" onclick="document.getElementById('favorites').scrollIntoView({behavior:'smooth'})" title="Listem">
      ❤️<span class="fav-cnt" id="fav-cnt">0</span>
    </button>
  </div>
</header>

<!-- HERO -->
<section class="hero">
  <div class="hero-c">
    <div class="hero-badge">🔥 #1 Türkiye'de Trend</div>
    <h1>Shin Chan<br>Spin-off</h1>
    <p>En sevdiğin çizgi filmleri ve dizileri en kaliteli görüntüyle izle! Binlerce eğlenceli içerik seni bekliyor! 🎉</p>
    <div class="hero-acts">
      <button class="btn-play" onclick="window.open('https://www.netflix.com','_blank')">▶ Şimdi İzle!</button>
      <button class="btn-more">ℹ️ Daha Fazla</button>
    </div>
  </div>
</section>

<main>

<!-- FUN BANNER (replaces boring ad bar) -->
<div class="fun-banner" id="ad-bar">
  <div>
    <div class="fun-banner-txt">🎯 <strong>Premium Üyelik</strong> — Tüm içeriklere sınırsız eriş! ✨</div>
    <div class="fun-banner-txt" style="font-size:.72rem;margin-top:2px;">Üyelik Bitiş: <strong style="color:var(--k-teal)">—</strong></div>
  </div>
  <button class="ad-cl" onclick="this.closest('.fun-banner').style.display='none'" title="Kapat">✕</button>
</div>

<!-- İZLEMEYE DEVAM ET -->
<section class="sec cw-sec" id="continue-watching" style="display:none">
  <div class="sec-hdr">
    <div class="sec-title">▶️ İzlemeye Devam Et <span class="badge" id="cw-badge">0</span></div>
    <a class="see-all" href="#" onclick="cwClearAll(event)">🗑️ Tümünü Temizle</a>
  </div>
  <div class="sl-c">
    <button class="sl-arr l">❮</button>
    <div class="sl-w"><div class="sl" id="cw-sl"></div></div>
    <button class="sl-arr r">❯</button>
  </div>
</section>

<!-- TRENDLER -->
<section class="sec" id="trends">
  <div class="sec-hdr">
    <div class="sec-title">🔥 Türkiye'de Trendler <span class="badge">YENİ</span></div>
    <a class="see-all" href="#">Tümünü Gör ›</a>
  </div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">

  <?php
  $trends = [
    [1,'Goat Girl','https://miam-animation.com/images/Vignettes_GoatGirl','http://playcloudmovie0.ct.ws/playerbeta.php','2016','Sci-Fi','8.7'],
    [2,'PAW Patrol','https://m.media-amazon.com/images/M/MV5BODg0NDY1MjktMzA5MS00OGQ2LTliMWItZTdmZjNlYzQ2MWM1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/ben10u.html','2016','Drama','8.7'],
    [3,'Mighty Nein','https://m.media-amazon.com/images/I/813YVUNJ7xL.jpg','http://playnetflixcloud.ct.ws/la.html','2021','Thriller','8.0'],
    [4,'Ben10 Alien Force','https://i.redd.it/13-years-ago-today-ben-10-alien-force-premiered-on-cartoon-v0-eq7sgbxh81u61.jpg?width=780&format=pjpg&auto=webp&s=d68478a1eb7fd11f85145a82896d3400e6d52b40','/ben10a.html','2017','Crime','8.4'],
    [5,'Gumball 2025','https://img1.hulu.com/user/v3/artwork/91de62df-0394-4e17-85a8-e843bd730ede?base_image_bucket_name=image_manager&base_image=019a9e0b-b1b1-7762-8a2a-837d1cb00d44&size=458x687&format=webp','/gumball2025.php','2015','Crime','8.8'],
    [6,'Alien Earth','https://m.media-amazon.com/images/M/MV5BOGIyNGRiNzgtOWQxZC00YzJmLThlZTYtYTMyMDk0YWZjMTk5XkEyXkFqcGc@._V1_QL75_UX190_CR0,0,190,281_.jpg','https://netflixfree.xo.je/alien.html?i=1','2017','Mystery','8.8'],
    [7,'Steven Universe','https://m.media-amazon.com/images/M/MV5BZGJjMmI3ZDMtZTgyNi00MTZhLWE2ZjAtN2Q4YTUyMTg4OGY1XkEyXkFqcGc@._V1_.jpg','http://playcloudmovie0.ct.ws/player3.html','2017','Action','8.2'],
    [8,'Prison Break','https://tr.web.img3.acsta.net/pictures/17/05/22/16/49/588696.jpg','https://playnetflixcloud.ct.ws/break.html','2020','Romance','7.3'],
  ];
  foreach($trends as $i=>$t):
    $id=$t[0];$title=$t[1];$img=$t[2];$url=$t[3];$year=$t[4];$genre=$t[5];$rating=$t[6];
    $isFav = in_array(strval($id), $FAV_IDS);
  ?>
  <div class="mc focusable">
    <img src="<?=esc($img)?>" alt="<?=esc($title)?>" loading="lazy">
    <div class="cn"><?=$i+1?></div>
    <div class="co">
      <div class="ct"><?=esc($title)?></div>
      <div class="cm"><span><?=esc($year)?></span><span>•</span><span><?=esc($genre)?></span><span class="cr">★ <?=esc($rating)?></span></div>
      <div class="ca">
        <button class="cb cb-p" onclick="playContent(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')">▶ İzle</button>
        <button class="cb cb-f<?=$isFav?' active':''?>" data-id="<?=$id?>" onclick="toggleFav(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')"><?=$isFav?'✓':'+'?></button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- ENERJİ VERİCİ -->
<section class="sec" id="action">
  <div class="sec-hdr"><div class="sec-title">⚡ Enerji Verici</div><a class="see-all" href="#">Tümünü Gör ›</a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">

  <?php
  $action = [
    [9,'Cartoon Network','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSLrYHk3XUpYzU8Hc9PJcoZ-VCxHWkTmU_29w&s','https://yayin2.canlitv.fun/live/cartoon-network.stream/chunklist_w768216148.m3u8?hash=a80477f7eb4fa22c4a2c64480c7a1f44','2020','Action','6.7'],
    [10,'Superman','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrRzkKBDEzf7TMbh6-29wCujSxzn1IhpAS1g&s','https://playnetflixcloud.ct.ws/superman.html','2021','Action','5.7'],
    [11,'Transformers Prime','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTNFjOhue5IVD_HNTQArIo05K8dAXC_L7TOhw&s','https://playnetflixcloud.ct.ws/prime.html','2020','Action','6.6'],
    [12,'Bojack Horseman','https://m.media-amazon.com/images/M/MV5BZmMwMDlkNTEtMmQzZS00ODQ0LWJlZmItOTgwYWMwZGM4MzFiXkEyXkFqcGc@._V1_.jpg','https://www.netflix.com/title/80187340','2019','Action','6.1'],
    [13,'Central Park','https://m.media-amazon.com/images/M/MV5BZjc5ZDRmOTktMTdjMC00OTQyLTk4NDktN2Y3OWY0ZDNjZTc1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','http://playcloudmovie0.ct.ws/player6.html','2020','Action','6.0'],
    [30,'Adventure Time','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQfUdHdoMyvXfvIZWQGfnteU8X5C_52CRHEig&s','/adventuretime.html','2020','Action','6.0'],
    [31,'The Walking Dead','https://m.media-amazon.com/images/M/MV5BYWQwMGRhNGEtZTNhMy00MzVjLWJhMjItYjcwMDljMTkyNTg2XkEyXkFqcGc@._V1_.jpg','/walking.html','2020','Action','6.0'],
    [14,'Stranger Things','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSYqdmwnE0QopCQ4S3pNXw9yWh5cwCxktCjUQ&s','https://netflixfree.xo.je/stranger.html','2021','Action','6.3'],
  ];
  foreach($action as $t):
    $id=$t[0];$title=$t[1];$img=$t[2];$url=$t[3];$year=$t[4];$genre=$t[5];$rating=$t[6];
    $isFav = in_array(strval($id), $FAV_IDS);
  ?>
  <div class="mc focusable">
    <img src="<?=esc($img)?>" alt="<?=esc($title)?>" loading="lazy">
    <div class="co">
      <div class="ct"><?=esc($title)?></div>
      <div class="cm"><span><?=esc($year)?></span><span>•</span><span><?=esc($genre)?></span><span class="cr">★ <?=esc($rating)?></span></div>
      <div class="ca">
        <button class="cb cb-p" onclick="playContent(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')">▶ İzle</button>
        <button class="cb cb-f<?=$isFav?' active':''?>" data-id="<?=$id?>" onclick="toggleFav(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')"><?=$isFav?'✓':'+'?></button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- GENÇ ANİMASYONLARI -->
<section class="sec" id="animation">
  <div class="sec-hdr"><div class="sec-title">🎨 Genç Animasyonları</div><a class="see-all" href="#">Tümünü Gör ›</a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">

  <?php
  $anim = [
    [28,'Universal Basic Guys','https://m.media-amazon.com/images/M/MV5BOGVlYjgyYjItN2M2MC00YzhkLThlNGQtOTdjZDQ2MDY1YTQ5XkEyXkFqcGc@._V1_.jpg','/universal.php','2022','Comedy','8.1'],
    [29,'Family Guy','https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg','/familyguy.html','2020','Romance','7.2'],
    [30,'The Simpsons','https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/thesimpsonss.html','2013','Crime','8.8'],
    [31,'The Great North','https://m.media-amazon.com/images/M/MV5BZTYxZjA0MjQtZTViNi00ZWI2LWFmNGUtMzIxZWVjYTE4M2JkXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/great.php','2019','Fantasy','8.2'],
    [38,'Beavis ve Butthead Filmi 2','https://upload.wikimedia.org/wikipedia/en/thumb/6/66/Beavis_and_Butt-head_2022_film_poster.jpg/250px-Beavis_and_Butt-head_2022_film_poster.jpg','/beavism.php','2021','Crime','7.5'],
    [39,'Shogun','https://www.blackstonepublishing.com/cdn/shop/files/bhdr-Rectangle-cover.jpg?v=1771613067','/shogun.php','2021','Crime','7.5'],
  ];
  foreach($anim as $t):
    $id=$t[0];$title=$t[1];$img=$t[2];$url=$t[3];$year=$t[4];$genre=$t[5];$rating=$t[6];
    $isFav = in_array(strval($id), $FAV_IDS);
  ?>
  <div class="mc focusable">
    <img src="<?=esc($img)?>" alt="<?=esc($title)?>" loading="lazy">
    <div class="co">
      <div class="ct"><?=esc($title)?></div>
      <div class="cm"><span><?=esc($year)?></span><span>•</span><span><?=esc($genre)?></span><span class="cr">★ <?=esc($rating)?></span></div>
      <div class="ca">
        <button class="cb cb-p" onclick="playContent(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')">▶ İzle</button>
        <button class="cb cb-f<?=$isFav?' active':''?>" data-id="<?=$id?>" onclick="toggleFav(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')"><?=$isFav?'✓':'+'?></button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- DİZİLER -->
<section class="sec" id="series">
  <div class="sec-hdr"><div class="sec-title">📺 Popüler Diziler</div><a class="see-all" href="#">Tümünü Gör ›</a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">

  <?php
  $series = [
    [15,'Breaking Bad','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ7AUQ1ap545wJq1Op_9GPLFAV15boesLoyZA&s','https://playnetflixcloud.ct.ws/break.html','2022','Comedy','8.1'],
    [16,'Family Guy','https://m.media-amazon.com/images/M/MV5BNTZlMGQ1YjEtMzVlNC00ZmMxLTk0MzgtZjdkYTU1NmUxNTQ0XkEyXkFqcGc@._V1_.jpg','/familyguy.html','2020','Romance','7.2'],
    [17,'The Simpsons','https://m.media-amazon.com/images/M/MV5BNTU2OWE0YWYtMjRlMS00NTUwLWJmZWUtODFhNzJiMGJlMzI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/thesimpsonss.html','2013','Crime','8.8'],
    [18,'ICarly','https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTwnomNThFwvxl-kirrn19NypwmVsfNohzDyg&s','/icarly.html','2019','Fantasy','8.2'],
    [19,'One Piece','https://i.redd.it/1es0su8z2y9c1.jpeg','/onepiece.html','2021','Crime','7.5'],
    [1119,'Young Sherlock','https://upload.wikimedia.org/wikipedia/en/d/d6/Young_Sherlock_poster.jpg','/sher.html','2021','Crime','7.5'],
    [1089,'Ninja Kaplumbağalar 2012','https://m.media-amazon.com/images/M/MV5BZDNiZDk0M2ItNWM4Zi00YjQ0LWJjOGItMDFlMmQ2NTcwZTcxXkEyXkFqcGc@._V1_.jpg','/tmnt.html','2021','Crime','7.5'],
    [20,'Vampirina 2026','https://m.media-amazon.com/images/M/MV5BOTg4MjU4YzYtNTIwYy00ODgyLTg3YTQtY2ViMGIzYWQwNTFiXkEyXkFqcGc@._V1_.jpg','http://playcloudmovie0.ct.ws/player2.html','2019','Comedy','8.3'],
    [20,'DareDevil 2025','https://m.media-amazon.com/images/M/MV5BODcwOTg2MDE3NF5BMl5BanBnXkFtZTgwNTUyNTY1NjM@._V1_FMjpg_UX1000_.jpg','https://playcloudmovie0.ct.ws/daredevil1.php?i=3','2019','Comedy','8.3'],
  ];
  foreach($series as $t):
    $id=$t[0];$title=$t[1];$img=$t[2];$url=$t[3];$year=$t[4];$genre=$t[5];$rating=$t[6];
    $isFav = in_array(strval($id), $FAV_IDS);
  ?>
  <div class="mc focusable">
    <img src="<?=esc($img)?>" alt="<?=esc($title)?>" loading="lazy">
    <div class="co">
      <div class="ct"><?=esc($title)?></div>
      <div class="cm"><span><?=esc($year)?></span><span>•</span><span><?=esc($genre)?></span><span class="cr">★ <?=esc($rating)?></span></div>
      <div class="ca">
        <button class="cb cb-p" onclick="playContent(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')">▶ İzle</button>
        <button class="cb cb-f<?=$isFav?' active':''?>" data-id="<?=$id?>" onclick="toggleFav(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')"><?=$isFav?'✓':'+'?></button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- TAVSİYE EDİLENLER -->
<section class="sec" id="movies">
  <div class="sec-hdr"><div class="sec-title">🎬 Tavsiye Edilenler</div><a class="see-all" href="#">Tümünü Gör ›</a></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">

  <?php
  $movies = [
    [21,'Demon Slayer','https://m.media-amazon.com/images/M/MV5BMWU1OGEwNmQtNGM3MS00YTYyLThmYmMtN2FjYzQzNzNmNTE0XkEyXkFqcGc@._V1_QL75_UX190_CR0,2,190,281_.jpg','/naruto.html','2018','Horror','6.6'],
    [32,'Benim Kahraman Akademim','https://m.media-amazon.com/images/M/MV5BY2QzODA5OTQtYWJlNi00ZjIzLThhNTItMDMwODhlYzYzMjA2XkEyXkFqcGc@._V1_.jpg','/myhero.html','2018','Horror','6.6'],
    [33,'Pokemon','https://m.media-amazon.com/images/M/MV5BMzE0ZDU1MzQtNTNlYS00YjNlLWE2ODktZmFmNDYzMTBlZTBmXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/pokemoon.html','2018','Horror','6.6'],
    [34,'Dragon Ball Super','https://m.media-amazon.com/images/M/MV5BYTgyMzA5MjEtNDY3Ny00ZDkyLWJhYzEtYzI2Nzk5Mzc3ZDk1XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/dragonball.html','2018','Horror','6.6'],
    [22,'Doctor Who','https://upload.wikimedia.org/wikipedia/tr/4/43/Doctor_Who_Series_14.jpg','https://playnetflixcloud.ct.ws/who.html','2019','Crime','7.8'],
    [23,'Star Trek','https://m.media-amazon.com/images/M/MV5BOWY1Y2ZlNzctMzIwMi00NTM3LWJiNDUtMTZmYWY0Y2NmZmE2XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/startrekk.php','2019','Drama','7.9'],
    [35,'Futurama','https://m.media-amazon.com/images/M/MV5BNjYxNDgxM2MtYzNmNi00ODYwLWI0ZmEtZDM3M2QwZGQ3MWI3XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/futurama.html','2019','Drama','7.9'],
    [36,'Sonic Prime','https://m.media-amazon.com/images/M/MV5BMDA3ZTY0MmQtMjc5YS00ODdkLWIxNDEtNjg4MTdmNGIzNjI4XkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/sonicprime.html','2019','Drama','7.9'],
    [24,'Regular Show','https://m.media-amazon.com/images/M/MV5BNDJlMGI1MDYtZDM0MS00NDYzLWIyMmUtZTY5MjY3MzJiN2QwXkEyXkFqcGc@._V1_.jpg','/regularshow.html','2018','Drama','7.7'],
    [27,'Bob Burgers','https://m.media-amazon.com/images/M/MV5BZWQ1NGE4YjgtOGJjZS00OTZjLWI0MGUtMDUxYjY2M2E4MjNjXkEyXkFqcGc@._V1_FMjpg_UX1000_.jpg','/bobs.php','2018','Drama','7.7'],
  ];
  foreach($movies as $t):
    $id=$t[0];$title=$t[1];$img=$t[2];$url=$t[3];$year=$t[4];$genre=$t[5];$rating=$t[6];
    $isFav = in_array(strval($id), $FAV_IDS);
  ?>
  <div class="mc focusable">
    <img src="<?=esc($img)?>" alt="<?=esc($title)?>" loading="lazy">
    <div class="co">
      <div class="ct"><?=esc($title)?></div>
      <div class="cm"><span><?=esc($year)?></span><span>•</span><span><?=esc($genre)?></span><span class="cr">★ <?=esc($rating)?></span></div>
      <div class="ca">
        <button class="cb cb-p" onclick="playContent(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')">▶ İzle</button>
        <button class="cb cb-f<?=$isFav?' active':''?>" data-id="<?=$id?>" onclick="toggleFav(this,<?=$id?>,'<?=jStr($title)?>','<?=jStr($img)?>','<?=jStr($url)?>','<?=jStr($year)?>','<?=jStr($genre)?>','<?=jStr($rating)?>')"><?=$isFav?'✓':'+'?></button>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- KOLEKSİYONLAR -->
<section class="sec">
  <div class="sec-hdr"><div class="sec-title">📦 Koleksiyonlar</div></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/06921a43bb9cadd695ac8f015f474755/LIVE%20TV.png" alt="Belgesel" loading="lazy"><div class="co"><div class="ct">🎥 Belgesel</div><div class="ca"><button class="cb cb-p" onclick="window.open('/livetv','_blank')">▶ İzle</button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/6eea4d43f99883b58f6ccc1365b0d59a/LIVE%20TV%20%281%29.png" alt="Dizi" loading="lazy"><div class="co"><div class="ct">📺 Dizi</div><div class="ca"><button class="cb cb-p" onclick="window.open('/livetv','_blank')">▶ İzle</button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/4e69a92222a3fd7571604f6cf0c86eca/LIVE%20TV%20%282%29.png" alt="Çocuk" loading="lazy"><div class="co"><div class="ct">🧸 Çocuk</div><div class="ca"><button class="cb cb-p" onclick="window.open('/livetv','_blank')">▶ İzle</button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/df7d32b61f3d688adbfe91bd4464dc62/NA%20%281%29.png" alt="FireSERIES HD" loading="lazy"><div class="co"><div class="ct">🔥 FireSERIES HD</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/teve.php','_blank')">▶ İzle</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<!-- TV KANALLARI -->
<section class="sec">
  <div class="sec-hdr"><div class="sec-title">📡 TV Kanalları</div></div>
  <div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl">
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/3c864b05720e1bfb474578fb2416a4c1/NA.png" alt="Belgesel TV" loading="lazy"><div class="co"><div class="ct">🌍 Belgesel TV</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/doc.php','_blank')">▶ İzle</button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/d7a87ad8fb5d89a1c396da2eb5d87ec0/NA.png" alt="Central Comedy" loading="lazy"><div class="co"><div class="ct">😂 Central Comedy</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/dizitv.php','_blank')">▶ İzle</button></div></div></div>
    <div class="mc focusable"><img src="https://yourfiles.cloud/uploads/57e304b470809081357c18300943b255/Ads%C4%B1z%20tasar%C4%B1m.png" alt="ÇocukTV" loading="lazy"><div class="co"><div class="ct">🎠 ÇocukTV</div><div class="ca"><button class="cb cb-p" onclick="window.open('http://playcloudmovie0.ct.ws/cocuk.php','_blank')">▶ İzle</button></div></div></div>
  </div></div><button class="sl-arr r">❯</button></div>
</section>

<div class="sec-div"></div>

<!-- LİSTEM -->
<section class="sec" id="favorites">
  <div class="sec-hdr"><div class="sec-title">❤️ Listem <span class="badge">Kayıtlı</span></div></div>
  <div id="fav-sec">
    <?php if(!$HAS_DB): ?>
    <div class="empty-fav">
      <div class="icon">🔐</div>
      <h3><?= esc($STR['login_req']) ?></h3>
      <p><?= esc($STR['login_msg']) ?></p>
    </div>
    <?php else: ?>
    <div class="empty-fav">
      <div class="icon">📋</div>
      <h3><?= esc($STR['list_empty']) ?></h3>
      <p><?= esc($STR['list_empty_msg']) ?></p>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- TAKVİM -->
<section class="sec cal-sec" id="calendar">
  <div class="cal-hdr">
    <div class="cal-title"><span>📅</span> Bölüm Takvimi</div>
    <div style="display:flex;align-items:center;gap:14px;flex-wrap:wrap;">
      <div class="caltabs">
        <button class="caltab active" onclick="calF('all',this)">Tümü</button>
        <button class="caltab" onclick="calF('today',this)">Bugün</button>
        <button class="caltab" onclick="calF('week',this)">Bu Hafta</button>
        <button class="caltab" onclick="calF('upcoming',this)">Yakında</button>
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
        <th>Tarih</th>
        <th>Dizi / Film</th>
        <th>Bölüm</th>
        <th>Platform</th>
      </tr></thead>
      <tbody id="cal-body"></tbody>
    </table>
  </div>
</section>

</main>

<button class="and-btn" id="andBtn" onclick="toggleTV()">
  <span>📺</span><span id="and-lbl">Android Modu</span>
</button>

<!-- MOBİL BOTTOM NAV -->
<nav class="mob-nav" id="mobNav" aria-label="Ana Navigasyon">
  <div class="mob-nav-inner">
    <a href="#" class="mob-ni mob-active" id="mni-home" onclick="mobSetActive(this)" aria-label="Ana Sayfa">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><path d="M3 9.5L12 3l9 6.5V20a1 1 0 01-1 1H5a1 1 0 01-1-1V9.5z"/><polyline points="9 21 9 12 15 12 15 21"/></svg></div>
      <span class="mob-ni-lbl">Ana Sayfa</span><div class="mob-ni-ripple"></div>
    </a>
    <a href="/gl.php" class="mob-ni" id="mni-shorts" onclick="mobSetActive(this)" aria-label="Shorts">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="4" y="2" width="16" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><polygon points="10 15.5 14 13 10 10.5 10 15.5" fill="currentColor" stroke="none"/></svg></div>
      <span class="mob-ni-lbl">Shorts</span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#series" class="mob-ni" id="mni-series" onclick="mobSetActive(this)" aria-label="Diziler">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/><line x1="7" y1="8" x2="7" y2="12"/><polygon points="10 8 16 10 10 12 10 8" fill="currentColor" stroke="none"/></svg></div>
      <span class="mob-ni-lbl">Diziler</span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#movies" class="mob-ni" id="mni-movies" onclick="mobSetActive(this)" aria-label="Filmler">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><line x1="7" y1="4" x2="7" y2="20"/><line x1="17" y1="4" x2="17" y2="20"/><line x1="2" y1="9" x2="22" y2="9"/><line x1="2" y1="15" x2="22" y2="15"/></svg></div>
      <span class="mob-ni-lbl">Filmler</span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#favorites" class="mob-ni" id="mni-fav" onclick="mobSetActive(this)" aria-label="Listem">
      <div class="mob-ni-ico">
        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        <span class="mob-ni-badge" id="mob-fav-cnt" style="display:none">0</span>
      </div>
      <span class="mob-ni-lbl">Listem</span><div class="mob-ni-ripple"></div>
    </a>
    <a href="#calendar" class="mob-ni" id="mni-cal" onclick="mobSetActive(this)" aria-label="Takvim">
      <div class="mob-ni-ico"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
      <span class="mob-ni-lbl">Takvim</span><div class="mob-ni-ripple"></div>
    </a>
  </div>
</nav>

</div><!-- /main-app -->
<div class="toast" id="toast"></div>
<script src="https://pl28792751.effectivegatecpm.com/a8/a1/ca/a8a1cad4d480e9f5f2c80b6d537e4318.js"></script>

<script>
// ─── PHP → JS ──────────────────────────────────────────────
const FAV_IDS   = <?= json_encode(array_map('strval', $FAV_IDS)) ?>;
const PHP_CONTINUE = <?= json_encode($PHP_CONTINUE) ?>;
const HAS_DB    = <?= $HAS_DB ? 'true' : 'false' ?>;
const LANG      = "<?= esc($LANG) ?>";
const THEME     = "<?= esc($THEME) ?>";
const STR = <?= json_encode($STR, JSON_UNESCAPED_UNICODE) ?>;
const TRM = ["Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık"];
const TRD = ["Paz","Pzt","Sal","Çar","Per","Cum","Cmt"];

const LS_FAV_KEY = 'wox_favs';
const LS_CW_KEY  = 'wox_cw';
function lsGet(k){try{return JSON.parse(localStorage.getItem(k)||'null');}catch(e){return null;}}
function lsSet(k,v){try{localStorage.setItem(k,JSON.stringify(v));}catch(e){}}

if(!HAS_DB){const lf=lsGet(LS_FAV_KEY)||[];lf.forEach(id=>FAV_IDS.push(String(id)));}

// ─── STAR PARTICLE FUN ──────────────────────────────────
function spawnStar(){
  const emojis=['⭐','🌟','✨','💫','🎉','🎊','🌈','❤️','💜','💛'];
  const el=document.createElement('div');
  el.className='star-particle';
  el.textContent=emojis[Math.floor(Math.random()*emojis.length)];
  el.style.left=Math.random()*90+'vw';
  el.style.top='-60px';
  const dur=(Math.random()*4+3)+'s';
  el.style.animation=`star-fall ${dur} linear both`;
  document.body.appendChild(el);
  setTimeout(()=>el.remove(),(parseFloat(dur)*1000)+200);
}
// Spawn stars occasionally
setInterval(()=>{if(Math.random()<0.4)spawnStar();},3000);

// ─── LOADING ────────────────────────────────────────────────
window.addEventListener('load',()=>{
  spawnStar();spawnStar();
  setTimeout(()=>{
    document.getElementById('ls').classList.add('hide');
    const app=document.getElementById('main-app');
    if(app)setTimeout(()=>{app.style.opacity='1';},100);
    if(!HAS_DB){
      const lsCW=lsGet(LS_CW_KEY)||[];
      if(lsCW.length){lsCW.forEach(item=>cwAddCard(item.id,item.title,item.img,item.url,item.year,item.genre,item.rating,item.progress||5,true));}
    }
  },900);
});

// ─── SCROLL HEADER ──────────────────────────────────────────
window.addEventListener('scroll',()=>{document.getElementById('hdr')?.classList.toggle('scrolled',scrollY>40);},{passive:true});

// ─── SLIDER ─────────────────────────────────────────────────
function initSlider(c){
  const sl=c.querySelector('.sl');if(!sl)return;
  const lBtn=c.querySelector('.sl-arr.l'),rBtn=c.querySelector('.sl-arr.r');
  const isCW=c.closest('#continue-watching')!==null;
  const cW=isCW?210:(parseInt(getComputedStyle(document.documentElement).getPropertyValue('--card-w'))||172);
  const gap=parseInt(getComputedStyle(document.documentElement).getPropertyValue('--gap'))||12;
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

// ─── CAST ───────────────────────────────────────────────────
let castSession=null;
const castBtn=document.getElementById('castBtn');
function toggleCast(){
  if(typeof cast==='undefined'||!cast.framework){
    if(navigator.share){navigator.share({title:'WOXPLUS Kids',url:window.location.href}).catch(()=>{});showToast(STR.cast_started);}
    else{showToast(STR.cast_unavail);}
    return;
  }
  const ctx=cast.framework.CastContext.getInstance();
  if(castSession){ctx.endCurrentSession(true);castSession=null;castBtn.classList.remove('casting');showToast(STR.cast_stopped);}
  else{ctx.requestSession().then(()=>{castSession=ctx.getCurrentSession();castBtn.classList.add('casting');showToast(STR.cast_started);}).catch(()=>{showToast(STR.cast_unavail);});}
}
(function(){const s=document.createElement('script');s.src='https://www.gstatic.com/cv/js/sender/v1/cast_sender.js?loadCastFramework=1';s.async=true;s.onload=()=>{if(window.__onGCastApiAvailable)window.__onGCastApiAvailable(true);};document.head.appendChild(s);})();
window['__onGCastApiAvailable']=function(ok){if(ok&&cast&&cast.framework){cast.framework.CastContext.getInstance().setOptions({receiverApplicationId:chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID,autoJoinPolicy:chrome.cast.AutoJoinPolicy.ORIGIN_SCOPED});}};

// ─── SETTINGS ───────────────────────────────────────────────
let pendingTheme=THEME,pendingLang=LANG;
function openSettings(){document.getElementById('settingsOverlay').classList.add('open');}
function closeSettings(){document.getElementById('settingsOverlay').classList.remove('open');}
function selectOpt(btn,type){
  btn.closest('.settings-opts').querySelectorAll('.settings-opt').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  if(type==='theme')pendingTheme=btn.dataset.val;
  if(type==='lang')pendingLang=btn.dataset.val;
}
function saveSettings(){
  const exp=new Date(Date.now()+365*24*3600*1000).toUTCString();
  document.cookie='wox_theme='+pendingTheme+';path=/;expires='+exp;
  document.cookie='wox_lang='+pendingLang+';path=/;expires='+exp;
  showToast(STR.settings_saved);closeSettings();
  setTimeout(()=>window.location.reload(),700);
}
document.addEventListener('keydown',e=>{if(e.key==='Escape')closeSettings();});

// ─── CONTINUE WATCHING ──────────────────────────────────────
function cwPlay(e,mid,url){
  e.stopPropagation();window.open(url,'_blank');
  const card=document.querySelector(`.cw-card[data-cw-id="${mid}"]`);
  if(card){
    const bar=card.querySelector('.cw-prog-bar'),lbl=card.querySelector('.cw-prog-label');
    const newP=Math.min(99,parseInt(bar.style.width||'5')+Math.floor(Math.random()*10+5));
    bar.style.width=newP+'%';if(lbl)lbl.textContent=newP+'%';
    let lsCW=lsGet(LS_CW_KEY)||[];const idx=lsCW.findIndex(x=>String(x.id)===String(mid));
    if(idx>-1){lsCW[idx].progress=newP;lsSet(LS_CW_KEY,lsCW);}
  }
}
function cwRemove(e,mid){
  e.stopPropagation();
  const card=document.querySelector(`.cw-card[data-cw-id="${mid}"]`);
  if(card){
    card.style.transition='transform .3s,opacity .3s';card.style.transform='scale(.85) translateY(-8px)';card.style.opacity='0';
    setTimeout(()=>{
      card.remove();
      const rem=document.querySelectorAll('.cw-card').length;
      document.getElementById('cw-badge').textContent=rem;
      if(rem===0)document.getElementById('continue-watching').style.display='none';
    },280);
    let lsCW2=lsGet(LS_CW_KEY)||[];lsCW2=lsCW2.filter(x=>String(x.id)!==String(mid));lsSet(LS_CW_KEY,lsCW2);
    if(!HAS_DB)return;
    const fd=new FormData();fd.append('action','remove_continue');fd.append('movie_id',mid);fetch('index.php',{method:'POST',body:fd}).catch(()=>{});
  }
}
function cwClearAll(e){
  e.preventDefault();
  const cards=document.querySelectorAll('.cw-card');if(!cards.length)return;
  if(!confirm(STR.clear_history))return;
  cards.forEach((c,i)=>{setTimeout(()=>{c.style.transition='transform .3s,opacity .3s';c.style.transform='scale(.8) translateY(-10px)';c.style.opacity='0';},i*50);});
  setTimeout(()=>{document.getElementById('continue-watching').style.display='none';lsSet(LS_CW_KEY,[]);cards.forEach(c=>{const mid=c.dataset.cwId;const fd=new FormData();fd.append('action','remove_continue');fd.append('movie_id',mid);fetch('index.php',{method:'POST',body:fd}).catch(()=>{});});},cards.length*50+300);
}
function cwAddCard(mid,title,img,url,year,genre,rating,progress,silent){
  const sec=document.getElementById('continue-watching'),sl=document.getElementById('cw-sl');
  const existing=sl.querySelector(`.cw-card[data-cw-id="${mid}"]`);if(existing)existing.remove();
  const card=document.createElement('div');card.className='cw-card';card.dataset.cwId=mid;
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
  const slC=sec.querySelector('.sl-c');if(slC)initSlider(slC);
}
function playContent(btn,mid,title,img,url,year,genre,rating){
  const progress=Math.floor(Math.random()*20+5);
  cwAddCard(mid,title,img,url,year,genre,rating,progress,false);
  window.open(url,'_blank');
  showToast('🎬 ' + STR.watching + title);
  spawnStar();spawnStar();
  let lsCW=lsGet(LS_CW_KEY)||[];
  lsCW=lsCW.filter(x=>String(x.id)!==String(mid));
  lsCW.unshift({id:mid,title,img,url,year,genre,rating,progress});
  if(lsCW.length>12)lsCW=lsCW.slice(0,12);
  lsSet(LS_CW_KEY,lsCW);
  if(!HAS_DB)return;
  const fd=new FormData();
  fd.append('action','add_continue');fd.append('movie_id',mid);fd.append('title',title);
  fd.append('img',img);fd.append('url',url);fd.append('year',year);fd.append('genre',genre);fd.append('rating',rating);fd.append('progress',progress);
  fetch('index.php',{method:'POST',body:fd}).catch(()=>{});
}

// ─── FAVORITES ──────────────────────────────────────────────
const favIds=new Set(FAV_IDS.map(String));

async function toggleFav(btn,mid,title,img,url,year,genre,rating){
  const adding=!btn.classList.contains('active');
  if(!HAS_DB){
    let lsF=lsGet(LS_FAV_KEY)||[];
    if(adding){if(!lsF.includes(String(mid)))lsF.push(String(mid));}
    else{lsF=lsF.filter(x=>x!==String(mid));}
    lsSet(LS_FAV_KEY,lsF);
    _applyFavUI(btn,mid,adding,title,img,url,year,genre,rating);return;
  }
  const fd=new FormData();fd.append('action',adding?'add_fav':'remove_fav');fd.append('movie_id',mid);
  if(adding){fd.append('title',title);fd.append('img',img);fd.append('url',url);fd.append('year',year);fd.append('genre',genre);fd.append('rating',rating);}
  try{const r=await fetch('index.php',{method:'POST',body:fd});const d=await r.json();if(!d.ok){showToast('⚠ '+d.msg);return;}_applyFavUI(btn,mid,adding,title,img,url,year,genre,rating);}
  catch(e){showToast(STR.error);}
}
function _applyFavUI(btn,mid,adding,title,img,url,year,genre,rating){
  btn.classList.toggle('active',adding);btn.textContent=adding?'✓':'+';
  document.querySelectorAll(`.cb-f[data-id="${mid}"]`).forEach(b=>{b.classList.toggle('active',adding);b.textContent=adding?'✓':'+';});
  adding?favIds.add(String(mid)):favIds.delete(String(mid));
  const cnt=favIds.size;
  document.getElementById('fav-cnt').textContent=cnt;
  const mb=document.getElementById('mob-fav-cnt');if(mb){mb.textContent=cnt;mb.style.display=cnt>0?'flex':'none';}
  showToast(adding?STR.added_list:STR.removed_list);
  if(adding){spawnStar();}
  if(adding){
    const favSec=document.getElementById('fav-sec');let favSl=document.getElementById('fav-sl');
    if(!favSl){
      favSec.innerHTML=`<div class="sl-c"><button class="sl-arr l">❮</button><div class="sl-w"><div class="sl" id="fav-sl"></div></div><button class="sl-arr r">❯</button></div>`;
      favSl=document.getElementById('fav-sl');initSlider(favSec.querySelector('.sl-c'));
    }
    const card=document.createElement('div');card.className='mc focusable';
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
      setTimeout(()=>{card.remove();if(!document.querySelector('#fav-sl .mc')){document.getElementById('fav-sec').innerHTML=`<div class="empty-fav"><div class="icon">📋</div><h3>${STR.list_empty}</h3><p>${STR.list_empty_msg}</p></div>`;}},280);
    }
  }
}

// ─── LOGOUT ─────────────────────────────────────────────────
async function doLogout(){
  const fd=new FormData();fd.append('action','logout');
  try{await fetch('index.php',{method:'POST',body:fd});}catch(e){}
  window.location.href='auth.php';
}

// ─── TOAST ──────────────────────────────────────────────────
let tTmr;
function showToast(msg){
  const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');
  clearTimeout(tTmr);tTmr=setTimeout(()=>t.classList.remove('show'),2800);
}

// ─── HELPERS ────────────────────────────────────────────────
function escHtml(s){return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');}
function escJs(s){return String(s).replace(/\\/g,'\\\\').replace(/'/g,"\\'");}

// ─── CALENDAR ───────────────────────────────────────────────
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
    const d=new Date(ep.date);const iT=d.getTime()===today.getTime(),iP=d<today;
    return `<tr style="${iP?'opacity:.4;':''}">
      <td><div class="cdc${iT?' cdt':''}"><span class="cday">${String(d.getDate()).padStart(2,'0')} ${TRM[d.getMonth()].slice(0,3)}</span><span class="cwdy">${TRD[d.getDay()]}</span></div></td>
      <td><div class="csc"><img class="cal-poster" src="${ep.img}" loading="lazy" onerror="this.style.display='none'"><div><div class="csn">${ep.show}</div><div class="csm">${STR.season} ${ep.s} • ${STR.episode_lbl} ${ep.e}</div></div></div></td>
      <td><span class="ceb${ep.isNew?' new':''}">${ep.isNew?'🆕 ':''}${ep.ep}</span></td>
      <td class="cpf"><span>${ep.plat}</span></td></tr>`;
  }).join('');
}
renderCal();

// ─── MOBILE BOTTOM NAV ──────────────────────────────────────
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

// ─── ANDROID TV ─────────────────────────────────────────────
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
