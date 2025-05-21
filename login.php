<?php
session_start();

$dogru_ad = "G231210021";
$dogru_sifre = "G231210021";


$ad = $_POST['ad'] ?? '';
$sifre = $_POST['sifre'] ?? '';


if ($ad === $dogru_ad && $sifre === $dogru_sifre) {
    $_SESSION['loggedIn'] = true;
    $_SESSION['user'] = $ad;

    echo "<h2>Hoşgeldiniz, $ad 2 saniye içinde yönlendiriliyorsunuz..</h2>";
    echo "<script>
        setTimeout(function() {
            window.location.href = 'about.html';
        }, 2000);
    </script>";
} else {
    
    echo "<script>
        alert('Hatalı kullanıcı adı veya şifre!');
        window.location.href = 'login.html';
    </script>";
}
?>
