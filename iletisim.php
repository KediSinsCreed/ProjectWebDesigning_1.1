<?php
session_start();
if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>İletişim - Abdullah Önal</title>
  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-..."
    crossorigin="anonymous"
  />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <header>
    <div class="container">
      <h1>İletişim</h1>
      <p>Mesajınızı aşağıdaki form aracılığıyla iletebilirsiniz.</p>
    </div>
  </header>

  <main class="container my-5">
    <form id="contactForm" novalidate>
      <div class="row g-3">
        <!-- Ad Soyad -->
        <div class="col-md-6">
          <label for="fullName" class="form-label">Ad Soyad</label>
          <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Adınız ve Soyadınız" required>
        </div>
        <!-- E-posta -->
        <div class="col-md-6">
          <label for="email" class="form-label">E-posta</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="ornek@ogr.sakarya.edu.tr" required>
        </div>
        <!-- Telefon -->
        <div class="col-md-6">
          <label for="phone" class="form-label">Telefon</label>
          <input type="tel" class="form-control" id="phone" name="phone" placeholder="0 (123) 456 78 90" required>
        </div>
        <!-- Konu (select) -->
        <div class="col-md-6">
          <label for="subject" class="form-label">Konu</label>
          <select class="form-select" id="subject" name="subject" required>
            <option value="" disabled selected>Seçiniz...</option>
            <option>Bilgi</option>
            <option>Öneri</option>
            <option>Şikayet</option>
          </select>
        </div>
        <!-- Cinsiyet (radio) -->
        <div class="col-12">
          <label class="form-label d-block">Cinsiyet</label>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="male" value="Erkek" required>
            <label class="form-check-label" for="male">Erkek</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="female" value="Kadın">
            <label class="form-check-label" for="female">Kadın</label>
          </div>
        </div>
        <!-- İlgi Alanları (checkbox) -->
       
          <label for="message" class="form-label">Mesajınız</label>
          <textarea class="form-control" id="message" name="message" rows="4" placeholder="Mesajınızı yazın..." required></textarea>
        </div>
      </div>

      <!-- Hata gösterimi için -->
      <div id="errorMessages" class="mt-3 text-danger"></div>

      <!-- Başarı Mesajı -->
      <div id="successMessage" class="mt-4 alert alert-success" style="display:none;">Mesajınız başarıyla gönderildi.</div>

      <!-- Butonlar -->
      <div class="mt-4 d-flex flex-wrap gap-2">
        <button type="submit" class="btn btn-primary">Gönder</button>
        <button type="reset" class="btn btn-secondary">Temizle</button>
      </div>
    </form>
  </main>

  <footer>
    <p>&copy; 2025 Abdullah Önal | Tüm hakları saklıdır.</p>
  </footer>

  <!-- AJAX ile Form Gönderim ve Validasyon -->
  <script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const form = e.target;
      const errors = [];
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const phonePattern = /^[0-9\s]+$/;

      // Değerleri al
      const fullName = form.fullName.value.trim();
      const email = form.email.value.trim();
      const phone = form.phone.value.trim();
      const subject = form.subject.value;
      const gender = form.gender.value;
      const message = form.message.value.trim();

      // Validasyon
      if (!fullName) errors.push('Ad Soyad boş olamaz.');
      if (!emailPattern.test(email)) errors.push('Geçerli bir e-posta girin.');
      if (!phonePattern.test(phone)) errors.push('Telefon sadece rakamlardan oluşmalı.');
      if (!subject) errors.push('Konu seçmelisiniz.');
      if (!gender) errors.push('Cinsiyet bilgisi seçmelisiniz.');
      if (!message) errors.push('Mesaj alanı boş olamaz.');

      const errorDiv = document.getElementById('errorMessages');
      const successDiv = document.getElementById('successMessage');
      errorDiv.innerHTML = '';
      successDiv.style.display = 'none';

      if (errors.length) {
        errorDiv.innerHTML = '<ul><li>' + errors.join('</li><li>') + '</li></ul>';
        return; // Gönderme
      }

      // AJAX POST
      const formData = new FormData(form);
      fetch('form-sonuc.php', {
        method: 'POST',
        body: formData,
        credentials: 'same-origin'
      })
      .then(response => {
        if (!response.ok) throw new Error('Sunucu hatası');
        return response.text();
      })
      .then(() => {
        successDiv.style.display = 'block';
        form.reset();
      })
      .catch(() => {
        errorDiv.innerText = 'Gönderim sırasında hata oluştu.';
      });
    });
  </script>

  <!-- Bootstrap JS Bundle -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-..."
    crossorigin="anonymous"
  ></script>
</body>
</html>