<?php
require 'db.php';
session_start();

// Token yenileme
if (isset($_GET['refresh'])) {
    header('Content-Type: application/json');
    $email = $_SESSION['email'] ?? '';
    if (!$email || !isActive($email)) {
        http_response_code(403);
        echo json_encode(['error' => 'Üyelik geçersiz']);
        exit;
    }
    $expires = time() + TOKEN_SURE;
    $sig     = hash_hmac('sha256', $email . ':' . $expires, SECRET_KEY);
    $token   = urlencode(base64_encode($email . ':' . $expires . ':' . $sig));
    echo json_encode(['token' => $token, 'expires' => $expires]);
    exit;
}

// Oturum kontrolü
if (empty($_SESSION['email'])) { header('Location: giris.php'); exit; }

$email = $_SESSION['email'];
if (!isActive($email)) { session_destroy(); header('Location: giris.php?expired=1'); exit; }

// Token üret
$expires = time() + TOKEN_SURE;
$sig     = hash_hmac('sha256', $email . ':' . $expires, SECRET_KEY);
$token   = urlencode(base64_encode($email . ':' . $expires . ':' . $sig));

// channel.php ye token ile link
$streamUrl = 'channel.php?token=' . $token;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Live TV</title>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html, body { width: 100%; height: 100%; overflow: hidden; background: #000; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; cursor: none; }
  #video { position: fixed; inset: 0; width: 100%; height: 100%; object-fit: cover; background: #000; }
  #overlay { position: fixed; inset: 0; z-index: 10; pointer-events: none; opacity: 0; transition: opacity 0.35s ease; }
  #overlay.visible { opacity: 1; pointer-events: all; }
  #overlay::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 180px; background: linear-gradient(to bottom, rgba(0,0,0,.85), transparent); pointer-events: none; }
  #overlay::after  { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 200px; background: linear-gradient(to top, rgba(0,0,0,.92), transparent); pointer-events: none; }
  #topBar { position: absolute; top: 0; left: 0; right: 0; padding: 24px 32px; display: flex; align-items: center; justify-content: space-between; z-index: 2; }
  .live-pill { display: flex; align-items: center; gap: 7px; background: rgba(229,9,20,.18); border: 1.5px solid rgba(229,9,20,.65); color: #fff; padding: 5px 13px 5px 9px; border-radius: 3px; font-size: .7rem; font-weight: 800; letter-spacing: 2.5px; text-transform: uppercase; }
  .live-dot { width: 7px; height: 7px; background: #e50914; border-radius: 50%; animation: livePulse 1.2s ease-in-out infinite; }
  @keyframes livePulse { 0%,100% { opacity:1; box-shadow:0 0 0 0 rgba(229,9,20,.8); } 50% { opacity:.5; box-shadow:0 0 0 5px rgba(229,9,20,0); } }
  .age-badge { display: flex; align-items: center; gap: 6px; border-left: 3px solid #e50914; padding: 4px 10px; background: rgba(0,0,0,.45); backdrop-filter: blur(8px); border-radius: 0 3px 3px 0; }
  .age-num { font-size: .92rem; font-weight: 800; color: #fff; }
  .age-label { font-size: .62rem; font-weight: 600; color: rgba(255,255,255,.6); text-transform: uppercase; letter-spacing: 1px; line-height: 1.3; }
  #bottomBar { position: absolute; bottom: 0; left: 0; right: 0; padding: 0 32px 30px; z-index: 2; display: flex; flex-direction: column; gap: 10px; }
  #progressWrap { height: 3px; background: rgba(255,255,255,.2); border-radius: 2px; overflow: hidden; transition: height .2s; }
  #progressWrap:hover { height: 5px; }
  #progressFill { height: 100%; width: 100%; background: #e50914; border-radius: 2px; animation: liveGlow 2.5s ease-in-out infinite; }
  @keyframes liveGlow { 0%,100% { box-shadow:none; opacity:.9; } 50% { box-shadow:0 0 10px rgba(229,9,20,.7); opacity:1; } }
  #ctrlRow { display: flex; align-items: center; gap: 6px; }
  .ctrl-btn { background: transparent; border: none; color: #fff; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 1.15rem; border-radius: 50%; transition: background .15s, transform .12s; flex-shrink: 0; }
  .ctrl-btn:hover { background: rgba(255,255,255,.15); transform: scale(1.1); }
  .ctrl-btn:active { transform: scale(.92); }
  #playBtn { font-size: 1.45rem; }
  #volWrap { display: flex; align-items: center; gap: 6px; width: 120px; flex-shrink: 0; }
  #volSlider { flex: 1; height: 3px; cursor: pointer; appearance: none; -webkit-appearance: none; background: rgba(255,255,255,.25); border-radius: 2px; outline: none; }
  #volSlider::-webkit-slider-runnable-track { background: linear-gradient(90deg, #fff var(--v,80%), rgba(255,255,255,.25) var(--v,80%)); height: 3px; border-radius: 2px; }
  #volSlider::-webkit-slider-thumb { -webkit-appearance: none; width: 13px; height: 13px; border-radius: 50%; background: #fff; margin-top: -5px; transition: transform .15s; }
  #volSlider::-webkit-slider-thumb:hover { transform: scale(1.35); }
  .spacer { flex: 1; }
  .pill-btn { background: rgba(255,255,255,.07); border: 1.5px solid rgba(255,255,255,.25); color: rgba(255,255,255,.85); border-radius: 3px; padding: 6px 14px; font-size: .7rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; transition: all .18s; white-space: nowrap; }
  .pill-btn:hover { background: rgba(255,255,255,.16); border-color: rgba(255,255,255,.55); color: #fff; }
  .pill-btn.on { background: rgba(229,9,20,.22); border-color: rgba(229,9,20,.7); color: #fff; }
  #centerPlay { position: fixed; inset: 0; z-index: 9; display: flex; align-items: center; justify-content: center; pointer-events: none; opacity: 0; transition: opacity .25s; }
  #centerPlay.show { opacity: 1; }
  #centerPlayIcon { width: 70px; height: 70px; border-radius: 50%; background: rgba(0,0,0,.6); border: 2px solid rgba(255,255,255,.65); display: flex; align-items: center; justify-content: center; font-size: 1.75rem; backdrop-filter: blur(4px); }
  #statusScreen { position: fixed; inset: 0; z-index: 20; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 20px; background: #000; transition: opacity .5s; }
  #statusScreen.hidden { opacity: 0; pointer-events: none; }
  .loader-ring { width: 46px; height: 46px; border: 3px solid rgba(229,9,20,.2); border-top-color: #e50914; border-radius: 50%; animation: spin .75s linear infinite; }
  @keyframes spin { to { transform: rotate(360deg); } }
  #statusMsg { color: rgba(255,255,255,.4); font-size: .8rem; letter-spacing: 2px; text-transform: uppercase; }
  #retryBtn { display: none; background: #e50914; border: none; color: #fff; padding: 10px 28px; border-radius: 3px; font-size: .82rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; cursor: pointer; }
  #retryBtn:hover { background: #f40612; }
  #cursorDot { position: fixed; width: 9px; height: 9px; border-radius: 50%; background: rgba(255,255,255,.7); pointer-events: none; z-index: 9999; transform: translate(-50%,-50%); }
  #userInfo { position: fixed; top: 24px; right: 16px; z-index: 30; font-size: .65rem; color: rgba(255,255,255,.25); font-family: monospace; text-align: right; }
  @media (max-width: 480px) { #topBar { padding: 16px; } #bottomBar { padding: 0 16px 20px; } .ctrl-btn { width: 36px; height: 36px; } .pill-btn { padding: 5px 10px; font-size: .64rem; } #volWrap { width: 80px; } }
</style>
</head>
<body>

<div id="cursorDot"></div>
<div id="userInfo"><?= htmlspecialchars($email) ?></div>

<div id="statusScreen">
  <div class="loader-ring"></div>
  <div id="statusMsg">Bağlanıyor…</div>
  <button id="retryBtn" onclick="initPlayer()">↺ Tekrar Dene</button>
</div>

<video id="video" playsinline autoplay muted></video>
<div id="centerPlay"><div id="centerPlayIcon">▶</div></div>

<div id="overlay">
  <div id="topBar">
    <div class="live-pill"><div class="live-dot"></div>CANLI</div>
    <div class="age-badge"><div class="age-num">13+</div><div class="age-label">Yaş<br>ve Üzeri</div></div>
  </div>
  <div id="bottomBar">
    <div id="progressWrap"><div id="progressFill"></div></div>
    <div id="ctrlRow">
      <button class="ctrl-btn" id="playBtn" onclick="togglePlay()">▶</button>
      <button class="ctrl-btn" id="muteBtn" onclick="toggleMute()">🔊</button>
      <div id="volWrap">
        <input type="range" id="volSlider" min="0" max="100" value="80" oninput="onVolume(this.value)" style="--v:80%">
      </div>
      <div class="spacer"></div>
      <button class="pill-btn" id="audioBtn" onclick="cycleAudio()">🎵 Ses</button>
      <button class="pill-btn" id="subBtn" onclick="toggleSub()">💬 Altyazı</button>
      <button class="ctrl-btn" onclick="toggleFS()">⛶</button>
    </div>
  </div>
</div>

<script>
let TOKEN      = '<?= $token ?>';
let EXPIRES    = <?= $expires ?>;
let STREAM_URL = '<?= $streamUrl ?>';

const video      = document.getElementById('video');
const overlay    = document.getElementById('overlay');
const playBtn    = document.getElementById('playBtn');
const muteBtn    = document.getElementById('muteBtn');
const volSlider  = document.getElementById('volSlider');
const centerPlay = document.getElementById('centerPlay');
const statusScr  = document.getElementById('statusScreen');
const statusMsg  = document.getElementById('statusMsg');
const subBtn     = document.getElementById('subBtn');
const audioBtn   = document.getElementById('audioBtn');
const cursorDot  = document.getElementById('cursorDot');

let hls = null, idleTimer = null, subEnabled = false, currentAudio = 0;

async function refreshToken() {
  try {
    const res  = await fetch('stream.php?refresh=1');
    const data = await res.json();
    if (data.error) {
      statusMsg.textContent = 'Üyeliğiniz sona erdi';
      document.querySelector('.loader-ring').style.display = 'none';
      statusScr.classList.remove('hidden');
      if (hls) hls.destroy();
      return;
    }
    TOKEN      = data.token;
    EXPIRES    = data.expires;
    STREAM_URL = 'channel.php?token=' + TOKEN;
  } catch(e) { console.warn('Token yenilenemedi:', e); }
}

setInterval(refreshToken, 4 * 60 * 1000);

function initPlayer() {
  document.getElementById('retryBtn').style.display = 'none';
  document.querySelector('.loader-ring').style.display = 'block';
  statusMsg.textContent = 'Bağlanıyor…';
  statusScr.classList.remove('hidden');
  if (hls) { hls.destroy(); hls = null; }

  if (Hls.isSupported()) {
    hls = new Hls({ lowLatencyMode: true, enableWorker: true });
    hls.loadSource(STREAM_URL);
    hls.attachMedia(video);
    hls.on(Hls.Events.MANIFEST_PARSED, () => { statusScr.classList.add('hidden'); video.play().catch(() => {}); });
    hls.on(Hls.Events.ERROR, (_, d) => {
      if (d.fatal) {
        statusMsg.textContent = 'Yayın yüklenemedi';
        document.querySelector('.loader-ring').style.display = 'none';
        document.getElementById('retryBtn').style.display = 'inline-block';
      }
    });
  } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
    video.src = STREAM_URL;
    video.addEventListener('loadedmetadata', () => { statusScr.classList.add('hidden'); video.play().catch(() => {}); }, { once: true });
  } else {
    statusMsg.textContent = 'HLS desteklenmiyor';
    document.querySelector('.loader-ring').style.display = 'none';
  }
}

function togglePlay() { video.paused ? video.play() : video.pause(); }
video.addEventListener('play',  () => { playBtn.textContent = '⏸'; centerPlay.classList.remove('show'); });
video.addEventListener('pause', () => { playBtn.textContent = '▶'; centerPlay.classList.add('show'); });
function toggleMute() { video.muted = !video.muted; muteBtn.textContent = video.muted ? '🔇' : '🔊'; }
function onVolume(v) { video.volume = v/100; volSlider.style.setProperty('--v', v+'%'); video.muted = (v==0); muteBtn.textContent = video.muted ? '🔇' : '🔊'; }
video.volume = 0.8;
function cycleAudio() {
  if (!hls?.audioTracks || hls.audioTracks.length < 2) return;
  currentAudio = (currentAudio + 1) % hls.audioTracks.length;
  hls.audioTrack = currentAudio;
  const t = hls.audioTracks[currentAudio];
  audioBtn.textContent = '🎵 ' + (t.name || t.lang || 'SES').toUpperCase().slice(0,10);
}
function toggleSub() {
  subEnabled = !subEnabled;
  subBtn.classList.toggle('on', subEnabled);
  subBtn.textContent = subEnabled ? '💬 Altyazı ✓' : '💬 Altyazı';
  if (hls?.subtitleTracks?.length) { hls.subtitleTrack = subEnabled ? 0 : -1; hls.subtitleDisplay = subEnabled; }
  const tt = video.textTracks;
  for (let i = 0; i < tt.length; i++)
    if (tt[i].kind === 'subtitles' || tt[i].kind === 'captions')
      tt[i].mode = subEnabled ? 'showing' : 'hidden';
}
function toggleFS() { !document.fullscreenElement ? document.documentElement.requestFullscreen?.() : document.exitFullscreen?.(); }
function showOverlay() { overlay.classList.add('visible'); clearTimeout(idleTimer); idleTimer = setTimeout(() => overlay.classList.remove('visible'), 3500); }
document.addEventListener('mousemove', e => { cursorDot.style.left = e.clientX+'px'; cursorDot.style.top = e.clientY+'px'; showOverlay(); });
document.addEventListener('touchstart', showOverlay, { passive: true });
document.addEventListener('click', showOverlay);
document.addEventListener('keydown', e => {
  if (e.key===' '||e.key==='k') { e.preventDefault(); togglePlay(); }
  if (e.key==='m') toggleMute();
  if (e.key==='f') toggleFS();
  if (e.key==='s') toggleSub();
  if (e.key==='a') cycleAudio();
  if (e.key==='ArrowUp')   onVolume(Math.min(100, video.volume*100+10));
  if (e.key==='ArrowDown') onVolume(Math.max(0,   video.volume*100-10));
  showOverlay();
});

initPlayer();
</script>
</body>
</html>
```

---

## Özet
```
giris.php → stream.php → channel.php?token=XXX → Viloud stream