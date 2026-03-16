<?php
// ═══════════════════════════════════════════════════════════════════
//  WOXPLUS — config.php  (SQLite — kurulum gerektirmez)
// ═══════════════════════════════════════════════════════════════════

// SQLite .db dosyasının yolu (yazılabilir bir klasör olmalı)
define('DB_PATH', '/app/data/woxplus.db');
define('APP_NAME',   'WOXPLUS');
define('APP_URL',    'https://tr.woxplus.cloud-ip.cc');
define('SESSION_LIFE', 90);
define('APP_SECRET', 'woxplus_2026_gizli_anahtar');
define('APP_DEBUG',  true);

if (APP_DEBUG) { ini_set('display_errors',1); error_reporting(E_ALL); }
else           { ini_set('display_errors',0); error_reporting(0); }

// ─── SQLite bağlantısı + tablo kurulumu ───────────────────────────
function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;

    $dir = dirname(DB_PATH);
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    try {
        $pdo = new PDO('sqlite:' . DB_PATH, null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec('PRAGMA journal_mode=WAL;');
        $pdo->exec('PRAGMA foreign_keys=ON;');

        // Tablolar yoksa oluştur (her açılışta kontrol eder, hızlı)
        $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id     TEXT NOT NULL UNIQUE,
            token       TEXT NOT NULL UNIQUE,
            name        TEXT NOT NULL,
            email       TEXT NOT NULL UNIQUE,
            pass_hash   TEXT NOT NULL,
            plan        TEXT NOT NULL DEFAULT 'none',
            plan_expiry TEXT,
            used_free   INTEGER NOT NULL DEFAULT 0,
            created_at  TEXT NOT NULL DEFAULT (datetime('now')),
            last_login  TEXT
        );
        CREATE TABLE IF NOT EXISTS sessions (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id_fk  TEXT NOT NULL,
            session_key TEXT NOT NULL UNIQUE,
            ip          TEXT,
            user_agent  TEXT,
            expires_at  TEXT NOT NULL,
            created_at  TEXT NOT NULL DEFAULT (datetime('now'))
        );
        CREATE TABLE IF NOT EXISTS favorites (
            id          INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id_fk  TEXT NOT NULL,
            movie_id    INTEGER NOT NULL,
            title       TEXT NOT NULL,
            img         TEXT,
            url         TEXT,
            year        TEXT,
            genre       TEXT,
            rating      TEXT,
            added_at    TEXT NOT NULL DEFAULT (datetime('now')),
            UNIQUE(user_id_fk, movie_id)
        );
        ");
    } catch (PDOException $e) {
        if (APP_DEBUG) die('<pre style="color:red;padding:20px">SQLite Hatası: '.$e->getMessage().'<br>DB Yolu: '.DB_PATH.'</pre>');
        else { http_response_code(500); die(json_encode(['ok'=>false,'msg'=>'Sunucu hatası.'])); }
    }
    return $pdo;
}
