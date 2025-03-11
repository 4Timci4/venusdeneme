<?php
// Ana sayfa
require_once 'session.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor
?>

  <!-- Hero Bölümü -->
  <section class="relative h-[400px] sm:h-[500px] md:h-[500px] overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center transform scale-105" style="background-image: url('https://picsum.photos/1920/1080?random=1')"></div>
    
    <!-- Hero Overlay ve İçerik -->
    <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col">
      <div class="container mx-auto px-4 py-8 flex-1 flex flex-col">
        <div class="max-w-xl mt-10 sm:mt-12 md:mt-16 fade-in-up">
          <h1 class="hero-title text-4xl sm:text-5xl md:text-6xl font-bold mb-4 md:mb-6">
            <span class="hero-title-accent">Linwood</span> Roleplay
          </h1>
          <p class="hero-description text-base sm:text-lg md:text-xl">Linwood şehrinde gerçekçi bir roleplay deneyimi yaşayın. Karakterinizi oluşturun, meslek sahibi olun ve Linwood topluluğuna katılın.</p>
          <div class="mt-6 md:mt-8 flex flex-col sm:flex-row gap-3">
            <a href="basvuru.php" class="btn btn-primary hover-glow text-sm sm:text-base">Hemen Başla</a>
            <a href="#content" class="btn btn-outline text-sm sm:text-base">Daha Fazla</a>
          </div>
        </div>
        <div class="mt-auto mb-10 sm:mb-16 text-center">
          <div class="flex justify-center space-x-6 md:space-x-8 mb-8 md:mb-10">
            <a href="#" class="social-icon text-3xl hover:text-gray-300"><i class="fab fa-discord"></i></a>
            <a href="#" class="social-icon text-3xl hover:text-gray-300"><i class="fab fa-youtube"></i></a>
            <a href="#" class="social-icon text-3xl hover:text-gray-300"><i class="fab fa-twitter"></i></a>
          </div>
          <a href="#content" class="inline-block scroll-indicator">
            <i class="fas fa-chevron-down text-xl"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Ana İçerik -->
  <section id="content" class="py-12 sm:py-16 md:py-20 content-section">
    <div class="container mx-auto px-4">
      <!-- Sistemlerimiz -->
      <div class="flex flex-col md:flex-row items-center mb-16 sm:mb-20 md:mb-24 gap-8 md:gap-12 fade-in-up">
        <div class="md:w-1/3 flex justify-center mb-6 md:mb-0">
          <div class="feature-icon text-4xl sm:text-5xl text-white">
            <i class="fas fa-cogs"></i>
          </div>
        </div>
        <div class="md:w-2/3">
          <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 section-title">Sistemlerimiz</h2>
          <p class="text-gray-300 text-base sm:text-lg leading-relaxed">
            Linwood Roleplay, gerçekçi bir roleplay deneyimi sunmak için geliştirilmiş özel sistemlere sahiptir. 
            Ekonomi sistemi, meslekler, araç satın alma ve özelleştirme, gayrimenkul, polis ve acil servis sistemleri, 
            telefonlar ve çok daha fazlasını içeren bir roleplay ortamında karakterinizi geliştirebilirsiniz. 
            Her bir sistemimiz, en iyi oyun deneyimini sağlamak için tasarlanmış ve sürekli geliştirilmektedir.
          </p>
        </div>
      </div>

      <!-- Neden Burdayız -->
      <div class="flex flex-col md:flex-row-reverse items-center mb-16 sm:mb-20 md:mb-24 gap-8 md:gap-12 fade-in-up">
        <div class="md:w-1/3 flex justify-center mb-6 md:mb-0">
          <div class="feature-icon text-4xl sm:text-5xl text-white">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="md:w-2/3">
          <h2 class="text-2xl sm:text-3xl font-bold mb-4 sm:mb-6 section-title">Neden Burdayız</h2>
          <p class="text-gray-300 text-base sm:text-lg leading-relaxed">
            Linwood Roleplay topluluğu olarak amacımız, kaliteli ve gerçekçi bir roleplay ortamı sunarak 
            oyuncularımıza benzersiz bir deneyim sağlamaktır. Deneyimli yönetim ekibimiz ve topluluk odaklı 
            yaklaşımımız ile sürekli kendimizi geliştiriyor, yeni fikirler ve güncellemelerle sunucumuzu 
            daha iyi hale getiriyoruz. Burada sadece bir oyun oynamazsınız; yeni arkadaşlar edinir, karakterinizi 
            geliştirir ve bir topluluğun parçası olursunuz.
          </p>
        </div>
      </div>

      <!-- İstatistikler -->
      <div class="py-10 sm:py-14 fade-in-up">
        <h2 class="text-2xl sm:text-3xl font-bold text-center mb-8 sm:mb-10 section-title-center">İstatistikler</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-8 mt-10 sm:mt-14">
          <!-- Karakter Sayacı -->
          <div class="counter-card hover-float">
            <div class="text-3xl sm:text-4xl text-red-600 mb-4 sm:mb-6 counter-icon">
              <i class="fas fa-user"></i>
            </div>
            <span class="text-3xl sm:text-4xl font-bold counter-number" id="counter-characters" data-target="1250">0</span>
            <p class="text-gray-400 mt-3 sm:mt-4 text-sm sm:text-base">Aktif Karakter</p>
          </div>
          
          <!-- Whitelist Sayacı -->
          <div class="counter-card hover-float">
            <div class="text-3xl sm:text-4xl text-red-600 mb-4 sm:mb-6 counter-icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <span class="text-3xl sm:text-4xl font-bold counter-number" id="counter-whitelist" data-target="850">0</span>
            <p class="text-gray-400 mt-3 sm:mt-4 text-sm sm:text-base">Whitelist</p>
          </div>
          
          <!-- Admin Sayacı -->
          <div class="counter-card hover-float">
            <div class="text-3xl sm:text-4xl text-red-600 mb-4 sm:mb-6 counter-icon">
              <i class="fas fa-shield-alt"></i>
            </div>
            <span class="text-3xl sm:text-4xl font-bold counter-number" id="counter-admins" data-target="25">0</span>
            <p class="text-gray-400 mt-3 sm:mt-4 text-sm sm:text-base">Admin</p>
          </div>
          
          <!-- Araç ve Ev Sayacı -->
          <div class="counter-card hover-float">
            <div class="text-3xl sm:text-4xl text-red-600 mb-4 sm:mb-6 counter-icon">
              <i class="fas fa-car"></i>
            </div>
            <span class="text-3xl sm:text-4xl font-bold counter-number" id="counter-properties" data-target="3500">0</span>
            <p class="text-gray-400 mt-3 sm:mt-4 text-sm sm:text-base">Araç & Ev</p>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'footer.php'; ?>
