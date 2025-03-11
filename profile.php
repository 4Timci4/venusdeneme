<?php
$page_title = "Profil";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor

// Oturum kontrolü - sadece giriş yapan kullanıcılar erişebilir
require_login();

// Kullanıcı verilerini veritabanından çekme
$user_id = $_SESSION['user_id'];
$user = get_user_by_id($db, $user_id);

// Profil güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
  // CSRF token kontrolü
  if (!check_csrf_token($_POST['csrf_token'])) {
    set_error('Güvenlik doğrulaması başarısız oldu! Lütfen sayfayı yenileyip tekrar deneyin.');
  } else {
    // Formdan gelen verileri temizle
    $email = clean_input($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $new_password_confirm = $_POST['new_password_confirm'];
    
    // Zorunlu alanları doğrula
    $fields = ['email' => $email];
    $required_fields = ['email'];
    $errors = validate_form($fields, $required_fields);
    
    // Mevcut şifre değişikliği kontrol etme
    if (!empty($current_password)) {
      // Mevcut şifreyi doğrula
      $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
      $stmt->execute([$user_id]);
      $user_data = $stmt->fetch();
      
      if (!password_verify($current_password, $user_data['password'])) {
        $errors[] = 'Mevcut şifre doğru değil.';
      } else if (!empty($new_password)) {
        // Yeni şifre kontrolü
        if (strlen($new_password) < 6) {
          $errors[] = 'Yeni şifre en az 6 karakter olmalıdır.';
        }
        
        if ($new_password !== $new_password_confirm) {
          $errors[] = 'Yeni şifreler eşleşmiyor.';
        }
      }
    }
    
    // Hata yoksa profili güncelle
    if (empty($errors)) {
      try {
        // E-posta güncelleme
        $stmt = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->execute([$email, $user_id]);
        
        // Şifre güncellemesi varsa
        if (!empty($new_password) && !empty($current_password)) {
          $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
          $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
          $stmt->execute([$hashed_password, $user_id]);
        }
        
        set_success('Profil bilgileriniz başarıyla güncellendi.');
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
  <div class="container mx-auto px-4 max-w-7xl">
    <div class="flex flex-col md:flex-row gap-6">
      <!-- Sidebar -->
      <div class="md:w-1/4 lg:w-1/5 mb-6 md:mb-0">
        <div class="glass-card p-4 md:p-6">
          <!-- Kullanıcı Bilgisi -->
          <div class="text-center mb-6">
            <div class="text-4xl mb-3 text-primary">
              <i class="fas fa-user-circle"></i>
            </div>
            <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($user['username']); ?></h3>
            <p class="text-gray-400 text-sm mt-2">
              <?php if (is_admin()): ?>
                <span class="bg-primary px-2 py-0.5 rounded text-white text-xs">Yönetici</span>
              <?php else: ?>
                Üye
              <?php endif; ?>
            </p>
          </div>
          
          <!-- Sidebar Menü -->
          <div class="space-y-2">
            <a href="profile.php" class="sidebar-item flex items-center p-3 rounded-md bg-gray-800 text-white transition-colors">
              <i class="fas fa-user mr-3 w-5 text-center"></i>
              <span>Profil</span>
            </a>
            <?php if (is_admin()): ?>
            <a href="player_stats.php" class="sidebar-item flex items-center p-3 rounded-md bg-transparent text-white transition-colors">
              <i class="fas fa-chart-bar mr-3 w-5 text-center"></i>
              <span>Oyuncu İstatistikleri</span>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      
      <!-- Ana içerik -->
      <div class="md:w-3/4 lg:w-4/5">
        <div class="glass-card p-6 md:p-8 mb-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 section-title-center inline-block">Profil Bilgileri</h1>
        <div class="flex justify-center">
          <div class="feature-icon text-3xl sm:text-4xl text-white mb-4">
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
      </div>
      
      <div class="md:grid md:grid-cols-6 gap-6 mb-6">
        <div class="col-span-2 mb-4 md:mb-0">
          <div class="text-center p-4 bg-gray-800 rounded-lg">
            <div class="text-5xl mb-3 text-primary">
              <i class="fas fa-user"></i>
            </div>
            <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($user['username']); ?></h3>
            <p class="text-gray-400 text-sm mt-2">Üyelik Tarihi: <?php echo isset($user['registration_date']) ? date('d/m/Y', strtotime($user['registration_date'])) : '01/01/1970'; ?></p>
          </div>
        </div>
        
        <div class="col-span-4">
          <form method="POST" action="profile.php" class="space-y-4">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="update_profile" value="1">
            
            <div>
              <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Kullanıcı Adı</label>
              <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none transition" disabled>
              <p class="text-xs text-gray-400 mt-1">Kullanıcı adı değiştirilemez.</p>
            </div>
            
            <div>
              <label for="email" class="block text-sm font-medium text-gray-300 mb-1">E-posta</label>
              <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
            </div>
            
            <div>
              <label for="birthdate" class="block text-sm font-medium text-gray-300 mb-1">Doğum Tarihi</label>
              <input type="text" id="birthdate" value="<?php echo isset($user['birthdate']) ? date('d/m/Y', strtotime($user['birthdate'])) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none transition" disabled>
              <p class="text-xs text-gray-400 mt-1">Doğum tarihi değiştirilemez.</p>
            </div>
            
            <hr class="border-gray-700 my-4">
            <h4 class="font-semibold mb-2">Şifre Değiştirme <span class="text-xs text-gray-400">(isteğe bağlı)</span></h4>
            
            <div>
              <label for="current_password" class="block text-sm font-medium text-gray-300 mb-1">Mevcut Şifre</label>
              <input type="password" id="current_password" name="current_password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
            </div>
            
            <div>
              <label for="new_password" class="block text-sm font-medium text-gray-300 mb-1">Yeni Şifre</label>
              <input type="password" id="new_password" name="new_password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
              <p class="text-xs text-gray-400 mt-1">En az 6 karakter olmalıdır.</p>
            </div>
            
            <div>
              <label for="new_password_confirm" class="block text-sm font-medium text-gray-300 mb-1">Yeni Şifre Tekrar</label>
              <input type="password" id="new_password_confirm" name="new_password_confirm" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
            </div>
            
            <button type="submit" class="w-full py-2 px-4 btn btn-primary hover-glow font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
              Profili Güncelle
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
