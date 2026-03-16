<?php
require 'db.php';

$email   = 'test@test.com'; // test emaili
$expires = time() + (30 * 24 * 60 * 60); // 30 gün

$users = getUsers();
$users[strtolower($email)] = [
    'email'      => $email,
    'expires'    => $expires,
    'created_at' => time(),
    'stripe_id'  => 'manual_test'
];
saveUsers($users);

echo "✅ Test kullanıcısı eklendi: " . $email;
echo "<br>Geçerlilik: " . date('d.m.Y H:i', $expires);
echo "<br><a href='giris.php'>→ Giriş Yap</a>";
?>
```

---

## Sıra
```
1. test_ekle.php → çalıştır (test kullanıcısı ekler)
2. giris.php → test@test.com ile giriş yap
3. stream.php → video oynamalı ✅
4. Stripe'dan gerçek ödeme gelince webhook otomatik ekler