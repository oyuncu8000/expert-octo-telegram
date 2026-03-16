<?php
// test_kontrol.php
require 'db.php';

// users.json içeriğini göster
echo '<h3>users.json içeriği:</h3>';
echo '<pre>' . htmlspecialchars(file_get_contents(USERS_FILE)) . '</pre>';

// Manuel kullanıcı ekle (test için)
if (isset($_GET['ekle'])) {
    $email   = strtolower(trim($_GET['email']));
    $expires = time() + (30 * 24 * 60 * 60);
    $users   = getUsers();
    $users[$email] = [
        'email'      => $email,
        'expires'    => $expires,
        'created_at' => time(),
        'stripe_id'  => 'manual'
    ];
    saveUsers($users);
    echo '<p style="color:green">✅ Eklendi: ' . $email . '</p>';
}
?>

<form>
  Email: <input name="email" type="email" value="">
  <input name="ekle" value="1" type="hidden">
  <button type="submit">Manuel Ekle</button>
</form>