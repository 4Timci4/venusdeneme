<?php
$page_title = "Market";
require_once 'session.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor
?>

  <!-- Banner Bölümü -->
  <section class="relative h-[250px] sm:h-[300px] overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://picsum.photos/1920/1080?random=3'); filter: brightness(0.4);"></div>
    <div class="absolute inset-0 flex items-center justify-center">
      <div class="text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4 hero-title">
          <span class="hero-title-accent">Market</span>
        </h1>
        <p class="hero-description text-lg max-w-2xl mx-auto px-4">Sunucumuza destek olmak ve özel içeriklere erişmek için market</p>
      </div>
    </div>
  </section>

  <!-- Ana İçerik -->
  <section class="py-12 sm:py-16 md:py-20 content-section">
    <div class="container mx-auto px-4">
      <!-- Market Bilgilendirme -->
      <div class="max-w-4xl mx-auto mb-12 text-center fade-in-up">
        <h2 class="text-2xl sm:text-3xl font-bold mb-6 section-title-center">Sunucumuza Nasıl Destek Olabilirsiniz?</h2>
        <p class="text-gray-300 leading-relaxed mb-6">
          Linwood Roleplay sunucusu, giderlerini karşılamak ve daha iyi bir oyun deneyimi sunabilmek için 
          oyuncularından gelen desteklere ihtiyaç duyar. Aşağıdaki paketlerden birini satın alarak sunucumuza 
          destek olabilir ve özel içeriklere erişim sağlayabilirsiniz.
        </p>
        <p class="text-gray-300 leading-relaxed">
          Satın aldığınız her paket, oyun içi ekonomiyi etkilemeden size özel kozmetik ürünler, isim renkleri, 
          özel araçlar ve daha fazlasını sağlar. Sunucumuzda pay-to-win sistemine kesinlikle izin verilmez.
        </p>
        <div class="mt-6">
          <a href="#packages" class="btn btn-primary hover-glow text-sm sm:text-base">Paketleri Görüntüle</a>
        </div>
      </div>

      <!-- Paketler -->
      <div id="packages" class="py-8">
        <h2 class="text-2xl sm:text-3xl font-bold mb-10 text-center section-title-center">Paketlerimiz</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
          <!-- Başlangıç Paketi -->
          <div class="pricing-card glass-card p-6 hover-float">
            <div class="text-center mb-6">
              <div class="flex justify-center mb-4">
                <div class="package-icon w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center">
                  <i class="fas fa-car-side text-2xl text-red-500"></i>
                </div>
              </div>
              <h3 class="text-xl font-bold mb-2">Başlangıç Paketi</h3>
              <div class="text-3xl font-bold text-primary mt-4 mb-2">₺250</div>
              <div class="text-sm text-gray-400 mb-6">Tek seferlik ödeme</div>
            </div>
            
            <ul class="space-y-3 mb-6">
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>1 adet özel araç (listeden seçim)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Discord rolü: 'Destekçi'</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Sohbette renkli isim (Yeşil)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>100,000$ başlangıç parası</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>VIP sırası (öncelikli giriş)</span>
              </li>
            </ul>
            
            <a href="#" class="btn btn-outline w-full text-center">Satın Al</a>
          </div>
          
          <!-- Premium Paketi -->
          <div class="pricing-card glass-card p-6 hover-float relative z-10 transform scale-105 border-2 border-primary">
            <div class="absolute -top-4 left-0 right-0 text-center">
              <span class="bg-primary text-white text-xs px-4 py-1 rounded-full uppercase font-bold tracking-wider">En Popüler</span>
            </div>
            <div class="text-center mb-6">
              <div class="flex justify-center mb-4">
                <div class="package-icon w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center">
                  <i class="fas fa-crown text-2xl text-yellow-500"></i>
                </div>
              </div>
              <h3 class="text-xl font-bold mb-2">Premium Paketi</h3>
              <div class="text-3xl font-bold text-primary mt-4 mb-2">₺500</div>
              <div class="text-sm text-gray-400 mb-6">Tek seferlik ödeme</div>
            </div>
            
            <ul class="space-y-3 mb-6">
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>3 adet özel araç (listeden seçim)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>1 adet özel ev</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Discord rolü: 'Premium Üye'</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Sohbette renkli isim (Mavi)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>250,000$ başlangıç parası</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>VIP sırası (öncelikli giriş)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Özel kıyafet ve aksesuar paketi</span>
              </li>
            </ul>
            
            <a href="#" class="btn btn-primary w-full text-center hover-glow">Satın Al</a>
          </div>
          
          <!-- VIP Paketi -->
          <div class="pricing-card glass-card p-6 hover-float">
            <div class="text-center mb-6">
              <div class="flex justify-center mb-4">
                <div class="package-icon w-16 h-16 rounded-full bg-gray-800 flex items-center justify-center">
                  <i class="fas fa-gem text-2xl text-purple-500"></i>
                </div>
              </div>
              <h3 class="text-xl font-bold mb-2">VIP Paketi</h3>
              <div class="text-3xl font-bold text-primary mt-4 mb-2">₺1000</div>
              <div class="text-sm text-gray-400 mb-6">Tek seferlik ödeme</div>
            </div>
            
            <ul class="space-y-3 mb-6">
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>5 adet özel araç (tüm listeden)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>2 adet özel ev (premium lokasyonlar)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Discord rolü: 'VIP Üye'</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Sohbette renkli isim (Mor)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>500,000$ başlangıç parası</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>VIP sırası (en yüksek öncelik)</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Tüm özel kıyafet ve aksesuarlar</span>
              </li>
              <li class="flex items-start">
                <i class="fas fa-check text-green-500 mt-1 mr-3"></i>
                <span>Özel plaka ve telefon numarası</span>
              </li>
            </ul>
            
            <a href="#" class="btn btn-outline w-full text-center">Satın Al</a>
          </div>
        </div>
      </div>
      
      <!-- Ödeme Bilgileri -->
      <div class="max-w-4xl mx-auto mt-16 fade-in-up">
        <div class="glass-card p-6">
          <h3 class="text-xl font-bold mb-4">Ödeme Bilgileri</h3>
          <p class="text-gray-300 mb-4">
            Paketlerimizi satın almak için Discord sunucumuza katılmanız ve destek ekibimizle iletişime geçmeniz gerekmektedir. 
            Ödeme işlemleriniz güvenli bir şekilde gerçekleştirilecek ve satın alma işleminiz tamamlandıktan sonra 
            en geç 24 saat içinde hesabınıza tanımlanacaktır.
          </p>
          
          <div class="bg-gray-800 p-4 rounded-lg mb-4">
            <h4 class="font-semibold mb-2">Kabul Edilen Ödeme Yöntemleri:</h4>
            <div class="flex flex-wrap gap-3">
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><i class="fab fa-cc-visa mr-1"></i> Visa</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><i class="fab fa-cc-mastercard mr-1"></i> Mastercard</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><i class="fab fa-paypal mr-1"></i> PayPal</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><i class="fas fa-credit-card mr-1"></i> Havale/EFT</span>
              <span class="bg-gray-700 px-3 py-1 rounded-full text-sm"><i class="fab fa-bitcoin mr-1"></i> Kripto Para</span>
            </div>
          </div>
          
          <p class="text-sm text-gray-400">
            Not: Tüm ödemeleriniz SSL sertifikalı güvenli sistemler üzerinden gerçekleştirilmektedir. 
            Satın aldığınız paketler iade edilemez. Herhangi bir sorun yaşarsanız destek ekibimizle iletişime geçebilirsiniz.
          </p>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'footer.php'; ?>
