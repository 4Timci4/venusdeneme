<?php
$page_title = "Karakter Başvurusu";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php';

// Oturum kontrolü - sadece giriş yapan kullanıcılar erişebilir
require_login();

// Kullanıcı ID
$user_id = $_SESSION['user_id'];

// Başvuru formu işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // CSRF token kontrolü
  if (!check_csrf_token($_POST['csrf_token'])) {
    set_error('Güvenlik doğrulaması başarısız oldu! Lütfen sayfayı yenileyip tekrar deneyin.');
  } else {
    // Formdan gelen verileri temizle
    $character_name = clean_input($_POST['character_name']);
    $character_info = clean_input($_POST['character_info']);
    
    // Zorunlu alanları doğrula
    $fields = ['character_name' => $character_name, 'character_info' => $character_info];
    $required_fields = ['character_name', 'character_info'];
    $errors = validate_form($fields, $required_fields);
    
    // Hata yoksa karakter başvurusunu kaydet
    if (empty($errors)) {
      try {
        // Karakter başvurusunu veritabanına ekle
        $stmt = $db->prepare("INSERT INTO characters (user_id, character_name, character_info, status) VALUES (?, ?, ?, 'pending')");
        $stmt->execute([$user_id, $character_name, $character_info]);
        
        set_success('Karakter başvurunuz başarıyla gönderildi! En kısa sürede incelenecektir.');
        redirect('profile.php');
      } catch (PDOException $e) {
        set_error('Veritabanı hatası: ' . $e->getMessage());
      }
    } else {
      // Hata mesajlarını session'a kaydet
      set_error(implode('<br>', $errors));
    }
  }
}
?>

<section class="py-12 sm:py-16 fade-in-up">
  <div class="container mx-auto px-4 max-w-4xl">
    <div class="glass-card p-6 md:p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 section-title-center inline-block">Karakter Başvurusu</h1>
        <div class="flex justify-center">
          <div class="feature-icon text-3xl sm:text-4xl text-white mb-4">
            <i class="fas fa-user-plus"></i>
          </div>
        </div>
        <p class="text-gray-300 mb-6">Linwood Roleplay'de oynamak istediğiniz karakterin bilgilerini girin.</p>
      </div>
      
      <form method="POST" action="basvuru.php" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div>
          <label for="character_name" class="block text-sm font-medium text-gray-300 mb-1">Karakter Adı</label>
          <input type="text" id="character_name" name="character_name" value="<?php echo isset($_POST['character_name']) ? htmlspecialchars($_POST['character_name']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
          <p class="text-xs text-gray-400 mt-1">Ad ve soyad formatında olmalıdır. Örn: John Doe</p>
        </div>
        
        <div>
          <label for="character_info" class="block text-sm font-medium text-gray-300 mb-1">Karakter Bilgileri</label>
          <textarea id="character_info" name="character_info" rows="10" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required><?php echo isset($_POST['character_info']) ? htmlspecialchars($_POST['character_info']) : ''; ?></textarea>
          <p class="text-xs text-gray-400 mt-1">Karakterinizin geçmişi, kişiliği, yaşam tarzı ve motivasyonlarını detaylı olarak açıklayın. (Minimum 200 karakter)</p>
        </div>
        
        <div class="p-4 bg-gray-800 rounded-md border border-gray-700">
          <h3 class="font-semibold mb-2">Başvuru İpuçları</h3>
          <ul class="list-disc list-inside text-sm text-gray-300 space-y-1">
            <li>Karakterinizin geçmişini detaylı olarak anlatın.</li>
            <li>Karakterinizin kişilik özelliklerini belirtin.</li>
            <li>Karakterinizin hedefleri ve motivasyonlarını açıklayın.</li>
            <li>Rolünüzü server kurallarına uygun şekilde oynayacağınızı belirtin.</li>
          </ul>
        </div>
        
        <button type="submit" class="w-full py-2 px-4 btn btn-primary hover-glow font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
          Başvuruyu Gönder
        </button>
      </form>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
