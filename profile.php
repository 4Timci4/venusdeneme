<?php
$page_title = "Profil";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php';

// Oturum kontrolü - sadece giriş yapan kullanıcılar erişebilir
require_login();

// Kullanıcı verilerini veritabanından çekme
$user_id = $_SESSION['user_id'];
$user = get_user_by_id($db, $user_id);

// Kullanıcı karakterlerini çekme
$characters = get_user_characters($db, $user_id);

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
  <div class="container mx-auto px-4 max-w-4xl">
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
            <p class="text-gray-400 text-sm mt-2">Üye: <?php echo date('d/m/Y', strtotime($user['registration_date'])); ?></p>
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
              <input type="date" id="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none transition" disabled>
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
    
    <!-- Karakterler -->
    <div class="glass-card p-6 md:p-8">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl md:text-2xl font-bold section-title inline-block">Karakterlerim</h2>
        <a href="basvuru.php" class="btn btn-outline hover-glow text-sm">Yeni Karakter Başvurusu</a>
      </div>
      
      <?php if (empty($characters)): ?>
      <div class="text-center py-10">
        <div class="text-4xl text-gray-600 mb-4">
          <i class="far fa-meh"></i>
        </div>
        <p class="text-gray-400">Henüz oluşturulmuş karakteriniz bulunmuyor.</p>
        <a href="basvuru.php" class="btn btn-primary hover-glow text-sm mt-4">Karakter Başvurusu Yap</a>
      </div>
      <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <?php foreach ($characters as $character): ?>
            <div class="bg-gray-800 p-4 rounded-lg hover:bg-gray-700 transition">
              <div class="flex justify-between items-start">
                <h3 class="text-lg font-semibold">
                  <?php echo htmlspecialchars($character['character_name']); ?>
                </h3>
                <span class="px-2 py-1 text-xs rounded 
                  <?php 
                    echo $character['status'] === 'approved' ? 'bg-green-900 text-green-300' : 
                         ($character['status'] === 'rejected' ? 'bg-red-900 text-red-300' : 
                         'bg-yellow-900 text-yellow-300'); 
                  ?>">
                  <?php 
                    echo $character['status'] === 'approved' ? 'Onaylandı' : 
                         ($character['status'] === 'rejected' ? 'Reddedildi' : 
                         'İnceleniyor'); 
                  ?>
                </span>
              </div>
              <p class="text-gray-400 mt-2 text-sm">
                <?php 
                  // Karakter bilgilerinden kısa bir özet göster
                  $info = $character['character_info'];
                  echo htmlspecialchars(strlen($info) > 100 ? substr($info, 0, 100) . '...' : $info); 
                ?>
              </p>
              <div class="mt-3 flex justify-between text-xs text-gray-500">
                <span>Oluşturulma: <?php echo date('d/m/Y', strtotime($character['created_at'])); ?></span>
                <a href="character.php?id=<?php echo $character['id']; ?>" class="text-primary hover:text-red-400">Detaylar</a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
