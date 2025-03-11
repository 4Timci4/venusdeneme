<?php
$page_title = "Kurallar";
require_once 'session.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor
?>

  <!-- Banner Bölümü -->
  <section class="relative h-[250px] sm:h-[300px] overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://picsum.photos/1920/1080?random=6'); filter: brightness(0.4); transform: scale(1.05);"></div>
    <div class="absolute inset-0 flex items-center justify-center">
      <div class="text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4 hero-title">
          <span class="hero-title-accent">Sunucu Kuralları</span>
        </h1>
        <p class="hero-description text-lg max-w-2xl mx-auto px-4">Linwood Roleplay sunucusunda keyifli bir deneyim için uymanız gereken kurallar</p>
      </div>
    </div>
  </section>

  <!-- Ana İçerik -->
  <section class="py-12 sm:py-16 md:py-20 content-section">
    <div class="container mx-auto px-4">
      <div class="max-w-4xl mx-auto">
        <!-- Giriş -->
        <div class="mb-12 fade-in-up text-center">
          <h2 class="text-2xl sm:text-3xl font-bold mb-6 section-title-center">Kurallara Genel Bakış</h2>
          <p class="text-gray-300 leading-relaxed mb-6">
            Linwood Roleplay sunucusunda, gerçekçi bir roleplay deneyimi sağlamak ve herkesin eşit şartlarda eğlenceli zaman geçirmesini sağlamak için belirli kurallara uyulması zorunludur. Bu kurallar sunucumuzun temelini oluşturur ve tüm oyuncularımız tarafından bilinmeli ve uygulanmalıdır.
          </p>
          <p class="text-gray-300 leading-relaxed">
            Aşağıdaki kurallara uymayan oyuncular uyarı alabilir, geçici olarak engellenebilir veya kalıcı olarak sunucudan yasaklanabilir. Kurallarımız hakkında sorularınız varsa, Discord sunucumuzda yetkililerle iletişime geçebilirsiniz.
          </p>
        </div>

        <!-- Genel Kurallar -->
        <div class="glass-card p-6 mb-10 fade-in-left">
          <div class="flex items-center mb-4">
            <div class="feature-icon text-3xl sm:text-4xl text-white mr-4" style="width: 60px; height: 60px;">
              <i class="fas fa-gavel"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold">Genel Kurallar</h3>
          </div>
          <ul class="space-y-3 text-gray-300">
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Tüm oyunculara saygılı davranın. Hakaret, ayrımcılık ve taciz kesinlikle yasaktır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Roleplay'i bozan davranışlardan kaçının (OOC konuşma, metagaming, powergaming).</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Sunucu veya oyun hatalarını kötüye kullanmayın. Bulduğunuz hataları yetkililere bildirin.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Yetkililerin talimatlarına uyun ve anlaşmazlıklarda saygılı bir şekilde iletişim kurun.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Birden fazla karakterle oynayarak ekonomik avantaj elde etmeye çalışmak yasaktır.</span>
            </li>
          </ul>
        </div>

        <!-- Roleplay Kuralları -->
        <div class="glass-card p-6 mb-10 fade-in-right">
          <div class="flex items-center mb-4">
            <div class="feature-icon text-3xl sm:text-4xl text-white mr-4" style="width: 60px; height: 60px;">
              <i class="fas fa-theater-masks"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold">Roleplay Kuralları</h3>
          </div>
          <ul class="space-y-3 text-gray-300">
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Her zaman karakterinizin rolünde kalın. OOC (Out of Character) konuşmalarını yalnızca uygun kanallarda yapın.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Metagaming (oyun dışı bilgileri karakterinizin bilgisi olarak kullanmak) yasaktır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Powergaming (karakterinize gerçekçi olmayan yetenekler atfetmek) yasaktır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Karakter ölümlerinde roleplay'e uygun davranın. Öldükten sonra aynı olayı hatırlamazsınız.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Gerçekçi roleplay yapın. Karakteriniz bir süper kahraman değildir.</span>
            </li>
          </ul>
        </div>

        <!-- Trafik ve Araç Kuralları -->
        <div class="glass-card p-6 mb-10 fade-in-left">
          <div class="flex items-center mb-4">
            <div class="feature-icon text-3xl sm:text-4xl text-white mr-4" style="width: 60px; height: 60px;">
              <i class="fas fa-car"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold">Trafik ve Araç Kuralları</h3>
          </div>
          <ul class="space-y-3 text-gray-300">
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Gerçekçi sürüş yapın. Aşırı hız ve gerçekçi olmayan manevralardan kaçının.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Araç çalma veya gasp etme gibi olaylarda mutlaka düzgün roleplay yapın.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Sürüş esnasında aşırı kaza yapmak veya kasti olarak oyuncuları rahatsız etmek yasaktır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Araçlarınızı uygun olmayan yerlere park etmeyin.</span>
            </li>
          </ul>
        </div>

        <!-- Suç ve Polis Kuralları -->
        <div class="glass-card p-6 fade-in-right">
          <div class="flex items-center mb-4">
            <div class="feature-icon text-3xl sm:text-4xl text-white mr-4" style="width: 60px; height: 60px;">
              <i class="fas fa-balance-scale"></i>
            </div>
            <h3 class="text-xl sm:text-2xl font-bold">Suç ve Polis Kuralları</h3>
          </div>
          <ul class="space-y-3 text-gray-300">
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Suç aktivitelerini gerçekçi bir şekilde roleplay edin. Her suç için bir motivasyon ve plan olmalıdır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Polis memurlarına saygılı davranın, kelepçelendiğinizde veya tutuklandığınızda roleplay'i bozacak hareketler yapmayın.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>RDM (Random Death Match) ve VDM (Vehicle Death Match) kesinlikle yasaktır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Polis memurları görevlerini adil ve kurallara uygun şekilde yapmalıdır.</span>
            </li>
            <li class="flex items-start">
              <i class="fas fa-check text-red-600 mt-1 mr-3"></i>
              <span>Oyuncular arasındaki anlaşmazlıkları çözmek için /report komutunu kullanın ve yetkililerin müdahalesini bekleyin.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- Stil -->
  <style>
    .feature-icon.pulse {
      animation: pulse 0.8s ease-in-out;
    }
    
    .glass-card {
      cursor: pointer;
    }
    
    .glass-card:hover .glass-card-title {
      color: var(--color-primary);
    }
  </style>

<?php require_once 'footer.php'; ?>
