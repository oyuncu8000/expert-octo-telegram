<?php
session_start();

// --- VERİTABANI AYARLARI ---
$db_file = __DIR__ . '/comments.db';
$db = new SQLite3($db_file);

// Tabloları oluştur
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    username TEXT NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
)");

$error = '';
$success = '';

// --- KAYIT ---
if (isset($_POST['action']) && $_POST['action'] === 'register') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    if (strlen($username) < 3 || strlen($password) < 4) {
        $error = 'Kullanıcı adı en az 3, şifre en az 4 karakter olmalı.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (:u, :p)");
        $stmt->bindValue(':u', $username);
        $stmt->bindValue(':p', $hash);
        if (@$stmt->execute()) {
            $row = $db->querySingle("SELECT id FROM users WHERE username = '" . SQLite3::escapeString($username) . "'", true);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            $success = 'Kayıt başarılı! Hoş geldin, ' . htmlspecialchars($username) . '!';
        } else {
            $error = 'Bu kullanıcı adı zaten alınmış.';
        }
    }
}

// --- GİRİŞ ---
if (isset($_POST['action']) && $_POST['action'] === 'login') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $row = $db->querySingle("SELECT * FROM users WHERE username = '" . SQLite3::escapeString($username) . "'", true);
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $success = 'Giriş başarılı! Hoş geldin, ' . htmlspecialchars($row['username']) . '!';
    } else {
        $error = 'Kullanıcı adı veya şifre hatalı.';
    }
}

// --- ÇIKIŞ ---
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// --- YORUM GÖNDER ---
if (isset($_POST['action']) && $_POST['action'] === 'comment') {
    if (!isset($_SESSION['user_id'])) {
        $error = 'Yorum yazmak için giriş yapmalısın.';
    } else {
        $msg = trim($_POST['message']);
        if (strlen($msg) < 2) {
            $error = 'Yorum çok kısa.';
        } else {
            $stmt = $db->prepare("INSERT INTO comments (user_id, username, message) VALUES (:uid, :u, :m)");
            $stmt->bindValue(':uid', $_SESSION['user_id']);
            $stmt->bindValue(':u', $_SESSION['username']);
            $stmt->bindValue(':m', $msg);
            $stmt->execute();
            $success = 'Yorumun eklendi!';
        }
    }
}

