<?php
require_once 'session.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Linwood Roleplay</title>
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Özel CSS -->
  <link rel="stylesheet" href="style.css">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'dark-bg': '#0e0e0e',
            'primary': '#e61e25',
            'secondary': '#3b82f6',
            'accent': '#22d3ee',
          }
        }
      }
    }
  </script>
</head>
<body class="bg-[#0e0e0e] text-white font-sans">
  <!-- Modern Header -->
  <header class="modern-header sticky top-0 z-50">
    <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-5">
      <div class="flex justify-between items-center">
        <div class="flex space-x-3 md:space-x-6 lg:space-x-8 items-center">
          <a href="index.php" class="text-lg sm:text-xl font-bold tracking-wider logo-text">LINWOOD</a>
          <nav class="hidden md:flex space-x-3 lg:space-x-6 xl:space-x-8">
            <a href="index.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Ana Sayfa</a>
            <a href="rules.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base <?php echo basename($_SERVER['PHP_SELF']) == 'rules.php' ? 'active' : ''; ?>">Kurallar</a>
            <a href="market.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base <?php echo basename($_SERVER['PHP_SELF']) == 'market.php' ? 'active' : ''; ?>">Market</a>
            <?php if (is_logged_in()): ?>
            <a href="profile.php" class="nav-link text-white hover:text-gray-300 text-sm lg:text-base <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">Profil</a>
            <?php endif; ?>
          </nav>
        </div>
        <div class="hidden sm:flex items-center space-x-3">
          <?php if (is_logged_in()): ?>
            <a href="basvuru.php" class="btn btn-outline hover-glow text-sm sm:text-base md:px-4 lg:px-5 <?php echo basename($_SERVER['PHP_SELF']) == 'basvuru.php' ? 'active' : ''; ?>">Karakter Başvuru</a>
            <a href="logout.php" class="btn btn-primary hover-glow text-sm sm:text-base md:px-4 lg:px-5">Çıkış Yap</a>
          <?php else: ?>
            <a href="login.php" class="btn btn-outline hover-glow text-sm sm:text-base md:px-4 lg:px-5 <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">Giriş Yap</a>
            <a href="register.php" class="btn btn-primary hover-glow text-sm sm:text-base md:px-4 lg:px-5 <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">Kayıt Ol</a>
          <?php endif; ?>
        </div>
        <!-- Mobil Menü Butonu -->
        <div class="md:hidden">
          <button id="menu-toggle" class="text-white focus:outline-none">
            <i class="fas fa-bars"></i>
          </button>
        </div>
      </div>
      <!-- Mobil Menü -->
      <div id="mobile-menu" class="hidden md:hidden mt-3 pb-3">
        <a href="index.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Ana Sayfa</a>
        <a href="rules.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'rules.php' ? 'active' : ''; ?>">Kurallar</a>
        <a href="market.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'market.php' ? 'active' : ''; ?>">Market</a>
        <?php if (is_logged_in()): ?>
        <a href="profile.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">Profil</a>
        <a href="basvuru.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'basvuru.php' ? 'active' : ''; ?>">Karakter Başvuru</a>
        <a href="logout.php" class="block py-2 text-white hover:text-gray-300">Çıkış Yap</a>
        <?php else: ?>
        <a href="login.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'login.php' ? 'active' : ''; ?>">Giriş Yap</a>
        <a href="register.php" class="block py-2 text-white hover:text-gray-300 <?php echo basename($_SERVER['PHP_SELF']) == 'register.php' ? 'active' : ''; ?>">Kayıt Ol</a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Bildirimler için alan -->
  <div class="container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <?php 
      echo display_error();
      echo display_success();
    ?>
  </div>
