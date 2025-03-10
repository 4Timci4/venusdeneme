<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Linwood Roleplay</title>
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
  <!-- Header -->
  <header class="bg-black sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
      <div class="flex justify-between items-center">
        <div class="flex space-x-8 items-center">
          <div class="text-xl font-bold">LINWOOD</div>
          <nav class="hidden md:flex space-x-6">
            <a href="#" class="text-white hover:text-gray-300">Home</a>
            <a href="#" class="text-white hover:text-gray-300">Rules</a>
            <a href="#" class="text-white hover:text-gray-300">Market</a>
          </nav>
        </div>
        <div>
          <a href="#" class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-md transition-colors">Başvuru Yap</a>
        </div>
        <!-- Mobil Menü Butonu -->
        <div class="md:hidden">
          <button id="menu-toggle" class="text-white focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </div>
      <!-- Mobil Menü -->
      <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4">
        <a href="#" class="block py-2 text-white hover:text-gray-300">Home</a>
        <a href="#" class="block py-2 text-white hover:text-gray-300">Rules</a>
        <a href="#" class="block py-2 text-white hover:text-gray-300">Market</a>
      </div>
    </div>
  </header>

  <!-- Slider/Banner Bölümü -->
  <section class="relative h-[500px] overflow-hidden">
    <div id="slider" class="h-full">
      <!-- Slider içeriği JavaScript ile doldurulacak -->
      <div class="slide absolute inset-0 opacity-100 transition-opacity duration-1000 bg-cover bg-center" style="background-image: url('https://picsum.photos/1600/900?random=1')"></div>
      <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000 bg-cover bg-center" style="background-image: url('https://picsum.photos/1600/900?random=2')"></div>
      <div class="slide absolute inset-0 opacity-0 transition-opacity duration-1000 bg-cover bg-center" style="background-image: url('https://picsum.photos/1600/900?random=3')"></div>
    </div>
    
    <!-- Slider Overlay ve İçerik -->
    <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col">
      <div class="container mx-auto px-4 py-8 flex-1 flex flex-col">
        <div class="max-w-lg mt-10">
          <h1 class="text-4xl md:text-5xl font-bold mb-4">Linwood Roleplay</h1>
          <p class="text-lg md:text-xl">Linwood şehrinde gerçekçi bir roleplay deneyimi yaşayın. Karakterinizi oluşturun, meslek sahibi olun ve Linwood topluluğuna katılın.</p>
        </div>
        <div class="mt-auto mb-16 text-center">
          <div class="flex justify-center space-x-6 mb-8">
            <a href="#" class="text-3xl hover:text-gray-300"><i class="fab fa-discord"></i></a>
            <a href="#" class="text-3xl hover:text-gray-300"><i class="fab fa-youtube"></i></a>
          </div>
          <a href="#content" class="inline-block animate-bounce">
            <i class="fas fa-chevron-down text-2xl"></i>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Ana İçerik -->
  <section id="content" class="py-16">
    <div class="container mx-auto px-4">
      <!-- Sistemlerimiz -->
      <div class="flex flex-col md:flex-row items-center mb-20 gap-8">
        <div class="md:w-1/3 flex justify-center">
          <div class="text-5xl text-red-600 p-6 rounded-full bg-[#191919]">
            <i class="fas fa-cogs"></i>
          </div>
        </div>
        <div class="md:w-2/3">
          <h2 class="text-3xl font-bold mb-4">Sistemlerimiz</h2>
          <p class="text-gray-300">
            Linwood Roleplay, gerçekçi bir roleplay deneyimi sunmak için geliştirilmiş özel sistemlere sahiptir. 
            Ekonomi sistemi, meslekler, araç satın alma ve özelleştirme, gayrimenkul, polis ve acil servis sistemleri, 
            telefonlar ve çok daha fazlasını içeren bir roleplay ortamında karakterinizi geliştirebilirsiniz. 
            Her bir sistemimiz, en iyi oyun deneyimini sağlamak için tasarlanmış ve sürekli geliştirilmektedir.
          </p>
        </div>
      </div>

      <!-- Neden Burdayız -->
      <div class="flex flex-col md:flex-row-reverse items-center mb-20 gap-8">
        <div class="md:w-1/3 flex justify-center">
          <div class="text-5xl text-red-600 p-6 rounded-full bg-[#191919]">
            <i class="fas fa-users"></i>
          </div>
        </div>
        <div class="md:w-2/3">
          <h2 class="text-3xl font-bold mb-4">Neden Burdayız</h2>
          <p class="text-gray-300">
            Linwood Roleplay topluluğu olarak amacımız, kaliteli ve gerçekçi bir roleplay ortamı sunarak 
            oyuncularımıza benzersiz bir deneyim sağlamaktır. Deneyimli yönetim ekibimiz ve topluluk odaklı 
            yaklaşımımız ile sürekli kendimizi geliştiriyor, yeni fikirler ve güncellemelerle sunucumuzu 
            daha iyi hale getiriyoruz. Burada sadece bir oyun oynamazsınız; yeni arkadaşlar edinir, karakterinizi 
            geliştirir ve bir topluluğun parçası olursunuz.
          </p>
        </div>
      </div>

      <!-- İstatistikler -->
      <div class="py-10">
        <h2 class="text-3xl font-bold text-center mb-10">İstatistikler</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <!-- Karakter Sayacı -->
          <div class="bg-[#191919] p-6 rounded-lg text-center">
            <div class="text-4xl text-red-600 mb-4">
              <i class="fas fa-user"></i>
            </div>
            <span class="text-3xl font-bold" id="counter-characters">0</span>
            <p class="text-gray-400 mt-2">Aktif Karakter</p>
          </div>
          
          <!-- Whitelist Sayacı -->
          <div class="bg-[#191919] p-6 rounded-lg text-center">
            <div class="text-4xl text-red-600 mb-4">
              <i class="fas fa-check-circle"></i>
            </div>
            <span class="text-3xl font-bold" id="counter-whitelist">0</span>
            <p class="text-gray-400 mt-2">Whitelist</p>
          </div>
          
          <!-- Admin Sayacı -->
          <div class="bg-[#191919] p-6 rounded-lg text-center">
            <div class="text-4xl text-red-600 mb-4">
              <i class="fas fa-shield-alt"></i>
            </div>
            <span class="text-3xl font-bold" id="counter-admins">0</span>
            <p class="text-gray-400 mt-2">Admin</p>
          </div>
          
          <!-- Araç ve Ev Sayacı -->
          <div class="bg-[#191919] p-6 rounded-lg text-center">
            <div class="text-4xl text-red-600 mb-4">
              <i class="fas fa-car"></i>
            </div>
            <span class="text-3xl font-bold" id="counter-properties">0</span>
            <p class="text-gray-400 mt-2">Araç & Ev</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="py-10 bg-black">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-2xl font-bold mb-4">20255 Linwood Roleplay</h2>
      <p class="text-sm text-gray-500">
        © 2025 Linwood Roleplay - Tüm Hakları Saklıdır.
        Bu site sadece rol yapma amaçlı oluşturulmuş oyun topluluğumuza aittir.
      </p>
    </div>
  </footer>

  <!-- JavaScript -->
  <script src="script.js"></script>
</body>
</html>