// --- YORUMLARI ÇEK ---
$comments = [];
$res = $db->query("SELECT username, message, created_at FROM comments ORDER BY created_at DESC LIMIT 100");
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $comments[] = $row;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Oynatıcı</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #000005;
            --surface: #080b14;
            --surface2: #0d1220;
            --border: rgba(0,180,255,0.15);
            --accent: #00b4ff;
            --accent2: #ff3cac;
            --accent3: #7928ca;
            --text: #c8d8f0;
            --text-dim: #4a6080;
            --glow: 0 0 20px rgba(0,180,255,0.4);
            --glow2: 0 0 20px rgba(255,60,172,0.4);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'Rajdhani', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* --- 3D ANİMASYONLU ARKA PLAN --- */
        .bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .grid-3d {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(0,180,255,0.07) 1px, transparent 1px),
                linear-gradient(90deg, rgba(0,180,255,0.07) 1px, transparent 1px);
            background-size: 60px 60px;
            transform: perspective(600px) rotateX(55deg) scale(2.5) translateY(-10%);
            transform-origin: 50% 0%;
            animation: gridMove 8s linear infinite;
        }

        @keyframes gridMove {
            from { background-position: 0 0; }
            to { background-position: 0 60px; }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: orbFloat 12s ease-in-out infinite alternate;
        }
        .orb1 { width: 400px; height: 400px; background: rgba(0,100,255,0.12); top: -100px; left: -100px; }
        .orb2 { width: 300px; height: 300px; background: rgba(120,0,255,0.1); top: 30%; right: -80px; animation-delay: -4s; }
        .orb3 { width: 250px; height: 250px; background: rgba(255,30,120,0.08); bottom: 10%; left: 30%; animation-delay: -8s; }

        @keyframes orbFloat {
            from { transform: translate(0,0) scale(1); }
            to { transform: translate(30px, 40px) scale(1.1); }
        }

        /* --- LAYOUT --- */
        .page-wrap {
            position: relative;
            z-index: 1;
            max-width: 960px;
            margin: 0 auto;
            padding: 30px 16px 60px;
        }

        /* --- HEADER --- */
        header {
            text-align: center;
            margin-bottom: 32px;
            animation: fadeDown 0.8s ease both;
        }

        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        header h1 {
            font-family: 'Orbitron', sans-serif;
            font-size: clamp(1.4rem, 4vw, 2.4rem);
            font-weight: 900;
            letter-spacing: 4px;
            background: linear-gradient(135deg, var(--accent), var(--accent2), var(--accent3));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
            position: relative;
        }

        header h1::after {
            content: '';
            display: block;
            height: 2px;
            width: 80px;
            margin: 10px auto 0;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            animation: lineGlow 2s ease-in-out infinite alternate;
        }

        @keyframes lineGlow {
            from { box-shadow: 0 0 6px var(--accent); opacity: 0.5; }
            to { box-shadow: 0 0 18px var(--accent); opacity: 1; }
        }

        /* --- VIDEO --- */
        .video-wrap {
            width: 100%;
            aspect-ratio: 16/9;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid rgba(0,180,255,0.25);
            box-shadow: 0 0 40px rgba(0,100,255,0.2), 0 0 1px rgba(0,180,255,0.5) inset;
            position: relative;
            background: #000;
            animation: fadeUp 0.9s 0.2s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .video-wrap::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(0,180,255,0.05) 0%, transparent 50%, rgba(255,60,172,0.04) 100%);
            pointer-events: none;
            z-index: 2;
        }

        .video-wrap iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        /* --- YORUM BÖLÜMÜ --- */
        .comment-section {
            margin-top: 48px;
            animation: fadeUp 1s 0.4s ease both;
        }

        .section-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1rem;
            letter-spacing: 3px;
            color: var(--accent);
            text-transform: uppercase;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title::before, .section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0,180,255,0.3));
        }
        .section-title::after {
            background: linear-gradient(90deg, rgba(0,180,255,0.3), transparent);
        }

        /* --- AUTH PANEL --- */
        .auth-panel {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 32px;
        }

        @media (max-width: 560px) {
            .auth-panel { grid-template-columns: 1fr; }
        }

        .auth-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .auth-box:hover {
            border-color: rgba(0,180,255,0.35);
            box-shadow: 0 0 30px rgba(0,180,255,0.08);
        }

        .auth-box::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .auth-box:hover::before { opacity: 1; }

        .auth-box h3 {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 2px;
            color: var(--accent);
            margin-bottom: 16px;
            text-transform: uppercase;
        }

        .form-input {
            width: 100%;
            background: rgba(0,180,255,0.04);
            border: 1px solid rgba(0,180,255,0.15);
            color: var(--text);
            padding: 10px 14px;
            border-radius: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
            margin-bottom: 12px;
            display: block;
        }

        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 12px rgba(0,180,255,0.2);
        }

        .form-input::placeholder { color: var(--text-dim); }

        .btn {
            width: 100%;
            padding: 11px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.75rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0050b3, #0080ff);
            color: #fff;
            box-shadow: 0 4px 20px rgba(0,120,255,0.3);
        }

        .btn-primary:hover {
            box-shadow: 0 0 25px rgba(0,180,255,0.5);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #4a0080, #7928ca);
            color: #fff;
            box-shadow: 0 4px 20px rgba(120,40,200,0.3);
        }

        .btn-secondary:hover {
            box-shadow: 0 0 25px rgba(120,40,200,0.5);
            transform: translateY(-1px);
        }

        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn:hover::after { opacity: 1; }

        /* --- LOGGED IN STATE --- */
        .logged-in-bar {
            background: var(--surface);
            border: 1px solid rgba(0,180,255,0.2);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent3), var(--accent));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            color: #fff;
            box-shadow: var(--glow);
            flex-shrink: 0;
        }

        .username-label {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.85rem;
            color: var(--accent);
            letter-spacing: 1px;
        }

        .logout-link {
            color: var(--text-dim);
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 1px;
            border: 1px solid rgba(255,255,255,0.08);
            padding: 5px 12px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .logout-link:hover {
            color: var(--accent2);
            border-color: var(--accent2);
        }

        /* --- YORUM FORMU --- */
        .comment-form {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .comment-form::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--accent3), var(--accent), var(--accent2));
        }

        .comment-textarea {
            width: 100%;
            min-height: 90px;
            background: rgba(0,180,255,0.04);
            border: 1px solid rgba(0,180,255,0.15);
            color: var(--text);
            padding: 12px 14px;
            border-radius: 8px;
            font-family: 'Rajdhani', sans-serif;
            font-size: 1rem;
            outline: none;
            resize: vertical;
            transition: border-color 0.3s, box-shadow 0.3s;
            margin-bottom: 12px;
            display: block;
        }

        .comment-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 12px rgba(0,180,255,0.2);
        }

        .comment-textarea::placeholder { color: var(--text-dim); }

        .btn-comment {
            background: linear-gradient(135deg, #003366, #006be0);
            color: #fff;
            border: none;
            padding: 11px 28px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.72rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.3s;
            box-shadow: 0 4px 20px rgba(0,100,255,0.25);
        }

        .btn-comment:hover {
            box-shadow: 0 0 25px rgba(0,180,255,0.45);
            transform: translateY(-1px);
        }

        /* --- YORUMLAR LİSTESİ --- */
        .comments-list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .comment-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px 20px;
            position: relative;
            overflow: hidden;
            animation: cardIn 0.5s ease both;
            transition: border-color 0.3s, transform 0.2s;
        }

        .comment-card:hover {
            border-color: rgba(0,180,255,0.3);
            transform: translateX(4px);
        }

        .comment-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, var(--accent), var(--accent3));
            border-radius: 3px 0 0 3px;
        }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .comment-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .comment-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: linear-gradient(135deg, #003080, #0070cc);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Orbitron', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .comment-name {
            font-family: 'Orbitron', sans-serif;
            font-size: 0.75rem;
            color: var(--accent);
            letter-spacing: 1px;
        }

        .comment-time {
            margin-left: auto;
            font-size: 0.75rem;
            color: var(--text-dim);
            flex-shrink: 0;
        }

        .comment-text {
            font-size: 1rem;
            color: var(--text);
            line-height: 1.5;
            padding-left: 2px;
        }

        /* --- MESAJLAR --- */
        .msg {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            animation: fadeUp 0.4s ease;
        }

        .msg-error {
            background: rgba(220,30,60,0.1);
            border: 1px solid rgba(220,30,60,0.3);
            color: #ff7090;
        }

        .msg-success {
            background: rgba(0,180,100,0.1);
            border: 1px solid rgba(0,180,100,0.3);
            color: #40ffaa;
        }

        /* --- NO COMMENTS --- */
        .no-comments {
            text-align: center;
            color: var(--text-dim);
            font-size: 0.9rem;
            padding: 40px 0;
            letter-spacing: 1px;
        }

        /* --- SCAN LINE EFFECT --- */
        .scanlines {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,0,0,0.03) 2px,
                rgba(0,0,0,0.03) 4px
            );
        }

        /* --- CORNER DECORATIONS --- */
        .corner-deco {
            position: fixed;
            width: 80px;
            height: 80px;
            pointer-events: none;
            z-index: 1;
            opacity: 0.4;
        }

        .corner-deco.tl { top: 16px; left: 16px; border-top: 2px solid var(--accent); border-left: 2px solid var(--accent); }
        .corner-deco.tr { top: 16px; right: 16px; border-top: 2px solid var(--accent2); border-right: 2px solid var(--accent2); }
        .corner-deco.bl { bottom: 16px; left: 16px; border-bottom: 2px solid var(--accent3); border-left: 2px solid var(--accent3); }
        .corner-deco.br { bottom: 16px; right: 16px; border-bottom: 2px solid var(--accent); border-right: 2px solid var(--accent); }

        @media (max-width: 480px) {
            .corner-deco { display: none; }
            header h1 { font-size: 1.1rem; }
        }

        /* --- PARTICLE DOTS --- */
        .particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .dot {
            position: absolute;
            width: 2px;
            height: 2px;
            border-radius: 50%;
            background: rgba(0,180,255,0.6);
            animation: dotFloat linear infinite;
        }
    </style>
