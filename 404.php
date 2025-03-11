<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title>404 - Sayfa Bulunamadı | Linwood Roleplay</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Özel CSS -->
  <link rel="stylesheet" href="style.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'dark-bg': '#0e0e0e',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-[#0e0e0e] text-white font-sans">
  <!-- Modern Header -->
  <header class="modern-header sticky top-0 z-50">
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-5">
      <div class="flex justify-between items-center">
        <div class="flex space-x-3 md:space-x-6 lg:space-x-8 items-center">
          <a href="index.php" class="text-lg sm:text-xl font-bold tracking-wider">LINWOOD</a>
          <nav class="hidden md:flex space-x-3 lg:space-x-6 xl:space-x-8">
            <a href="index.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base">Ana Sayfa</a>
            <a href="rules.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base">Kurallar</a>
            <a href="market.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base">Market</a>
          </nav>
        </div>
        <div class="hidden sm:block">
          <a href="profile.php" class="btn btn-primary hover-glow text-sm sm:text-base md:px-5 lg:px-6">Başvuru Yap</a>
        </div>
        <!-- Mobil Menü Butonu -->
        <div class="md:hidden">
          <button id="menu-toggle" class="text-white focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </div>
      <!-- Mobil Menü -->
      <div id="mobile-menu" class="hidden md:hidden mt-3 pb-3">
        <a href="index.php" class="block py-2 text-white hover:text-gray-300">Ana Sayfa</a>
        <a href="rules.php" class="block py-2 text-white hover:text-gray-300">Kurallar</a>
        <a href="market.php" class="block py-2 text-white hover:text-gray-300">Market</a>
        <a href="profile.php" class="block py-2 text-white hover:text-gray-300 sm:hidden mt-2">
          <span class="btn btn-primary hover-glow text-sm block text-center">Başvuru Yap</span>
        </a>
      </div>
    </div>
  </header>

  <!-- 404 İçerik Bölümü -->
  <section class="py-16 md:py-20 min-h-[70vh] flex items-center">
    <div class="container mx-auto px-4">
      <div class="max-w-3xl mx-auto glass-card p-8 md:p-12 text-center fade-in-up">
        <!-- 404 Animasyonlu İkon -->
        <div class="mb-8 inline-block relative">
          <div class="feature-icon text-6xl sm:text-7xl md:text-8xl text-white mx-auto mb-0" style="width: 120px; height: 120px;">
            <i class="fas fa-map-marked-alt"></i>
          </div>
          <div class="absolute -top-4 -right-4 bg-red-600 rounded-full w-12 h-12 flex items-center justify-center text-xl font-bold animate-pulse">
            404
          </div>
        </div>
        
        <!-- 404 Başlık ve Açıklama -->
        <h1 class="text-4xl sm:text-5xl font-bold mb-4 hero-title">Sayfa Bulunamadı</h1>
        <p class="text-xl text-gray-300 mb-8">
          Bu bölge Linwood haritasında henüz keşfedilmemiş görünüyor. Aradığınız sayfa mevcut değil veya taşınmış olabilir.
        </p>
        
        <!-- Espri Bölümü - RP Temalı -->
        <div class="mb-10 py-4 px-6 bg-[#191919] rounded-lg inline-block">
          <p class="text-gray-400 italic">
            <i class="fas fa-quote-left mr-2 opacity-50"></i>
            Polis Telsizi: "Şüpheli konum tespit edilemedi. Tüm birimlere duyuru: Ana merkeze geri dönün."
            <i class="fas fa-quote-right ml-2 opacity-50"></i>
          </p>
        </div>
        
        <!-- Navigasyon Butonları -->
        <div class="space-y-4">
          <a href="index.php" class="btn btn-primary px-8 py-3 hover-glow inline-flex items-center">
            <i class="fas fa-home mr-2"></i> Ana Sayfaya Dön
          </a>
          
          <div class="flex flex-col sm:flex-row justify-center gap-4 mt-6">
            <a href="rules.php" class="btn bg-transparent border border-white hover:bg-white hover:text-black text-sm sm:text-base">
              <i class="fas fa-scroll mr-2"></i> Kurallar
            </a>
            <a href="market.php" class="btn bg-transparent border border-white hover:bg-white hover:text-black text-sm sm:text-base">
              <i class="fas fa-shopping-cart mr-2"></i> Market
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-8 sm:py-10 md:py-12 modern-footer">
    <div class="container mx-auto px-4 text-center">
      <div class="flex items-center justify-center mb-6 sm:mb-8">
        <span class="text-2xl sm:text-3xl font-bold relative">
          <span class="pr-2">LINWOOD</span>
          <span class="text-base sm:text-lg font-normal text-gray-400">ROLEPLAY</span>
        </span>
      </div>
      <div class="flex justify-center space-x-6 sm:space-x-8 mb-6 sm:mb-8">
        <a href="#" class="social-icon text-xl sm:text-2xl hover:text-gray-300"><i class="fab fa-discord"></i></a>
        <a href="#" class="social-icon text-xl sm:text-2xl hover:text-gray-300"><i class="fab fa-youtube"></i></a>
        <a href="#" class="social-icon text-xl sm:text-2xl hover:text-gray-300"><i class="fab fa-twitter"></i></a>
        <a href="#" class="social-icon text-xl sm:text-2xl hover:text-gray-300"><i class="fab fa-instagram"></i></a>
      </div>
      <hr class="border-gray-800 mb-6 sm:mb-8">
      <p class="text-xs sm:text-sm text-gray-500">
        © 2025 Linwood Roleplay - Tüm Hakları Saklıdır. <br class="sm:hidden">
        <span class="hidden sm:inline"> · </span>
        Bu site sadece rol yapma amaçlı oluşturulmuş oyun topluluğumuza aittir.
      </p>
    </div>
  </footer>

  <!-- JavaScript -->
  <script src="script.js"></script>
  
  <!-- 404 Özel CSS -->
  <style>
    @keyframes pulse-glow {
      0%, 100% { 
        box-shadow: 0 0 15px rgba(230, 30, 37, 0.7);
        transform: scale(1);
      }
      50% { 
        box-shadow: 0 0 25px rgba(230, 30, 37, 0.9);
        transform: scale(1.05);
      }
    }
    
    .animate-pulse {
      animation: pulse-glow 2s ease-in-out infinite;
    }
  </style>
</body>
</html>
