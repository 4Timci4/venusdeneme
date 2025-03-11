<?php
// Form verilerini temizleme
function clean_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// CSRF token oluşturma
function generate_csrf_token() {
  if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

// CSRF token kontrolü
function check_csrf_token($token) {
  if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    return false;
  }
  return true;
}

// Sayfa yönlendirme
function redirect($url) {
  header("Location: $url");
  exit();
}

// Hata mesajını session'a kaydetme
function set_error($message) {
  $_SESSION['error'] = $message;
}

// Başarı mesajını session'a kaydetme
function set_success($message) {
  $_SESSION['success'] = $message;
}

// Hata mesajını göster ve temizle
function display_error() {
  if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
    return '<div class="bg-red-500 text-white p-4 mb-4 rounded">' . $error . '</div>';
  }
  return '';
}

// Başarı mesajını göster ve temizle
function display_success() {
  if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
    return '<div class="bg-green-500 text-white p-4 mb-4 rounded">' . $success . '</div>';
  }
  return '';
}

// Form alanlarını doğrulama fonksiyonu
function validate_form($fields, $required_fields = []) {
  $errors = [];
  
  foreach ($required_fields as $field) {
    if (empty($fields[$field])) {
      $errors[] = ucfirst($field) . ' alanı gereklidir.';
    }
  }
  
  // E-posta formatı kontrolü
  if (isset($fields['email']) && !empty($fields['email'])) {
    if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
      $errors[] = 'Geçerli bir e-posta adresi giriniz.';
    }
  }
  
  return $errors;
}

// Kullanıcı giriş yapmış mı kontrolü
function is_logged_in() {
  return isset($_SESSION['user_id']);
}

// Giriş yapmamış kullanıcıları login sayfasına yönlendir
function require_login() {
  if (!is_logged_in()) {
    set_error('Bu sayfayı görüntülemek için giriş yapmalısınız.');
    redirect('login.php');
  }
}

// Kullanıcı bilgilerini getir
function get_user_by_id($db, $user_id) {
  $stmt = $db->prepare("SELECT id, username, email, birthdate FROM users WHERE id = ?");
  $stmt->execute([$user_id]);
  return $stmt->fetch();
}

// Kullanıcının karakterlerini getir
function get_user_characters($db, $user_id) {
  $stmt = $db->prepare("SELECT * FROM characters WHERE user_id = ?");
  $stmt->execute([$user_id]);
  return $stmt->fetchAll();
}
?>