</head>
<body>

<!-- Arka Plan -->
<div class="bg-canvas">
    <div class="grid-3d"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>
    <div class="orb orb3"></div>
</div>
<div class="scanlines"></div>
<div class="particles" id="particles"></div>

<!-- Köşe dekorasyonları -->
<div class="corner-deco tl"></div>
<div class="corner-deco tr"></div>
<div class="corner-deco bl"></div>
<div class="corner-deco br"></div>

<div class="page-wrap">

    <!-- HEADER -->
    <header>
        <h1>▶ VİDEO OYNATICI</h1>
    </header>

    <!-- VİDEO -->
    <div class="video-wrap">
        <iframe id="video-player"
            src="https://xk4l.mzt4pr8wlkxnv0qsha5g.website/watch/103516/1/1"
            allowfullscreen
            allow="autoplay; fullscreen">
        </iframe>
    </div>

    <!-- YORUM BÖLÜMÜ -->
    <div class="comment-section">
        <div class="section-title">Yorumlar</div>

        <?php if ($error): ?>
            <div class="msg msg-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="msg msg-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if (!isset($_SESSION['user_id'])): ?>
            <!-- GİRİŞ / KAYIT PANELI -->
            <div class="auth-panel">
                <div class="auth-box">
                    <h3>🔐 Giriş Yap</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="login">
                        <input type="text" name="username" class="form-input" placeholder="Kullanıcı adı" required autocomplete="username">
                        <input type="password" name="password" class="form-input" placeholder="Şifre" required autocomplete="current-password">
                        <button type="submit" class="btn btn-primary">Giriş Yap</button>
                    </form>
                </div>
                <div class="auth-box">
                    <h3>✨ Kayıt Ol</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="register">
                        <input type="text" name="username" class="form-input" placeholder="Kullanıcı adı (min 3 karakter)" required autocomplete="username">
                        <input type="password" name="password" class="form-input" placeholder="Şifre (min 4 karakter)" required autocomplete="new-password">
                        <button type="submit" class="btn btn-secondary">Kayıt Ol</button>
                    </form>
                </div>
            </div>

        <?php else: ?>
            <!-- KULLANICI BİLGİ ÇUBUĞU -->
            <div class="logged-in-bar">
                <div class="user-badge">
                    <div class="avatar"><?= strtoupper(substr($_SESSION['username'], 0, 1)) ?></div>
                    <div>
                        <div class="username-label"><?= htmlspecialchars($_SESSION['username']) ?></div>
                        <div style="font-size:0.75rem;color:var(--text-dim);margin-top:2px;">Giriş yapıldı</div>
                    </div>
                </div>
                <a href="?logout=1" class="logout-link">⏻ Çıkış</a>
            </div>

            <!-- YORUM FORMU -->
            <div class="comment-form">
                <form method="POST">
                    <input type="hidden" name="action" value="comment">
                    <textarea name="message" class="comment-textarea" placeholder="Yorumunuzu yazın..." required maxlength="1000"></textarea>
                    <button type="submit" class="btn-comment">💬 Yorum Gönder</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- YORUMLAR -->
        <div class="comments-list">
            <?php if (empty($comments)): ?>
                <div class="no-comments">── Henüz yorum yok. İlk yorumu sen yaz! ──</div>
            <?php else: ?>
                <?php foreach ($comments as $i => $c): ?>
                <div class="comment-card" style="animation-delay: <?= $i * 0.05 ?>s">
                    <div class="comment-header">
                        <div class="comment-avatar"><?= strtoupper(substr($c['username'], 0, 1)) ?></div>
                        <span class="comment-name"><?= htmlspecialchars($c['username']) ?></span>
                        <span class="comment-time"><?= date('d.m.Y H:i', strtotime($c['created_at'])) ?></span>
                    </div>
                    <div class="comment-text"><?= nl2br(htmlspecialchars($c['message'])) ?></div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
// Partikül efekti
(function() {
    const container = document.getElementById('particles');
    const count = window.innerWidth < 600 ? 20 : 40;
    for (let i = 0; i < count; i++) {
        const d = document.createElement('div');
        d.className = 'dot';
        const size = Math.random() * 2 + 1;
        const x = Math.random() * 100;
        const duration = Math.random() * 20 + 15;
        const delay = Math.random() * 20;
        d.style.cssText = `
            left: ${x}%;
            bottom: -10px;
            width: ${size}px;
            height: ${size}px;
            opacity: ${Math.random() * 0.5 + 0.2};
            animation: dotFloat ${duration}s ${delay}s linear infinite;
        `;
        container.appendChild(d);
    }
})();

// Dinamik CSS for dotFloat
const style = document.createElement('style');
style.textContent = `
    @keyframes dotFloat {
        0%   { transform: translateY(0) translateX(0); opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 0.5; }
        100% { transform: translateY(-100vh) translateX(${(Math.random()-0.5)*200}px); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>

</body>
</html>
