<?php
$page_title = "Kayıt Ol";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php'; // Bu header.php artık includes/header.php'yi dahil ediyor

// Kullanıcı zaten giriş yapmışsa profile sayfasına yönlendir
if (is_logged_in()) {
  redirect('profile.php');
}

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
    $fields = [
      'username' => $username, 
      'email' => $email, 
      'password' => $password,
      'password_confirm' => $password_confirm,
      'birthdate' => $birthdate
    ];
    $required_fields = ['username', 'email', 'password', 'password_confirm', 'birthdate'];
    $errors = validate_form($fields, $required_fields);
    
    // Özel doğrulama kuralları
    if (strlen($username) < 3) {
      $errors[] = 'Kullanıcı adı en az 3 karakter olmalıdır.';
    }
    
    if (strlen($password) < 6) {
      $errors[] = 'Şifre en az 6 karakter olmalıdır.';
    }
    
    if ($password !== $password_confirm) {
      $errors[] = 'Şifreler eşleşmiyor.';
    }
    
    // Doğum tarihi kontrolü
    $birthdate_obj = DateTime::createFromFormat('Y-m-d', $birthdate);
    $now = new DateTime();
    $age = $now->diff($birthdate_obj)->y;
    
    if (!$birthdate_obj || $birthdate_obj->format('Y-m-d') !== $birthdate) {
      $errors[] = 'Geçerli bir doğum tarihi giriniz.';
    } elseif ($age < 13) {
      $errors[] = 'Kayıt olmak için en az 13 yaşında olmalısınız.';
    }
    
    // Hata yoksa kullanıcıyı kaydet
    if (empty($errors)) {
      try {
        // Kullanıcı adının benzersiz olup olmadığını kontrol et
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetchColumn() > 0) {
          set_error('Bu kullanıcı adı zaten kullanılıyor. Lütfen başka bir kullanıcı adı seçin.');
        } else {
          // E-posta adresinin benzersiz olup olmadığını kontrol et
          $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
          $stmt->execute([$email]);
          if ($stmt->fetchColumn() > 0) {
            set_error('Bu e-posta adresi zaten kullanılıyor. Lütfen başka bir e-posta adresi girin.');
          } else {
            // Şifreyi hashle
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Yeni kullanıcıyı veritabanına ekle
            $stmt = $db->prepare("INSERT INTO users (username, email, password, birthdate) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$username, $email, $hashed_password, $birthdate]);
            
            if ($result) {
              // Kullanıcı başarıyla oluşturuldu, giriş yap
              $user_id = $db->lastInsertId();
              $_SESSION['user_id'] = $user_id;
              $_SESSION['username'] = $username;
              $_SESSION['is_admin'] = false;
              
              set_success('Hesabınız başarıyla oluşturuldu! Hoş geldiniz, ' . $username . '!');
              redirect('profile.php');
            } else {
              set_error('Kayıt sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
            }
          }
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
        <p class="text-gray-300 mb-6">Linwood Roleplay'e kayıt olarak karakter başvurusunda bulunabilir ve sunucumuza katılabilirsiniz.</p>
      </div>
      
      <form method="POST" action="register.php" class="space-y-4">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        
        <div>
          <label for="username" class="block text-sm font-medium text-gray-300 mb-1">Kullanıcı Adı</label>
          <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
          <p class="text-xs text-gray-400 mt-1">En az 3 karakter olmalıdır</p>
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-300 mb-1">E-posta Adresi</label>
          <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Şifre</label>
          <input type="password" id="password" name="password" autocomplete="new-password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
          <p class="text-xs text-gray-400 mt-1">En az 6 karakter olmalıdır</p>
        </div>
        
        <div>
          <label for="password_confirm" class="block text-sm font-medium text-gray-300 mb-1">Şifre Tekrarı</label>
          <input type="password" id="password_confirm" name="password_confirm" autocomplete="new-password" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required>
        </div>
        
        <div>
          <label for="birthdate" class="block text-sm font-medium text-gray-300 mb-1">Doğum Tarihi</label>
          <input type="date" id="birthdate" name="birthdate" value="<?php echo isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required placeholder="yyyy-mm-dd">
          <p class="text-xs text-gray-400 mt-1">Kayıt olmak için en az 13 yaşında olmalısınız</p>
        </div>
        
        <div class="bg-gray-800/60 rounded-md p-4 border border-gray-700">
          <div class="flex items-start">
            <div class="flex-shrink-0 mt-0.5">
              <i class="fas fa-shield-alt text-primary"></i>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-gray-200">Hesap Güvenliği</h3>
              <div class="mt-2 text-sm text-gray-400">
                <p>Güçlü bir şifre oluşturun ve kimseyle paylaşmayın. E-posta adresiniz hesap kurtarma için kullanılacaktır.</p>
              </div>
            </div>
          </div>
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
