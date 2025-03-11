<?php
$page_title = "Kayıt Ol";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php';

// Kayıt formu işleme
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // CSRF token kontrolü
  if (!check_csrf_token($_POST['csrf_token'])) {
    set_error('Güvenlik doğrulaması başarısız oldu! Lütfen sayfayı yenileyip tekrar deneyin.');
  } else {
    // Formdan gelen verileri temizle
    $username = clean_input($_POST['username']);
    $email = clean_input($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $birthdate = clean_input($_POST['birthdate']);
    
    // Zorunlu alanları doğrula
    $fields = ['username' => $username, 'email' => $email, 'password' => $password, 'password_confirm' => $password_confirm, 'birthdate' => $birthdate];
    $required_fields = ['username', 'email', 'password', 'password_confirm', 'birthdate'];
    $errors = validate_form($fields, $required_fields);
    
    // Şifre doğrulama
    if ($password !== $password_confirm) {
      $errors[] = 'Şifreler eşleşmiyor.';
    }
    
    if (strlen($password) < 6) {
      $errors[] = 'Şifre en az 6 karakter olmalıdır.';
    }
    
    // Doğum tarihi doğrulama (18 yaş kontrolü)
    $birth_date = new DateTime($birthdate);
    $today = new DateTime();
    $age = $today->diff($birth_date)->y;
    
    if ($age < 18) {
      $errors[] = 'Kayıt olmak için en az 18 yaşında olmalısınız.';
    }
    
    // Hata yoksa kullanıcıyı kaydet
    if (empty($errors)) {
      try {
        // Kullanıcı adı veya e-posta zaten kullanılıyor mu kontrol et
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
          set_error('Bu kullanıcı adı veya e-posta adresi zaten kullanılıyor.');
        } else {
          // Şifreyi hashle
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);
          
          // Kullanıcıyı veritabanına ekle
          $stmt = $db->prepare("INSERT INTO users (username, email, password, birthdate) VALUES (?, ?, ?, ?)");
          $stmt->execute([$username, $email, $hashed_password, $birthdate]);
          
          set_success('Hesabınız başarıyla oluşturuldu! Şimdi giriş yapabilirsiniz.');
          redirect('login.php');
        }
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
  <div class="container mx-auto px-4 max-w-md">
    <div class="glass-card p-6 md:p-8">
      <div class="text-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold mb-3 section-title-center inline-block">Kayıt Ol</h1>
        <div class="flex justify-center">
          <div class="feature-icon text-3xl sm:text-4xl text-white mb-4">
            <i class="fas fa-user-plus"></i>
          </div>
        </div>
        <p class="text-gray-300 mb-6">Linwood Roleplay'e hoş geldiniz! Hesap oluşturarak karakter başvurusunda bulunabilir ve içeriklere erişebilirsiniz.</p>
      </div>
      
      <form method="POST" action="register.php" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div>
          <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Kullanıcı Adı</label>
          <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-300 mb-1">E-posta</label>
          <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Şifre</label>
          <input type="password" id="password" name="password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
          <p class="text-xs text-gray-400 mt-1">En az 6 karakter olmalıdır.</p>
        </div>
        
        <div>
          <label for="password_confirm" class="block text-sm font-medium text-gray-300 mb-1">Şifre Tekrar</label>
          <input type="password" id="password_confirm" name="password_confirm" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <div>
          <label for="birthdate" class="block text-sm font-medium text-gray-300 mb-1">Doğum Tarihi</label>
          <input type="date" id="birthdate" name="birthdate" value="<?php echo isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
          <p class="text-xs text-gray-400 mt-1">18 yaş ve üzeri olmalısınız.</p>
        </div>
        
        <button type="submit" class="w-full py-2 px-4 btn btn-primary hover-glow font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
          Kayıt Ol
        </button>
      </form>
      
      <div class="mt-5 text-center text-sm">
        <p class="text-gray-400">
          Zaten hesabınız var mı? <a href="login.php" class="text-primary hover:text-red-400">Giriş Yap</a>
        </p>
      </div>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
