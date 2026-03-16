<?php
/**
 * tracker.php — WOXPLUS Ziyaretçi Takip Sistemi
 * Kullanım: index.php'nin en başına <?php include 'tracker.php'; ?> ekleyin
 *
 * ÖNEMLİ: Hiçbir veri silinmez. Her IP kalıcı olarak kaydedilir.
 * Aynı IP bir daha girerse unique_count artmaz (tek seferlik benzersiz sayım).
 */

define('VISITORS_FILE', __DIR__ . '/wox_visitors.json');

function wox_get_real_ip(): string {
    $keys = [
        'HTTP_CF_CONNECTING_IP',   // Cloudflare
        'HTTP_X_FORWARDED_FOR',    // Proxy
        'HTTP_X_REAL_IP',          // Nginx proxy
        'REMOTE_ADDR'              // Direkt bağlantı
    ];
    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            $ip = trim(explode(',', $_SERVER[$key])[0]);
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
    return 'unknown';
}

function wox_track_visitor(): void {
    $ip   = wox_get_real_ip();
    $now  = time();
    $hash = md5($ip); // IP'yi hash'le (gizlilik için)

    // Mevcut veriyi oku
    $data = [];
    if (file_exists(VISITORS_FILE)) {
        $raw = @file_get_contents(VISITORS_FILE);
        if ($raw) {
            $data = json_decode($raw, true) ?: [];
        }
    }

    // Alanları başlat (ilk kurulumda)
    if (!isset($data['unique_count']))  $data['unique_count']  = 0;
    if (!isset($data['total_hits']))    $data['total_hits']    = 0;
    if (!isset($data['visitors']))      $data['visitors']      = [];
    if (!isset($data['daily']))         $data['daily']         = [];
    if (!isset($data['daily_ips']))     $data['daily_ips']     = [];
    if (!isset($data['hourly']))        $data['hourly']        = [];
    if (!isset($data['monthly']))       $data['monthly']       = [];
    if (!isset($data['started_at']))    $data['started_at']    = date('Y-m-d H:i:s');

    $today = date('Y-m-d');
    $month = date('Y-m');
    $hour  = date('H');
    $hKey  = $today . '_' . $hour;

    // ── Toplam istek (her girişte artar) ──
    $data['total_hits']++;

    // ── Saatlik istek (HİÇ SİLİNMEZ) ──
    if (!isset($data['hourly'][$hKey])) $data['hourly'][$hKey] = 0;
    $data['hourly'][$hKey]++;

    // ── Günlük istek (HİÇ SİLİNMEZ) ──
    if (!isset($data['daily'][$today])) {
        $data['daily'][$today] = ['unique' => 0, 'hits' => 0];
    }
    $data['daily'][$today]['hits']++;

    // ── Aylık istek (HİÇ SİLİNMEZ) ──
    if (!isset($data['monthly'][$month])) {
        $data['monthly'][$month] = ['unique' => 0, 'hits' => 0];
    }
    $data['monthly'][$month]['hits']++;

    // ── Bugün bu IP daha önce geldi mi? (günlük benzersiz) ──
    $dailyKey = $today . '_' . $hash;
    if (!isset($data['daily_ips'][$dailyKey])) {
        $data['daily_ips'][$dailyKey] = true;   // Kalıcı kaydet, silinmez
        $data['daily'][$today]['unique']++;
        $data['monthly'][$month]['unique']++;
    }

    // ── Bu IP hiç gelmedi mi? (TÜM ZAMANLAR benzersiz — kalıcı) ──
    if (!isset($data['visitors'][$hash])) {
        // Tamamen yeni ziyaretçi — bir daha sayılmaz
        $data['unique_count']++;
        $data['visitors'][$hash] = [
            'first_seen'  => date('Y-m-d H:i:s', $now),
            'visit_count' => 1,
        ];
    } else {
        // Zaten kayıtlı — sadece ziyaret sayısını artır, unique_count değişmez
        $data['visitors'][$hash]['visit_count'] =
            ($data['visitors'][$hash]['visit_count'] ?? 1) + 1;
        $data['visitors'][$hash]['last_seen'] = date('Y-m-d H:i:s', $now);
    }

    // ── Son güncelleme zamanı ──
    $data['last_updated'] = date('Y-m-d H:i:s', $now);

    // ── Kaydet (dosya kilitleme ile, race condition yok) ──
    @file_put_contents(VISITORS_FILE, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
}

// ── Bot filtresi — sadece gerçek kullanıcıları say ──
$_wox_ua   = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
$_wox_bots = ['googlebot','bingbot','slurp','duckduckbot','baiduspider',
               'yandexbot','facebot','ia_archiver','bot','crawler',
               'spider','curl','wget','python','scrapy','httpclient','java/'];
$_wox_is_bot = false;
foreach ($_wox_bots as $_b) {
    if (str_contains($_wox_ua, $_b)) { $_wox_is_bot = true; break; }
}

if (!$_wox_is_bot && !empty($_SERVER['REMOTE_ADDR'])) {
    wox_track_visitor();
}
