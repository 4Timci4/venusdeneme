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
    
    // Doğum tarihi kontrolü - GG/AA/YYYY formatını ve geçerliliğini kontrol et
    if (!preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $birthdate, $matches)) {
      $errors[] = 'Geçerli bir doğum tarihi giriniz (GG/AA/YYYY formatında).';
    } else {
      $day = (int)$matches[1];
      $month = (int)$matches[2];
      $year = (int)$matches[3];
      $currentYear = (int)date('Y');
      
      // Tarih değerlerinin geçerli aralıklarda olup olmadığını kontrol et
      if ($year < 1900 || $year > $currentYear) {
        $errors[] = 'Geçerli bir yıl giriniz (1900-' . $currentYear . ' arasında).';
      } elseif ($month < 1 || $month > 12) {
        $errors[] = 'Geçerli bir ay giriniz (1-12 arasında).';
      } elseif ($day < 1 || $day > 31) {
        $errors[] = 'Geçerli bir gün giriniz (1-31 arasında).';
      } else {
        // Ay başına düşen gün sayısını kontrol et
        $monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        
        // Artık yıl kontrolü
        if (($year % 4 === 0 && $year % 100 !== 0) || $year % 400 === 0) {
          $monthLengths[1] = 29;
        }
        
        if ($day > $monthLengths[$month - 1]) {
          $errors[] = $month . '. ay için geçerli bir gün giriniz (en fazla ' . $monthLengths[$month - 1] . ' gün).';
        } else {
          // Tarih geçerli, DateTime nesnesi oluştur
          $birthdate_obj = DateTime::createFromFormat('d/m/Y', $birthdate);
          $now = new DateTime();
          $age = $now->diff($birthdate_obj)->y;
          
          // Girilen tarih ile oluşturulan nesnenin tarihi aynı mı? (taşma kontrolü)
          if ($birthdate_obj->format('d/m/Y') !== $birthdate) {
            $errors[] = 'Geçerli bir doğum tarihi giriniz (GG/AA/YYYY formatında).';
          } elseif ($age < 13) {
            $errors[] = 'Kayıt olmak için en az 13 yaşında olmalısınız.';
          }
        }
      }
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
            
            // Doğum tarihini veritabanı formatına dönüştür (YYYY-MM-DD)
            $db_birthdate = $birthdate_obj->format('Y-m-d');
            
            // Yeni kullanıcıyı veritabanına ekle
            $stmt = $db->prepare("INSERT INTO users (username, email, password, birthdate) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$username, $email, $hashed_password, $db_birthdate]);
            
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
    <style>
      .date-normalized {
        background-color: rgba(255, 215, 0, 0.2) !important;
        transition: background-color 0.5s;
      }
    </style>
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
          <input type="text" id="birthdate" name="birthdate" value="<?php echo isset($_POST['birthdate']) ? htmlspecialchars($_POST['birthdate']) : ''; ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition" required placeholder="GG/AA/YYYY">
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

<script>
// Doğum tarihi formatlaması, doğrulaması ve otomatik düzeltme için script
document.addEventListener('DOMContentLoaded', function() {
  const birthdateInput = document.getElementById('birthdate');
  
  // Sayıyı iki basamaklı formata dönüştür (01, 02, vs.)
  function padZero(num) {
    return num < 10 ? '0' + num : num;
  }
  
  // Tarih değerlerini geçerli aralıklara normalize et
  function normalizeDate(dateStr) {
    // Formatı kontrol et, eğer tam değilse düzeltmeye çalışma
    const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
    if (!dateRegex.test(dateStr)) {
      return dateStr;
    }
    
    // Tarih bileşenlerini ayır
    const parts = dateStr.match(dateRegex);
    let day = parseInt(parts[1], 10);
    let month = parseInt(parts[2], 10);
    let year = parseInt(parts[3], 10);
    
    // Geçerli aralıklara göre düzelt
    const currentYear = new Date().getFullYear();
    
    // Yıl düzeltmesi: 1900-günümüz aralığı
    if (year > currentYear) {
      year = currentYear;
    }
    if (year < 1900) {
      year = 1900;
    }
    
    // Ay düzeltmesi: 1-12 aralığı
    if (month > 12) {
      month = 12;
    }
    if (month < 1) {
      month = 1;
    }
    
    // Günün ay için geçerli olup olmadığını kontrol et
    const monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    
    // Artık yıl kontrolü
    if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0) {
      monthLengths[1] = 29;
    }
    
    // Gün düzeltmesi: 1-ayın maksimum gün sayısı aralığı
    if (day > monthLengths[month - 1]) {
      day = monthLengths[month - 1];
    }
    if (day < 1) {
      day = 1;
    }
    
    // Düzeltilmiş tarihi döndür
    return padZero(day) + '/' + padZero(month) + '/' + year;
  }
  
  // Tarih formatlaması için input event listener
  birthdateInput.addEventListener('input', function(e) {
    let input = e.target.value.replace(/\D/g, ''); // Sadece rakamları tut
    
    if (input.length > 0) {
      // GG bölümünü formatla
      if (input.length > 2) {
        input = input.substr(0, 2) + '/' + input.substr(2);
      }
      
      // AA bölümünü formatla
      if (input.length > 5) {
        input = input.substr(0, 5) + '/' + input.substr(5);
      }
      
      // Maksimum uzunluğu kontrol et (GG/AA/YYYY = 10 karakter)
      if (input.length > 10) {
        input = input.substr(0, 10);
      }
    }
    
    // Değeri güncelle
    e.target.value = input;
  });
  
  // Tarih geçerliliğini kontrol eden fonksiyon
  function isValidDate(day, month, year) {
    // Geçerli bir yıl mı?
    const currentYear = new Date().getFullYear();
    if (year < 1900 || year > currentYear) {
      return {
        valid: false,
        message: 'Geçerli bir yıl giriniz (1900-' + currentYear + ' arasında).'
      };
    }
    
    // Geçerli bir ay mı?
    if (month < 1 || month > 12) {
      return {
        valid: false,
        message: 'Geçerli bir ay giriniz (1-12 arasında).'
      };
    }
    
    // Geçerli bir gün mü?
    if (day < 1 || day > 31) {
      return {
        valid: false,
        message: 'Geçerli bir gün giriniz (1-31 arasında).'
      };
    }
    
    // Ay başına düşen gün sayısını kontrol et
    const monthLengths = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    
    // Artık yıl kontrolü
    if ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0) {
      monthLengths[1] = 29;
    }
    
    // Belirlenen ay için gün sayısı geçerli mi?
    if (day > monthLengths[month - 1]) {
      return {
        valid: false,
        message: month + '. ay için geçerli bir gün giriniz (en fazla ' + monthLengths[month - 1] + ' gün).'
      };
    }
    
    // Tüm kontroller geçildi, tarih geçerli
    return {
      valid: true,
      message: ''
    };
  }
  
  // Input'tan çıkıldığında (blur) tarih değerlerini normalize et
  birthdateInput.addEventListener('blur', function(e) {
    const value = e.target.value;
    if (value && value.length >= 10) {
      // Değeri normalize et
      const normalizedDate = normalizeDate(value);
      
      // Eğer değer değiştiyse, güncelle ve hafif bir vurgu efekti ekle
      if (normalizedDate !== value) {
        e.target.value = normalizedDate;
        
        // Görsel geribildirim için hafif vurgu efekti
        e.target.classList.add('date-normalized');
        setTimeout(() => {
          e.target.classList.remove('date-normalized');
        }, 500);
      }
    }
  });
  
  // Form gönderilmeden önce tarih formatını kontrol et ve son düzeltmeleri yap
  birthdateInput.closest('form').addEventListener('submit', function(e) {
    const value = birthdateInput.value;
    const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
    
    // Format kontrolü
    if (!dateRegex.test(value)) {
      alert('Lütfen doğum tarihini GG/AA/YYYY formatında giriniz.');
      e.preventDefault();
      birthdateInput.focus();
      return false;
    }
    
    // Son bir normalizasyon yap
    const normalizedDate = normalizeDate(value);
    birthdateInput.value = normalizedDate;
    
    // Tarih değerlerini ayır
    const matches = normalizedDate.match(dateRegex);
    const day = parseInt(matches[1], 10);
    const month = parseInt(matches[2], 10);
    const year = parseInt(matches[3], 10);
    
    // Yaş kontrolü - kayıt için en az 13 yaş gerekiyor
    const birthDate = new Date(year, month - 1, day);
    const today = new Date();
    let age = today.getFullYear() - birthDate.getFullYear();
    const monthDiff = today.getMonth() - birthDate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
      age--;
    }
    
    if (age < 13) {
      alert('Kayıt olmak için en az 13 yaşında olmalısınız.');
      e.preventDefault();
      return false;
    }
  });
});
</script>

<?php require_once 'footer.php'; ?>
