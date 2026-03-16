<?php
/**
 * watch.php — WOXPLUS Ziyaretçi İstatistikleri
 * index.php ile aynı klasörde olmalı
 */

// Şifre koruması (isteğe bağlı) — değiştirmek istersen buradan
define('WATCH_PASS', ''); // Boş bırakırsan şifre gerekmez, örn: 'woxadmin123'

if (WATCH_PASS !== '') {
    $entered = $_GET['p'] ?? '';
    if ($entered !== WATCH_PASS) {
        http_response_code(403);
        die('<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Giriş</title>
        <style>*{box-sizing:border-box;margin:0;padding:0;}body{background:#080a0c;display:flex;align-items:center;justify-content:center;min-height:100vh;font-family:sans-serif;}
        .box{background:#0f1115;border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:32px;text-align:center;width:300px;}
        h2{color:#f0f2f5;margin-bottom:20px;font-size:1rem;letter-spacing:.1em;}
        input{width:100%;padding:10px 14px;background:#13161c;border:1px solid rgba(255,255,255,.1);border-radius:8px;color:#f0f2f5;font-size:.9rem;margin-bottom:12px;}
        button{width:100%;padding:10px;background:#f0f2f5;color:#080a0c;border:none;border-radius:8px;font-weight:700;cursor:pointer;}
        </style></head><body><div class="box"><h2>🔒 Erişim Şifresi</h2>
        <form method="get"><input type="password" name="p" placeholder="Şifre girin..."><button>Giriş</button></form></div></body></html>');
    }
}

define('VISITORS_FILE', __DIR__ . '/wox_visitors.json');

// Veriyi oku
$data = [];
if (file_exists(VISITORS_FILE)) {
    $raw = @file_get_contents(VISITORS_FILE);
    if ($raw) $data = json_decode($raw, true) ?: [];
}

$uniqueTotal  = $data['unique_count']  ?? 0;
$totalHits    = $data['total_hits']    ?? 0;
$dailyData    = $data['daily']         ?? [];
$hourlyData   = $data['hourly']        ?? [];

// Bugünün istatistikleri
$today        = date('Y-m-d');
$todayUnique  = $dailyData[$today]['unique'] ?? 0;
$todayHits    = $dailyData[$today]['hits']   ?? 0;

// Dünkü
$yesterday    = date('Y-m-d', strtotime('-1 day'));
$yestUnique   = $dailyData[$yesterday]['unique'] ?? 0;

// Bu haftanın toplam benzersiz
$weekUnique = 0;
for ($i = 0; $i < 7; $i++) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $weekUnique += $dailyData[$d]['unique'] ?? 0;
}

// Son 30 günün grafiği için veri
$chartLabels = [];
$chartUnique = [];
$chartHits   = [];
for ($i = 29; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i days"));
    $chartLabels[] = date('d.m', strtotime($d));
    $chartUnique[] = $dailyData[$d]['unique'] ?? 0;
    $chartHits[]   = $dailyData[$d]['hits']   ?? 0;
}

// Saatlik bugün grafiği
$hourLabels = [];
$hourValues = [];
for ($h = 0; $h < 24; $h++) {
    $hourLabels[] = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00';
    $key = $today . '_' . str_pad($h, 2, '0', STR_PAD_LEFT);
    $hourValues[] = $hourlyData[$key] ?? 0;
}

// Büyüme oranı
$growth = 0;
if ($yestUnique > 0) {
    $growth = round((($todayUnique - $yestUnique) / $yestUnique) * 100, 1);
}

// Maksimum günlük değer (bar chart için)
$maxDaily = max(array_merge([1], $chartUnique));
$maxHour  = max(array_merge([1], $hourValues));
?>
<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>WOXPLUS — Ziyaretçi İstatistikleri</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
:root{
  --bg:#080a0c;--bg2:#0f1115;--bg3:#13161c;
  --txt:#f0f2f5;--txt2:#8a9099;--txt3:#3e4550;
  --border:rgba(255,255,255,0.07);--border2:rgba(255,255,255,0.13);
  --accent:#ffffff;--silver:#c8cdd6;
  --green:#4ade80;--red:#f87171;--yellow:#fbbf24;--blue:#60a5fa;
  --r:12px;--ease:cubic-bezier(.4,0,.2,1);
}

html{scroll-behavior:smooth;}
body{
  background:var(--bg);color:var(--txt);
  font-family:'Syne',system-ui,sans-serif;
  min-height:100vh;overflow-x:hidden;
  -webkit-font-smoothing:antialiased;
}

/* Mesh arka plan */
body::before{
  content:'';position:fixed;inset:0;z-index:0;pointer-events:none;
  background:
    radial-gradient(ellipse 60% 40% at 10% 10%, rgba(255,255,255,0.02) 0%, transparent 60%),
    radial-gradient(ellipse 50% 35% at 90% 85%, rgba(100,160,255,0.015) 0%, transparent 55%);
}

/* Noise */
body::after{
  content:'';position:fixed;inset:0;z-index:0;pointer-events:none;opacity:.02;
  background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  background-size:128px;
}

.wrap{position:relative;z-index:1;max-width:1100px;margin:0 auto;padding:40px 24px 80px;}

/* HEADER */
.page-hdr{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:48px;padding-bottom:24px;
  border-bottom:1px solid var(--border);
  flex-wrap:wrap;gap:16px;
}
.logo-area{display:flex;align-items:center;gap:14px;}
.logo-img{height:36px;width:auto;object-fit:contain;}
.page-title{
  font-family:'Bebas Neue',sans-serif;
  font-size:1.8rem;letter-spacing:.06em;
  background:linear-gradient(135deg,#fff 0%,#6a7280 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.live-badge{
  display:flex;align-items:center;gap:6px;
  background:rgba(74,222,128,0.08);border:1px solid rgba(74,222,128,0.2);
  color:var(--green);padding:5px 13px;border-radius:20px;
  font-size:.65rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;
  font-family:'DM Mono',monospace;
}
.live-dot{
  width:7px;height:7px;border-radius:50%;background:var(--green);
  animation:pulse 1.8s ease-in-out infinite;
}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1);}50%{opacity:.4;transform:scale(.8);}}

.back-btn{
  background:rgba(255,255,255,.04);border:1px solid var(--border2);
  color:var(--txt2);padding:7px 16px;border-radius:8px;
  font-size:.68rem;font-weight:700;text-decoration:none;
  font-family:'DM Mono',monospace;letter-spacing:.06em;
  transition:.2s;display:inline-flex;align-items:center;gap:6px;
}
.back-btn:hover{background:rgba(255,255,255,.08);color:var(--txt);}

/* STAT CARDS */
.stats-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:14px;margin-bottom:36px;
}
.stat-card{
  background:var(--bg2);border:1px solid var(--border);
  border-radius:var(--r);padding:22px 24px;
  position:relative;overflow:hidden;
  animation:fadeUp .5s var(--ease) both;
  transition:border-color .2s,box-shadow .2s;
}
.stat-card:hover{border-color:var(--border2);box-shadow:0 8px 32px rgba(0,0,0,.5);}
.stat-card::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,.02) 0%,transparent 60%);
  pointer-events:none;
}
.stat-card:nth-child(1){animation-delay:.0s;}
.stat-card:nth-child(2){animation-delay:.08s;}
.stat-card:nth-child(3){animation-delay:.16s;}
.stat-card:nth-child(4){animation-delay:.24s;}

