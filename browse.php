<?php
/**
 * WOXPLUS - browse.php
 * Cookie oturumları JSON veritabanında saklanır.
 * Sunucu yeniden başlasa bile oturum kaybolmaz.
 */

define('DB_DIR', __DIR__ . '/woxplus_data');
if (!is_dir(DB_DIR)) mkdir(DB_DIR, 0755, true);

// Güvenlik: dışarıdan erişimi engelle
$htaccess = DB_DIR . '/.htaccess';
if (!file_exists($htaccess)) {
    file_put_contents($htaccess, "Deny from all\n");
}

// ── VERİTABANI FONKSİYONLARI ─────────────────────────────────────────────────
function db_read(string $file): array {
    $path = DB_DIR . '/' . $file;
    if (!file_exists($path)) return [];
    $data = json_decode(file_get_contents($path), true);
    return is_array($data) ? $data : [];
}

function db_write(string $file, array $data): bool {
    $path = DB_DIR . '/' . $file;
    $tmp  = $path . '.tmp.' . getmypid();
    if (file_put_contents($tmp, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), LOCK_EX) === false) return false;
    return rename($tmp, $path);
}

function uid_file(int $uid, string $type): string {
    return "user_{$uid}_{$type}.json";
}

// ── SESSION TOKEN SİSTEMİ ─────────────────────────────────────────────────────
define('COOKIE_NAME',     'wox_auth');
define('COOKIE_LIFETIME', 60 * 60 * 24 * 30); // 30 gün

/**
 * Yeni token oluştur → DB'ye hash'li kaydet → cookie'ye düz gönder.
 */
