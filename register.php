<?php
$page_title = "Kayıt Kapalı";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor

// Eğer kullanıcı bu sayfaya POST isteği ile geldiyse ana sayfaya yönlendir
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  redirect('index.php');
}
?>

<section class="py-12 sm:py-16 fade-in-up">
  <div class="container mx-auto px-4 max-w-md">
    <div class="glass-card p-6 md:p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 section-title-center inline-block">Kayıt Sistemi Kapalı</h1>
        <div class="flex justify-center">
          <div class="feature-icon text-3xl sm:text-4xl text-white mb-4">
            <i class="fas fa-lock"></i>
          </div>
        </div>
        <p class="text-gray-300 mb-6">Linwood Roleplay'e kayıt şu an için kapalıdır. Yeni üyelikler sadece yetkili yöneticiler tarafından manuel olarak oluşturulmaktadır.</p>
      </div>
      
      <div class="bg-gray-800/60 rounded-md p-4 mt-4 border border-gray-700">
        <div class="flex items-start">
          <div class="flex-shrink-0 mt-0.5">
            <i class="fas fa-info-circle text-primary"></i>
          </div>
          <div class="ml-3">
            <h3 class="text-sm font-medium text-gray-200">Bilgilendirme</h3>
            <div class="mt-2 text-sm text-gray-400">
              <p>Kayıt olmak için lütfen Discord sunucumuza katılın ve yetkililere başvurun.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="mt-5 text-center text-sm">
        <p class="text-gray-400">
          Zaten hesabınız var mı? <a href="login.php" class="text-primary hover:text-red-400">Giriş Yap</a>
        </p>
      </div>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