@keyframes fadeUp{from{opacity:0;transform:translateY(20px);}to{opacity:1;transform:translateY(0);}}

.stat-icon{font-size:1.4rem;margin-bottom:12px;display:block;}
.stat-label{
  font-size:.6rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;
  color:var(--txt3);font-family:'DM Mono',monospace;margin-bottom:8px;
}
.stat-value{
  font-family:'Bebas Neue',sans-serif;font-size:3rem;
  line-height:1;letter-spacing:.02em;
  background:linear-gradient(135deg,#fff 0%,#8a9099 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.stat-value.green{background:linear-gradient(135deg,var(--green) 0%,#166534 100%);-webkit-background-clip:text;background-clip:text;}
.stat-value.blue{background:linear-gradient(135deg,var(--blue) 0%,#1e40af 100%);-webkit-background-clip:text;background-clip:text;}
.stat-value.yellow{background:linear-gradient(135deg,var(--yellow) 0%,#92400e 100%);-webkit-background-clip:text;background-clip:text;}

.stat-sub{
  font-size:.65rem;color:var(--txt2);margin-top:6px;
  font-family:'DM Mono',monospace;display:flex;align-items:center;gap:5px;
}
.trend-up{color:var(--green);}
.trend-down{color:var(--red);}
.trend-neutral{color:var(--txt3);}

/* SECTION */
.sec-title{
  font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:var(--silver);font-family:'DM Mono',monospace;
  margin-bottom:16px;display:flex;align-items:center;gap:10px;
}
.sec-title::after{content:'';flex:1;height:1px;background:var(--border);}

/* CHART AREA */
.chart-wrap{
  background:var(--bg2);border:1px solid var(--border);
  border-radius:var(--r);padding:24px;margin-bottom:20px;
  animation:fadeUp .5s var(--ease) .3s both;
}
.chart-inner{
  display:flex;align-items:flex-end;gap:4px;
  height:160px;overflow-x:auto;overflow-y:hidden;
  scrollbar-width:none;padding-bottom:2px;
}
.chart-inner::-webkit-scrollbar{display:none;}
.bar-col{
  display:flex;flex-direction:column;align-items:center;
  gap:4px;flex:0 0 auto;min-width:0;
}
.bar-wrap{
  width:100%;display:flex;flex-direction:column;
  justify-content:flex-end;height:130px;
}
.bar{
  border-radius:3px 3px 0 0;width:26px;
  transition:height .4s var(--ease),opacity .2s;
  cursor:pointer;position:relative;min-height:2px;
}
.bar-u{background:linear-gradient(to top,rgba(255,255,255,.15),rgba(255,255,255,.4));}
.bar-h{background:linear-gradient(to top,rgba(96,165,250,.2),rgba(96,165,250,.6));width:22px;}
.bar:hover{opacity:.75;}
.bar-lbl{
  font-size:.48rem;color:var(--txt3);font-family:'DM Mono',monospace;
  white-space:nowrap;transform:rotate(-45deg);
  transform-origin:center;margin-top:2px;
}

/* HOURLY CHART */
.hour-chart{
  display:flex;align-items:flex-end;gap:3px;
  height:100px;overflow-x:auto;overflow-y:hidden;
  scrollbar-width:none;
}
.hour-chart::-webkit-scrollbar{display:none;}
.h-bar{
  flex:0 0 auto;width:28px;
  border-radius:3px 3px 0 0;min-height:2px;
  background:linear-gradient(to top,rgba(251,191,36,.15),rgba(251,191,36,.5));
  transition:opacity .2s;cursor:pointer;
  position:relative;
}
.h-bar:hover{opacity:.7;}
.h-bar-lbl{
  font-size:.45rem;color:var(--txt3);font-family:'DM Mono',monospace;
  text-align:center;margin-top:4px;
}

/* TABLE */
.table-wrap{
  background:var(--bg2);border:1px solid var(--border);
  border-radius:var(--r);overflow:hidden;margin-bottom:20px;
  animation:fadeUp .5s var(--ease) .4s both;
}
table{width:100%;border-collapse:collapse;}
th{
  padding:11px 18px;font-size:.58rem;font-weight:700;
  letter-spacing:.1em;text-transform:uppercase;
  color:var(--txt3);font-family:'DM Mono',monospace;
  border-bottom:1px solid var(--border);text-align:left;
  background:rgba(255,255,255,.015);
}
td{
  padding:10px 18px;border-bottom:1px solid rgba(255,255,255,.025);
  font-size:.78rem;vertical-align:middle;
}
tr:last-child td{border-bottom:none;}
tr:hover td{background:rgba(255,255,255,.02);}
.td-date{font-family:'DM Mono',monospace;color:var(--txt2);font-size:.72rem;}
.td-num{font-family:'Bebas Neue',sans-serif;font-size:1.2rem;letter-spacing:.04em;}
.td-bar{
  height:6px;border-radius:3px;
  background:linear-gradient(90deg,rgba(255,255,255,.5),rgba(255,255,255,.1));
  max-width:200px;
}
.today-row td{background:rgba(255,255,255,.025);}
.today-badge{
  display:inline-block;background:rgba(255,255,255,.06);
  border:1px solid var(--border2);color:var(--txt2);
  padding:1px 7px;border-radius:10px;font-size:.55rem;
  font-family:'DM Mono',monospace;margin-left:6px;letter-spacing:.06em;
}

/* FOOTER */
.page-footer{
  margin-top:48px;padding-top:20px;border-top:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;
}
.footer-txt{font-size:.6rem;color:var(--txt3);font-family:'DM Mono',monospace;letter-spacing:.06em;}
.refresh-btn{
  background:rgba(255,255,255,.04);border:1px solid var(--border);
  color:var(--txt2);padding:6px 14px;border-radius:7px;
  font-size:.65rem;font-weight:700;cursor:pointer;
  font-family:'DM Mono',monospace;letter-spacing:.05em;transition:.2s;
}
.refresh-btn:hover{background:rgba(255,255,255,.08);color:var(--txt);}

/* RESPONSIVE */
@media(max-width:600px){
  .wrap{padding:24px 16px 60px;}
  .page-hdr{margin-bottom:28px;}
  .stat-value{font-size:2.4rem;}
  .bar{width:18px;}.bar-h{width:16px;}
  .h-bar{width:20px;}
}

/* TOOLTIP */
.tooltip{
  position:absolute;bottom:calc(100% + 6px);left:50%;transform:translateX(-50%);
  background:rgba(8,10,12,.95);border:1px solid var(--border2);
  color:var(--silver);padding:4px 9px;border-radius:5px;
  font-size:.6rem;font-family:'DM Mono',monospace;white-space:nowrap;
  pointer-events:none;opacity:0;transition:opacity .15s;z-index:10;
}
.bar:hover .tooltip,.h-bar:hover .tooltip{opacity:1;}
</style>
</head>
<body>
<div class="wrap">

  <!-- HEADER -->
  <div class="page-hdr">
    <div class="logo-area">
      <img class="logo-img" src="https://yourfiles.cloud/uploads/d4380759d9fbe11bdf5c47e65f91921c/%2B-removebg-preview.png" alt="WOXPLUS" onerror="this.style.display='none'">
      <div class="page-title">Ziyaretçi İstatistikleri</div>
    </div>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
      <div class="live-badge"><div class="live-dot"></div>CANLI</div>
      <a href="index.php" class="back-btn">← Ana Sayfa</a>
    </div>
  </div>

  <!-- STAT CARDS -->
  <div class="stats-grid">

    <div class="stat-card">
      <span class="stat-icon">👥</span>
      <div class="stat-label">Toplam Benzersiz Ziyaretçi</div>
      <div class="stat-value"><?= number_format($uniqueTotal) ?></div>
      <div class="stat-sub">Tüm zamanların toplamı</div>
    </div>

    <div class="stat-card">
      <span class="stat-icon">📅</span>
      <div class="stat-label">Bugün Benzersiz</div>
      <div class="stat-value green"><?= number_format($todayUnique) ?></div>
      <div class="stat-sub">
        <?php if ($growth > 0): ?>
          <span class="trend-up">↑ +<?= $growth ?>%</span> dünden fazla
        <?php elseif ($growth < 0): ?>
          <span class="trend-down">↓ <?= $growth ?>%</span> dünden az
        <?php else: ?>
          <span class="trend-neutral">— Dünle aynı</span>
        <?php endif; ?>
      </div>
    </div>

    <div class="stat-card">
      <span class="stat-icon">⚡</span>
      <div class="stat-label">Bugün Toplam İstek</div>
      <div class="stat-value blue"><?= number_format($todayHits) ?></div>
      <div class="stat-sub">Sayfa yüklemeleri dahil</div>
    </div>

    <div class="stat-card">
      <span class="stat-icon">📊</span>
      <div class="stat-label">Bu Hafta Benzersiz</div>
      <div class="stat-value yellow"><?= number_format($weekUnique) ?></div>
      <div class="stat-sub">Son 7 gün</div>
    </div>

  </div>

  <!-- 30 GÜNLÜK GRAFIK -->
  <div class="sec-title">📈 Son 30 Gün — Benzersiz Ziyaretçi</div>
  <div class="chart-wrap">
    <div class="chart-inner" id="mainChart">
      <?php foreach ($chartLabels as $i => $lbl): 
        $h = $maxDaily > 0 ? round(($chartUnique[$i] / $maxDaily) * 128) : 2;
        $h = max(2, $h);
        $isToday = ($i === 29);
      ?>
      <div class="bar-col">
        <div class="bar-wrap">
          <div class="bar bar-u" style="height:<?= $h ?>px;<?= $isToday ? 'opacity:1;box-shadow:0 0 8px rgba(255,255,255,.2);' : '' ?>">
            <div class="tooltip"><?= $lbl ?>: <?= $chartUnique[$i] ?> kişi</div>
          </div>
        </div>
        <div class="bar-lbl"><?= $lbl ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- SAATLİK GRAFİK -->
  <div class="sec-title">🕐 Bugünkü Saatlik İstekler</div>
  <div class="chart-wrap">
    <div class="hour-chart">
      <?php foreach ($hourLabels as $h => $lbl): 
        $hh = $maxHour > 0 ? round(($hourValues[$h] / $maxHour) * 88) : 2;
        $hh = max(2, $hh);
        $currentHour = (int)date('H');
        $isNow = ($h === $currentHour);
      ?>
      <div style="display:flex;flex-direction:column;align-items:center;gap:3px;flex:0 0 auto;">
        <div class="h-bar" style="height:<?= $hh ?>px;<?= $isNow ? 'opacity:1;box-shadow:0 0 6px rgba(251,191,36,.3);' : 'opacity:.7;' ?>">
          <div class="tooltip"><?= $lbl ?>: <?= $hourValues[$h] ?></div>
        </div>
        <div class="h-bar-lbl"><?= str_pad($h, 2, '0', STR_PAD_LEFT) ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- GÜNLÜK DETAY TABLO -->
  <div class="sec-title">📋 Günlük Detay (Son 14 Gün)</div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Tarih</th>
          <th>Benzersiz Ziyaretçi</th>
          <th>Toplam İstek</th>
          <th>Grafik</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $maxRow = 1;
        for ($i = 0; $i < 14; $i++) {
          $d = date('Y-m-d', strtotime("-$i days"));
          $u = $dailyData[$d]['unique'] ?? 0;
          if ($u > $maxRow) $maxRow = $u;
        }
        for ($i = 0; $i < 14; $i++):
          $d = date('Y-m-d', strtotime("-$i days"));
          $u = $dailyData[$d]['unique'] ?? 0;
          $hits = $dailyData[$d]['hits'] ?? 0;
          $barW = $maxRow > 0 ? round(($u / $maxRow) * 100) : 0;
          $trClass = ($i === 0) ? 'today-row' : '';
          $dayName = ['Paz','Pzt','Sal','Çar','Per','Cum','Cmt'][date('w', strtotime($d))];
        ?>
        <tr class="<?= $trClass ?>">
          <td class="td-date">
            <?= date('d.m.Y', strtotime($d)) ?> <small style="color:var(--txt3)"><?= $dayName ?></small>
            <?php if ($i === 0): ?><span class="today-badge">BUGÜN</span><?php endif; ?>
          </td>
          <td><span class="td-num"><?= number_format($u) ?></span> <small style="color:var(--txt3);font-size:.6rem;font-family:'DM Mono',monospace">kişi</small></td>
          <td><span style="color:var(--txt2);font-family:'DM Mono',monospace;font-size:.78rem"><?= number_format($hits) ?></span></td>
          <td><div class="td-bar" style="width:<?= $barW ?>%;"></div></td>
        </tr>
        <?php endfor; ?>
      </tbody>
    </table>
  </div>

  <!-- FOOTER -->
  <div class="page-footer">
    <div class="footer-txt">
      Son güncelleme: <?= date('d.m.Y H:i:s') ?> •
      Veri dosyası: <?= file_exists(VISITORS_FILE) ? round(filesize(VISITORS_FILE)/1024, 1).' KB' : 'Yok' ?>
    </div>
    <button class="refresh-btn" onclick="location.reload()">↻ Yenile</button>
  </div>

</div>

<script>
// Grafikleri sağ tarafa (bugüne) kaydır
document.getElementById('mainChart').scrollLeft = 99999;
</script>
</body>
</html>