function create_session(int $uid): void {
    $token   = bin2hex(random_bytes(32));
    $expires = time() + COOKIE_LIFETIME;

    // Aynı kullanıcının eski tokenlarını ve süresi dolmuşları temizle
    $sessions = db_read('sessions.json');
    $sessions = array_values(array_filter($sessions, function($s) use ($uid) {
        if ((int)$s['uid'] === $uid)   return false; // eski oturumu sil
        if ($s['expires'] <= time())   return false; // süresi dolmuşu sil
        return true;
    }));

    // Yeni oturumu ekle (DB'de sadece hash saklanır, güvenlik için)
    $sessions[] = [
        'token'   => hash('sha256', $token),
        'uid'     => $uid,
        'expires' => $expires,
        'created' => time(),
        'ip'      => $_SERVER['REMOTE_ADDR'] ?? '',
    ];

    db_write('sessions.json', $sessions);

    // Tarayıcıya düz token gönder
    setcookie(COOKIE_NAME, $token, [
        'expires'  => $expires,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

/**
 * Cookie'deki token DB'deki hash ile eşleşiyor mu?
 * Eşleşiyorsa uid, değilse null döner.
 */
function verify_session(): ?int {
    $token = $_COOKIE[COOKIE_NAME] ?? null;
    if (!$token) return null;

    $hashed   = hash('sha256', $token);
    $sessions = db_read('sessions.json');

    foreach ($sessions as $s) {
        if ($s['token'] === $hashed && (int)$s['expires'] > time()) {
            return (int)$s['uid'];
        }
    }
    return null;
}

/**
 * Cookie'yi ve DB kaydını sil.
 */
function destroy_session(): void {
    $token = $_COOKIE[COOKIE_NAME] ?? null;
    if ($token) {
        $hashed   = hash('sha256', $token);
        $sessions = db_read('sessions.json');
        $sessions = array_values(array_filter($sessions, fn($s) => $s['token'] !== $hashed));
        db_write('sessions.json', $sessions);
    }
    setcookie(COOKIE_NAME, '', [
        'expires'  => time() - 3600,
        'path'     => '/',
        'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

/**
 * Süresi dolmuş tokenları periyodik temizle.
 */
function cleanup_sessions(): void {
    $sessions = db_read('sessions.json');
    $cleaned  = array_values(array_filter($sessions, fn($s) => $s['expires'] > time()));
    if (count($cleaned) < count($sessions)) db_write('sessions.json', $cleaned);
}

// Her ~50 istekte bir temizlik yap
if (rand(1, 50) === 1) cleanup_sessions();

// Mevcut kullanıcıyı cookie'den doğrula
$uid = verify_session();

// ── RESPONSE HEADER ───────────────────────────────────────────────────────────
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

// ── YARDIMCI FONKSİYONLAR ────────────────────────────────────────────────────
function ok(array $extra = []): void {
    echo json_encode(array_merge(['ok' => true], $extra), JSON_UNESCAPED_UNICODE);
    exit;
}

function err(string $msg): void {
    echo json_encode(['ok' => false, 'msg' => $msg], JSON_UNESCAPED_UNICODE);
    exit;
}

function get_favorites(int $uid): array {
    return db_read(uid_file($uid, 'favs'));
}

// ── GET: Favoriler ────────────────────────────────────────────────────────────
if (isset($_GET['get_favs'])) {
    if (!$uid) { echo ''; exit; }
    $favs = get_favorites($uid);
    if (empty($favs)) { echo ''; exit; }

    $html = '<div class="slider-container"><button class="slider-arrow left">❮</button><div class="slider-wrapper"><div class="slider">';
    foreach ($favs as $m) {
        $id    = (int)($m['movie_id'] ?? 0);
        $title = htmlspecialchars($m['title']  ?? '', ENT_QUOTES);
        $img   = htmlspecialchars($m['img']    ?? '', ENT_QUOTES);
        $year  = htmlspecialchars($m['year']   ?? '', ENT_QUOTES);
        $genre = htmlspecialchars($m['genre']  ?? '', ENT_QUOTES);
        $rat   = htmlspecialchars($m['rating'] ?? '', ENT_QUOTES);
        $urlJs = addslashes($m['url']   ?? '');
        $titJs = addslashes($m['title'] ?? '');
        $imgJs = addslashes($m['img']   ?? '');
        $html .= <<<CARD
<div class="movie-card focusable">
  <img src="{$img}" alt="{$title}" loading="lazy">
  <div class="card-overlay">
    <div class="card-title">{$title}</div>
    <div class="card-meta"><span>{$year}</span><span>•</span><span>{$genre}</span><span class="card-rating">★ {$rat}</span></div>
    <div class="card-actions">
      <button class="card-btn card-btn-play" onclick="playAndTrack(this,'{$urlJs}','{$titJs}','{$imgJs}','{$year}','{$genre}','{$rat}',{$id})">▶ İzle</button>
      <button class="card-btn card-btn-fav active" data-id="{$id}" onclick="toggleFavorite(this,{$id},'{$titJs}','{$imgJs}','{$urlJs}','{$year}','{$genre}','{$rat}')">✓</button>
    </div>
  </div>
</div>
CARD;
    }
    $html .= '</div></div><button class="slider-arrow right">❯</button></div>';
    echo $html;
    exit;
}

// ── GET: İzleme Geçmişi ───────────────────────────────────────────────────────
if (isset($_GET['get_history'])) {
    if (!$uid) { echo json_encode([]); exit; }
    $hist = db_read(uid_file($uid, 'history'));
    echo json_encode(array_values(array_slice(array_reverse($hist), 0, 10)), JSON_UNESCAPED_UNICODE);
    exit;
}

// ── POST: Kayıt Ol ────────────────────────────────────────────────────────────
$action = trim($_POST['action'] ?? '');

if ($action === 'register') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim(strtolower($_POST['email'] ?? ''));
    $pass  = $_POST['pass'] ?? '';

    if (!$name || !$email || !$pass)                  err('Tüm alanları doldurunuz.');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))   err('Geçersiz e-posta adresi.');
    if (strlen($pass) < 6)                            err('Şifre en az 6 karakter olmalı.');
    if (strlen($name) < 2)                            err('İsim en az 2 karakter olmalı.');

    $users = db_read('users.json');
    foreach ($users as $u) {
        if (strtolower($u['email']) === $email) err('Bu e-posta zaten kayıtlı. Lütfen giriş yapın.');
    }

    $newId   = empty($users) ? 1 : (max(array_column($users, 'id')) + 1);
    $users[] = [
        'id'         => $newId,
        'name'       => $name,
        'email'      => $email,
        'pass'       => password_hash($pass, PASSWORD_DEFAULT),
        'username'   => '',
        'avatar'     => '',
        'created'    => time(),
        'last_login' => time(),
    ];

    if (!db_write('users.json', $users)) err('Kayıt sırasında hata oluştu.');

    create_session($newId);
    ok(['msg' => 'Hesabınız oluşturuldu! Yönlendiriliyorsunuz...']);
}

// ── POST: Giriş Yap ───────────────────────────────────────────────────────────
if ($action === 'login') {
    $email = trim(strtolower($_POST['email'] ?? ''));
    $pass  = $_POST['pass'] ?? '';

    if (!$email || !$pass)                          err('E-posta ve şifre giriniz.');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) err('Geçersiz e-posta adresi.');

    $users = db_read('users.json');
    $found = null;
    foreach ($users as $u) {
        if (strtolower($u['email']) === $email) { $found = $u; break; }
    }

    if (!$found)                                 err('Bu e-posta ile kayıtlı hesap bulunamadı.');
    if (!password_verify($pass, $found['pass'])) err('Şifre hatalı. Lütfen tekrar deneyin.');

    // Son giriş zamanını güncelle
    foreach ($users as &$u) {
        if ((int)$u['id'] === (int)$found['id']) { $u['last_login'] = time(); break; }
    }
    unset($u);
    db_write('users.json', $users);

    create_session((int)$found['id']);
    ok(['msg' => 'Giriş başarılı! Yönlendiriliyorsunuz...']);
}

// ── POST: Çıkış Yap ───────────────────────────────────────────────────────────
if ($action === 'logout') {
    destroy_session();
    ok(['msg' => 'Çıkış yapıldı.']);
}

// ── POST: Profil Kaydet ───────────────────────────────────────────────────────
if ($action === 'save_profile') {
    if (!$uid) err('Oturum bulunamadı. Lütfen tekrar giriş yapın.');

    $username = trim($_POST['username'] ?? '');
    $avatar   = trim($_POST['avatar']   ?? '');
    if (!$username) err('Kullanıcı adı boş olamaz.');

    $users = db_read('users.json');
    $found = false;
    foreach ($users as &$u) {
        if ((int)$u['id'] === $uid) { $u['username'] = $username; $u['avatar'] = $avatar; $found = true; break; }
    }
    unset($u);
    if (!$found) err('Kullanıcı bulunamadı.');
    if (!db_write('users.json', $users)) err('Profil kaydedilemedi.');

    ok(['msg' => 'Profil kaydedildi.']);
}

// ── POST: Favori Ekle ─────────────────────────────────────────────────────────
if ($action === 'add') {
    if (!$uid) err('Oturum bulunamadı.');
    $mid = (int)($_POST['movie_id'] ?? 0);
    if ($mid <= 0) err('Geçersiz içerik.');

    $favs = get_favorites($uid);
    if (!in_array($mid, array_column($favs, 'movie_id'), true)) {
        $favs[] = [
            'movie_id' => $mid,
            'title'    => $_POST['title']  ?? '',
            'img'      => $_POST['img']    ?? '',
            'url'      => $_POST['url']    ?? '',
            'year'     => $_POST['year']   ?? '',
            'genre'    => $_POST['genre']  ?? '',
            'rating'   => $_POST['rating'] ?? '',
            'added'    => time(),
        ];
        db_write(uid_file($uid, 'favs'), $favs);
    }
    ok(['favorites' => array_map('intval', array_column($favs, 'movie_id'))]);
}

// ── POST: Favori Kaldır ───────────────────────────────────────────────────────
if ($action === 'remove') {
    if (!$uid) err('Oturum bulunamadı.');
    $mid  = (int)($_POST['movie_id'] ?? 0);
    $favs = array_values(array_filter(get_favorites($uid), fn($f) => (int)$f['movie_id'] !== $mid));
    db_write(uid_file($uid, 'favs'), $favs);
    ok(['favorites' => array_map('intval', array_column($favs, 'movie_id'))]);
}

// ── POST: İzleme Geçmişi Ekle ────────────────────────────────────────────────
if ($action === 'track_watch') {
    if (!$uid) ok([]);
    $mid = (int)($_POST['movie_id'] ?? 0);
    if ($mid <= 0) ok([]);

    $hist = db_read(uid_file($uid, 'history'));
    $hist = array_values(array_filter($hist, fn($h) => (int)$h['movie_id'] !== $mid));
    $hist[] = [
        'movie_id' => $mid,
        'title'    => $_POST['title']    ?? '',
        'img'      => $_POST['img']      ?? '',
        'url'      => $_POST['url']      ?? '',
        'year'     => $_POST['year']     ?? '',
        'genre'    => $_POST['genre']    ?? '',
        'rating'   => $_POST['rating']   ?? '',
        'progress' => min(100, max(0, (int)($_POST['progress'] ?? 0))),
        'watched'  => time(),
    ];
    if (count($hist) > 20) $hist = array_slice($hist, -20);
    db_write(uid_file($uid, 'history'), $hist);
    ok([]);
}

// ── POST: Geçmişi Temizle ─────────────────────────────────────────────────────
if ($action === 'clear_history') {
    if (!$uid) ok([]);
    db_write(uid_file($uid, 'history'), []);
    ok([]);
}

// ── Geçersiz İstek ───────────────────────────────────────────────────────────
err('Geçersiz istek.');
