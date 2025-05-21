<?php
session_start();
if (!isset($_SESSION['loggedIn'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımda - Abdullah Önal</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Merhaba, Ben Abdullah Önal</h1>
            <p>Web Teknolojileri Bahar Dönemi Proje Çalışması</p>
        </div>
    </header>

    <section id="hakkimda">
        <div class="container">
            <h2>Hakkımda</h2>
            <p>ilgili bilgiler vs, </p>
            <p>..</p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Abdullah Önal | Tüm hakları saklıdır.</p>
    </footer>
</body>
</html>
