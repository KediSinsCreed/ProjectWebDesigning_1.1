<?php
session_start();
// Sadece giriş yapmış kullanıcı görebilir
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.html');
    exit;
}

// Dosya yolu
$filePath = __DIR__ . '/data/submissions.json';

// Gelen POST verisi varsa, kaydet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Temizleme fonksiyonu
    function eskiz($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $entry = [
        'time'     => date('Y-m-d H:i:s'),
        'isim'     => eskiz($_POST['fullName'] ?? ''),
        'email'    => eskiz($_POST['email'] ?? ''),
        'telefon'  => eskiz($_POST['phone'] ?? ''),
        'konu'     => eskiz($_POST['subject'] ?? ''),
        'cinsiyet' => eskiz($_POST['gender'] ?? ''),
        'hobiler'  => array_map('eskiz', $_POST['hobbies'] ?? []),
        'mesaj'    => eskiz($_POST['message'] ?? '')
    ];

    // Mevcut verileri oku
    if (file_exists($filePath)) {
        $all = json_decode(file_get_contents($filePath), true);
        if (!is_array($all)) {
            $all = [];
        }
    } else {
        // Klasör yoksa oluştur
        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }
        $all = [];
    }

    // Yeni kaydı ekle ve dosyaya yaz
    $all[] = $entry;
    file_put_contents($filePath, json_encode($all, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Tüm kayıtları oku
$submissions = [];
if (file_exists($filePath)) {
    $submissions = json_decode(file_get_contents($filePath), true);
    if (!is_array($submissions)) {
        $submissions = [];
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Başvuruları - Abdullah Önal</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <div class="container">
      <h1>Toplanan İletişim Formu Başvuruları</h1>
      <p><a href="logout.php" class="button">Çıkış Yap</a></p>
    </div>
  </header>

  <main class="container my-5">
    <?php if (empty($submissions)): ?>
      <p>Henüz gönderilmiş bir form bulunmuyor.</p>
    <?php else: ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Zaman</th>
            <th>Ad Soyad</th>
            <th>E-posta</th>
            <th>Telefon</th>
            <th>Konu</th>
            <th>Cinsiyet</th>
            
            <th>Mesaj</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($submissions as $row): ?>
            <tr>
              <td><?= $row['time'] ?></td>
              <td><?= $row['isim'] ?></td>
              <td><?= $row['email'] ?></td>
              <td><?= $row['telefon'] ?></td>
              <td><?= $row['konu'] ?></td>
              <td><?= $row['cinsiyet'] ?></td>
              
              <td><?= nl2br($row['mesaj']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </main>

  <footer>
    <p>&copy; 2025 Abdullah Önal | Tüm hakları saklıdır.</p>
  </footer>
</body>
</html>
