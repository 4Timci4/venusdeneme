<?php
$page_title = "Oyuncu İstatistikleri Yönetici Paneli";
require_once 'db.php';
require_once 'functions.php';
require_once 'header.php';

// Oturum ve yönetici kontrolü - sadece giriş yapan yöneticiler erişebilir
require_admin();

// Kullanıcı verilerini veritabanından çekme
$user_id = $_SESSION['user_id'];
$user = get_user_by_id($db, $user_id);

// Varsayılan sıralama ve filtreleme değerleri
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'username';
$sort_dir = isset($_GET['dir']) ? $_GET['dir'] : 'asc';
$search = isset($_GET['search']) ? clean_input($_GET['search']) : '';
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;

// Oyun sunucusu veritabanı bağlantısı ve oyuncu listesi
// NOT: Bu kısım ileride gerçek veritabanı bağlantısı ile değiştirilecek
$player_stats = [];

// Örnek oyuncu verileri (veritabanı bağlantısı yapılana kadar)
$sample_players = [
  ['id' => 1, 'username' => 'JohnDoe', 'level' => 45, 'playtime' => 320, 'money' => 234500, 'last_login' => '2025-03-10 15:30:22'],
  ['id' => 2, 'username' => 'AlexSmith', 'level' => 32, 'playtime' => 178, 'money' => 105600, 'last_login' => '2025-03-11 08:45:12'],
  ['id' => 3, 'username' => 'EmmaWilson', 'level' => 67, 'playtime' => 412, 'money' => 567800, 'last_login' => '2025-03-09 22:10:45'],
  ['id' => 4, 'username' => 'MichaelBrown', 'level' => 28, 'playtime' => 145, 'money' => 76000, 'last_login' => '2025-03-11 10:20:30'],
  ['id' => 5, 'username' => 'SophiaJohnson', 'level' => 53, 'playtime' => 287, 'money' => 345900, 'last_login' => '2025-03-10 18:15:55'],
  ['id' => 6, 'username' => 'DanielTaylor', 'level' => 15, 'playtime' => 62, 'money' => 23400, 'last_login' => '2025-03-11 14:40:07'],
  ['id' => 7, 'username' => 'OliviaMoore', 'level' => 39, 'playtime' => 210, 'money' => 178200, 'last_login' => '2025-03-11 11:55:18'],
  ['id' => 8, 'username' => 'WilliamDavis', 'level' => 60, 'playtime' => 350, 'money' => 420800, 'last_login' => '2025-03-09 09:30:42'],
  ['id' => 9, 'username' => 'IsabellaThomas', 'level' => 22, 'playtime' => 98, 'money' => 45600, 'last_login' => '2025-03-10 20:25:33'],
  ['id' => 10, 'username' => 'JamesAnderson', 'level' => 41, 'playtime' => 224, 'money' => 198700, 'last_login' => '2025-03-11 07:10:28'],
  ['id' => 11, 'username' => 'EmmaWilliams', 'level' => 37, 'playtime' => 185, 'money' => 152300, 'last_login' => '2025-03-10 16:45:50'],
  ['id' => 12, 'username' => 'NoahClark', 'level' => 56, 'playtime' => 320, 'money' => 380600, 'last_login' => '2025-03-09 14:50:15'],
  ['id' => 13, 'username' => 'AvaMiller', 'level' => 19, 'playtime' => 86, 'money' => 37200, 'last_login' => '2025-03-11 12:35:41'],
  ['id' => 14, 'username' => 'LiamLewis', 'level' => 48, 'playtime' => 256, 'money' => 287400, 'last_login' => '2025-03-10 10:15:22'],
  ['id' => 15, 'username' => 'CharlotteWalker', 'level' => 34, 'playtime' => 167, 'money' => 124500, 'last_login' => '2025-03-11 09:05:37']
];

// Arama filtreleme
if (!empty($search)) {
  $filtered_players = [];
  foreach ($sample_players as $player) {
    if (stripos($player['username'], $search) !== false) {
      $filtered_players[] = $player;
    }
  }
  $sample_players = $filtered_players;
}

