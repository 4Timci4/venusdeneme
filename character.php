<?php
$page_title = "Karakter Detayları";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php';

// Oturum kontrolü - sadece giriş yapan kullanıcılar erişebilir
require_login();

// Karakter ID'sini al
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  set_error('Geçersiz karakter ID\'si.');
  redirect('profile.php');
}

$character_id = (int)$_GET['id'];
$user_id = $_SESSION['user_id'];

try {
  // Karakteri ve kullanıcı bilgisini getir
  $stmt = $db->prepare("
    SELECT c.*, u.username 
    FROM characters c 
    JOIN users u ON c.user_id = u.id 
    WHERE c.id = ?
  ");
  $stmt->execute([$character_id]);
  $character = $stmt->fetch();
  
  // Karakter bulunamadıysa veya başka bir kullanıcıya aitse
  if (!$character || $character['user_id'] != $user_id) {
    set_error('Bu karakteri görüntüleme yetkiniz yok veya karakter bulunamadı.');
    redirect('profile.php');
  }
  
} catch (PDOException $e) {
  set_error('Veritabanı hatası: ' . $e->getMessage());
  redirect('profile.php');
}

// Karakter durumu sınıfları
$status_classes = [
  'pending' => 'bg-yellow-900 text-yellow-300',
  'approved' => 'bg-green-900 text-green-300',
  'rejected' => 'bg-red-900 text-red-300'
];

// Karakter durumu metinleri
$status_texts = [
  'pending' => 'İnceleniyor',
  'approved' => 'Onaylandı',
  'rejected' => 'Reddedildi'
];
?>

<section class="py-12 sm:py-16 fade-in-up">
  <div class="container mx-auto px-4 max-w-4xl">
    <div class="glass-card p-6 md:p-8 mb-6">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
        <div>
          <h1 class="text-2xl md:text-3xl font-bold mb-1 section-title inline-block">
            <?php echo htmlspecialchars($character['character_name']); ?>
          </h1>
          <p class="text-sm text-gray-400">
            Oluşturulma: <?php echo date('d/m/Y H:i', strtotime($character['created_at'])); ?>
          </p>
        </div>
        <div class="mt-4 md:mt-0">
          <span class="px-3 py-1 rounded-full text-sm font-medium <?php echo $status_classes[$character['status']]; ?>">
            <?php echo $status_texts[$character['status']]; ?>
          </span>
        </div>
      </div>
      
      <div class="bg-gray-800 rounded-lg p-5 mb-6">
        <div class="flex justify-between items-center mb-3">
          <h3 class="font-semibold text-lg">Karakter Bilgileri</h3>
          <?php if ($character['status'] != 'approved'): ?>
          <a href="basvuru.php" class="text-sm text-primary hover:text-red-400">
            <i class="fas fa-edit mr-1"></i> Yeni Karakter Oluştur
          </a>
          <?php endif; ?>
        </div>
        <div class="prose prose-sm max-w-none text-gray-300 whitespace-pre-line">
          <?php echo nl2br(htmlspecialchars($character['character_info'])); ?>
        </div>
      </div>
      
      <?php if ($character['status'] == 'rejected'): ?>
      <div class="bg-red-900 bg-opacity-30 border border-red-800 rounded-lg p-4 mb-4">
        <h3 class="font-semibold text-lg text-red-300 mb-2">
          <i class="fas fa-exclamation-circle mr-2"></i> Red Nedeni
        </h3>
        <p class="text-gray-300">
          Bu karakteriniz, topluluk kurallarına veya karakter geliştirme standartlarımıza uygun bulunmadığından reddedilmiştir. Lütfen daha detaylı bir karakter geçmişi oluşturun ve tekrar deneyin.
        </p>
      </div>
      <?php endif; ?>
      
      <div class="flex justify-between items-center mt-6">
        <a href="profile.php" class="btn btn-outline hover-glow text-sm">
          <i class="fas fa-arrow-left mr-2"></i> Profile Dön
        </a>
        
        <?php if ($character['status'] == 'approved'): ?>
        <span class="text-green-400 text-sm">
          <i class="fas fa-check-circle mr-1"></i> Bu karakter onaylanmıştır. Oyuna giriş yapabilirsiniz.
        </span>
        <?php endif; ?>
      </div>
    </div>
    
    <?php if ($character['status'] == 'pending'): ?>
    <div class="bg-gray-900 border border-gray-800 rounded-lg p-6 text-center">
      <div class="text-3xl text-yellow-500 mb-4">
        <i class="fas fa-hourglass-half"></i>
      </div>
      <h3 class="text-xl font-semibold mb-2">Başvurunuz İnceleniyor</h3>
      <p class="text-gray-400 mb-4">
        Karakter başvurunuz şu anda administrasyon ekibimiz tarafından incelenmektedir. Bu süreç genellikle 24-48 saat içinde tamamlanır.
      </p>
      <div class="loader mx-auto mb-4"></div>
      <p class="text-sm text-gray-500">Sabırla beklediğiniz için teşekkür ederiz.</p>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php require_once 'footer.php'; ?>