// Sıralama
usort($sample_players, function($a, $b) use ($sort_by, $sort_dir) {
  if ($sort_dir == 'asc') {
    return $a[$sort_by] <=> $b[$sort_by];
  } else {
    return $b[$sort_by] <=> $a[$sort_by];
  }
});

// Sayfalama
$total_players = count($sample_players);
$total_pages = ceil($total_players / $items_per_page);
$current_page = max(1, min($current_page, $total_pages));
$offset = ($current_page - 1) * $items_per_page;
$player_stats = array_slice($sample_players, $offset, $items_per_page);

// Sıralama için URL oluşturma fonksiyonu
function get_sort_url($field) {
  global $sort_by, $sort_dir, $search, $current_page;
  $new_dir = ($sort_by == $field && $sort_dir == 'asc') ? 'desc' : 'asc';
  $params = [
    'sort' => $field,
    'dir' => $new_dir,
    'page' => $current_page
  ];
  if (!empty($search)) {
    $params['search'] = $search;
  }
  return '?' . http_build_query($params);
}

// Sıralama ikonlarını gösterme
function get_sort_icon($field) {
  global $sort_by, $sort_dir;
  
  if ($sort_by != $field) {
    return '<i class="fas fa-sort text-gray-500"></i>';
  }
  
  return ($sort_dir == 'asc') 
    ? '<i class="fas fa-sort-up text-blue-400"></i>'
    : '<i class="fas fa-sort-down text-blue-400"></i>';
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
              <span class="bg-primary px-2 py-0.5 rounded text-white text-xs">Yönetici</span>
            </p>
          </div>
          
          <!-- Sidebar Menü -->
          <div class="space-y-2">
            <a href="profile.php" class="sidebar-item flex items-center p-3 rounded-md bg-transparent text-white hover:bg-gray-700 transition-colors">
              <i class="fas fa-user mr-3 w-5 text-center"></i>
              <span>Profil</span>
            </a>
            <a href="player_stats.php" class="sidebar-item flex items-center p-3 rounded-md bg-gray-800 text-white hover:bg-gray-700 transition-colors">
              <i class="fas fa-chart-bar mr-3 w-5 text-center"></i>
              <span>Oyuncu İstatistikleri</span>
            </a>
          </div>
        </div>
      </div>
      
      <!-- Ana içerik -->
      <div class="md:w-3/4 lg:w-4/5">
        <div class="glass-card p-6 md:p-8 mb-8">
          <div class="text-center mb-8">
            <h1 class="text-2xl md:text-3xl font-bold mb-3 section-title-center inline-block">Oyuncu İstatistikleri</h1>
            <div class="flex justify-center">
              <div class="feature-icon text-3xl sm:text-4xl text-white mb-4">
                <i class="fas fa-chart-bar"></i>
              </div>
            </div>
          </div>
          
          <!-- Bilgi mesajı -->
          <div class="bg-blue-900/30 border border-blue-700 rounded-lg p-4 mb-6">
            <div class="flex items-start">
              <div class="flex-shrink-0 pt-0.5">
                <i class="fas fa-info-circle text-blue-400"></i>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-300">Yönetici Bilgisi</h3>
                <div class="mt-1 text-sm text-blue-200">
                  <p>Bu sayfada sunucudaki tüm oyuncuların istatistiklerini görüntüleyebilir ve yönetebilirsiniz. İstatistikler oyun sunucusu veritabanı ile senkronize edilir.</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Arama ve Filtreleme -->
          <div class="flex flex-col sm:flex-row gap-3 mb-6">
            <div class="grow">
              <form action="player_stats.php" method="GET" class="flex">
                <input type="hidden" name="sort" value="<?php echo $sort_by; ?>">
                <input type="hidden" name="dir" value="<?php echo $sort_dir; ?>">
                <input type="text" name="search" placeholder="Oyuncu ara..." value="<?php echo htmlspecialchars($search); ?>" class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition">
                <button type="submit" class="bg-primary px-4 rounded-r-md hover:bg-red-700 transition-colors">
                  <i class="fas fa-search"></i>
                </button>
              </form>
            </div>
            <div class="flex-shrink-0">
              <a href="player_stats.php" class="btn btn-secondary hover-glow px-4 py-2">
                <i class="fas fa-sync-alt mr-2"></i> Yenile
              </a>
            </div>
          </div>
          
          <!-- Özet İstatistik Kartları -->
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <!-- Kart 1 -->
            <div class="bg-gray-800/60 rounded-lg p-4 border border-gray-700">
              <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium">Toplam Oyuncu</h3>
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-800/30 text-blue-400">
                  <i class="fas fa-users"></i>
                </div>
              </div>
              <p class="text-3xl font-bold text-blue-400 mt-2"><?php echo $total_players; ?></p>
            </div>
            
            <!-- Kart 2 -->
            <div class="bg-gray-800/60 rounded-lg p-4 border border-gray-700">
              <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium">Ortalama Seviye</h3>
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-green-800/30 text-green-400">
                  <i class="fas fa-trophy"></i>
                </div>
              </div>
              <p class="text-3xl font-bold text-green-400 mt-2">
                <?php 
                  $avg_level = array_sum(array_column($sample_players, 'level')) / count($sample_players);
                  echo round($avg_level); 
                ?>
              </p>
            </div>
            
            <!-- Kart 3 -->
            <div class="bg-gray-800/60 rounded-lg p-4 border border-gray-700">
              <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium">Toplam Oyun Süresi</h3>
                <div class="w-10 h-10 flex items-center justify-center rounded-full bg-yellow-800/30 text-yellow-400">
                  <i class="fas fa-clock"></i>
                </div>
              </div>
              <p class="text-3xl font-bold text-yellow-400 mt-2">
                <?php 
                  $total_hours = array_sum(array_column($sample_players, 'playtime'));
                  echo $total_hours; 
                ?> saat
              </p>
            </div>
          </div>
          
          <!-- Oyuncu Tablosu -->
          <div class="mb-6">
            <h2 class="text-xl font-bold mb-4">Oyuncu Listesi</h2>
            
            <div class="overflow-x-auto mb-4">
              <table class="min-w-full bg-gray-900/50 rounded-lg overflow-hidden">
                <thead>
                  <tr class="bg-gray-800/80 text-gray-200">
                    <th class="py-3 px-4 text-left font-medium">ID</th>
                    <th class="py-3 px-4 text-left font-medium">
                      <a href="<?php echo get_sort_url('username'); ?>" class="flex items-center hover:text-blue-300">
                        Kullanıcı Adı <?php echo get_sort_icon('username'); ?>
                      </a>
                    </th>
                    <th class="py-3 px-4 text-left font-medium">
                      <a href="<?php echo get_sort_url('level'); ?>" class="flex items-center hover:text-blue-300">
                        Seviye <?php echo get_sort_icon('level'); ?>
                      </a>
                    </th>
                    <th class="py-3 px-4 text-left font-medium">
                      <a href="<?php echo get_sort_url('playtime'); ?>" class="flex items-center hover:text-blue-300">
                        Oyun Süresi <?php echo get_sort_icon('playtime'); ?>
                      </a>
                    </th>
                    <th class="py-3 px-4 text-left font-medium">
                      <a href="<?php echo get_sort_url('money'); ?>" class="flex items-center hover:text-blue-300">
                        Para <?php echo get_sort_icon('money'); ?>
                      </a>
                    </th>
                    <th class="py-3 px-4 text-left font-medium">Son Giriş</th>
                    <th class="py-3 px-4 text-left font-medium">İşlemler</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($player_stats)): ?>
                  <tr class="border-t border-gray-700">
                    <td colspan="7" class="py-4 px-4 text-center text-gray-400">Oyuncu bulunamadı.</td>
                  </tr>
                  <?php else: ?>
                    <?php foreach ($player_stats as $index => $player): ?>
                    <tr class="border-t border-gray-700 <?php echo $index % 2 == 1 ? 'bg-gray-800/30' : ''; ?> hover:bg-gray-800/50 transition-colors">
                      <td class="py-3 px-4"><?php echo $player['id']; ?></td>
                      <td class="py-3 px-4 font-medium"><?php echo htmlspecialchars($player['username']); ?></td>
                      <td class="py-3 px-4"><?php echo $player['level']; ?></td>
                      <td class="py-3 px-4"><?php echo $player['playtime']; ?> saat</td>
                      <td class="py-3 px-4">$<?php echo number_format($player['money']); ?></td>
                      <td class="py-3 px-4 text-gray-300 text-sm"><?php echo date('d.m.Y H:i', strtotime($player['last_login'])); ?></td>
                      <td class="py-3 px-4">
                        <div class="flex space-x-2">
                          <button class="text-blue-400 hover:text-blue-300 transition-colors" title="Detayları Görüntüle">
                            <i class="fas fa-eye"></i>
                          </button>
                          <button class="text-green-400 hover:text-green-300 transition-colors" title="Düzenle">
                            <i class="fas fa-edit"></i>
                          </button>
                          <button class="text-red-400 hover:text-red-300 transition-colors" title="Engelle">
                            <i class="fas fa-ban"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
            
            <!-- Sayfalama -->
            <?php if ($total_pages > 1): ?>
            <div class="flex justify-center mt-6">
              <div class="flex space-x-1">
                <?php if ($current_page > 1): ?>
                <a href="?page=<?php echo $current_page - 1; ?>&sort=<?php echo $sort_by; ?>&dir=<?php echo $sort_dir; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-4 py-2 bg-gray-800 rounded-md hover:bg-gray-700 transition-colors">
                  <i class="fas fa-chevron-left"></i>
                </a>
                <?php endif; ?>
                
                <?php 
                $start_page = max(1, min($current_page - 2, $total_pages - 4));
                $end_page = min($total_pages, max($current_page + 2, 5));
                
                if ($start_page > 1): ?>
                <a href="?page=1&sort=<?php echo $sort_by; ?>&dir=<?php echo $sort_dir; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-4 py-2 bg-gray-800 rounded-md hover:bg-gray-700 transition-colors">1</a>
                <?php if ($start_page > 2): ?>
                <span class="px-4 py-2">...</span>
                <?php endif; ?>
                <?php endif; ?>
                
                <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <a href="?page=<?php echo $i; ?>&sort=<?php echo $sort_by; ?>&dir=<?php echo $sort_dir; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-4 py-2 rounded-md <?php echo $i == $current_page ? 'bg-primary text-white' : 'bg-gray-800 hover:bg-gray-700'; ?> transition-colors">
                  <?php echo $i; ?>
                </a>
                <?php endfor; ?>
                
                <?php if ($end_page < $total_pages): ?>
                <?php if ($end_page < $total_pages - 1): ?>
                <span class="px-4 py-2">...</span>
                <?php endif; ?>
                <a href="?page=<?php echo $total_pages; ?>&sort=<?php echo $sort_by; ?>&dir=<?php echo $sort_dir; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-4 py-2 bg-gray-800 rounded-md hover:bg-gray-700 transition-colors">
                  <?php echo $total_pages; ?>
                </a>
                <?php endif; ?>
                
                <?php if ($current_page < $total_pages): ?>
                <a href="?page=<?php echo $current_page + 1; ?>&sort=<?php echo $sort_by; ?>&dir=<?php echo $sort_dir; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" class="px-4 py-2 bg-gray-800 rounded-md hover:bg-gray-700 transition-colors">
                  <i class="fas fa-chevron-right"></i>
                </a>
                <?php endif; ?>
              </div>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- İşlem Butonları -->
          <div class="flex flex-wrap justify-center gap-3 mt-8">
            <button class="btn btn-primary hover-glow px-6 py-2">
              <i class="fas fa-sync-alt mr-2"></i> İstatistikleri Güncelle
            </button>
            <button class="btn btn-secondary hover-glow px-6 py-2">
              <i class="fas fa-file-export mr-2"></i> Verileri Dışa Aktar
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once 'footer.php'; ?>
