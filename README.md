# Linwood Roleplay Web Sitesi

![Linwood Roleplay](https://picsum.photos/800/400?random=1)

## 📝 Proje Hakkında

Linwood Roleplay, FiveM tabanlı bir roleplay sunucusu için tasarlanmış modern ve responsive bir web sitesidir. Kullanıcılara sunucu hakkında bilgi vermek, sunucu kurallarını açıklamak, market öğelerini tanıtmak ve kullanıcı hesap yönetimini sağlamak amacıyla oluşturulmuştur.

## ✨ Özellikler

- Modern ve şık kullanıcı arayüzü
- Tüm cihazlar için tam responsive tasarım (mobil, tablet, masaüstü)
- Görsel efektler ve animasyonlar (hover, fade-in, slide vb.)
- Otomatik slider/kaydırıcı
- Sayaç animasyonları
- Modern navigasyon menüsü (mobil ve masaüstü için ayrı tasarımlar)
- Interaktif bileşenler (butonlar, kartlar, slider vb.)
- Glass-morphism (buzlu cam efekti) öğeleri
- Görünüm animasyonları (scroll-triggered)
- Kullanıcı hesap sistemi (kayıt, giriş, profil yönetimi)
- Karakter yönetimi ve oyuncu istatistikleri
- Veritabanı entegrasyonu

## 🛠️ Kullanılan Teknolojiler

- HTML5
- CSS3 (Modüler CSS mimarisi)
- JavaScript
- PHP
- MySQL veritabanı
- [Tailwind CSS](https://tailwindcss.com/) - Modern utility-first CSS framework
- [Font Awesome](https://fontawesome.com/) - İkonlar için
- [Google Fonts](https://fonts.google.com/) - Web fontları (Poppins)

## 📂 Proje Yapısı

```
/
├── index.php              # Ana sayfa
├── rules.php              # Kurallar sayfası
├── market.php             # Market sayfası
├── login.php              # Giriş sayfası
├── register.php           # Kayıt sayfası
├── profile.php            # Profil sayfası
├── player_stats.php       # Oyuncu istatistikleri
├── character.php          # Karakter yönetimi
├── logout.php             # Çıkış işlemi
├── create_tables.php      # Veritabanı tablo oluşturma
├── update_admin_column.php# Admin kolonu güncelleme
├── db.php                 # Veritabanı bağlantısı
├── functions.php          # Genel fonksiyonlar
├── session.php            # Oturum yönetimi
├── header.php             # Ana sayfa header bileşeni
├── footer.php             # Ana sayfa footer bileşeni
├── 404.php                # Hata sayfası
├── script.js              # JavaScript kodları
├── style.css              # Ana CSS dosyası
├── .htaccess              # Apache sunucu yapılandırması
├── LICENSE                # Lisans dosyası
├── css/                   # CSS dosyaları
│   ├── animations.css     # Animasyon stilleri
│   ├── base.css           # Temel stiller
│   ├── responsive.css     # Responsive tasarım
│   ├── style.css          # Genel stiller
│   ├── utilities.css      # Yardımcı sınıflar
│   ├── variables.css      # CSS değişkenleri
│   └── components/        # Bileşen stilleri
│       ├── buttons.css    # Buton stilleri
│       ├── cards.css      # Kart stilleri
│       ├── footer.css     # Footer stilleri
│       ├── header.css     # Header stilleri
│       ├── heroes.css     # Hero bileşen stilleri
│       └── icons.css      # İkon stilleri
├── img/                   # Görseller
│   ├── icons/             # İkonlar
│   ├── logos/             # Logolar
│   └── slider/            # Slider görselleri
├── includes/              # Include dosyaları
│   ├── header.php         # Header include
│   └── footer.php         # Footer include
└── README.md              # Proje dokümantasyonu
```

## 📄 Sayfalar ve İşlevleri

### 1. Ana Sayfa (index.php)
- Sunucu tanıtımı
- Öne çıkan özellikler
- İstatistikler
- Sosyal medya bağlantıları

### 2. Kurallar Sayfası (rules.php)
- Sunucu kuralları kategorileri
- Genel kurallar
- Roleplay kuralları
- Trafik ve araç kuralları
- Suç ve polis kuralları

### 3. Market Sayfası (market.php)
- VIP Paketleri
- Özel araçlar
- Özel mülkler
- Ödeme bilgileri

### 4. Kayıt Sayfası (register.php)
- Kullanıcı kayıt formu
- Hesap bilgileri
- Şartlar ve koşullar
- Güvenlik doğrulaması

### 5. Giriş Sayfası (login.php)
- Kullanıcı giriş formu
- Şifremi unuttum seçeneği
- Kayıt olma yönlendirmesi

### 6. Profil Sayfası (profile.php)
- Kullanıcı bilgileri görüntüleme
- Profil güncelleme
- Hesap ayarları

### 7. Oyuncu İstatistikleri (player_stats.php)
- Oyuncu performans ölçümleri
- Karakter gelişimi
- Başarılar ve rozetler
- Sıralamalar

### 8. Hata Sayfası (404.php)
- Sayfa bulunamadı bildirimi
- Ana sayfaya dönüş bağlantısı

## 🚀 Kurulum ve Çalıştırma

### Gereksinimler

- PHP 7.4 veya üstü
- MySQL 5.7 veya üstü
- Apache web sunucusu (mod_rewrite etkin)
- XAMPP, WAMP, LAMP veya benzeri bir yerel sunucu paketi (yerel geliştirme için)

### Veritabanı Kurulumu

1. MySQL veritabanı oluşturun
2. `create_tables.php` dosyasını çalıştırarak tabloları oluşturun
3. `db.php` dosyasını açarak veritabanı bağlantı bilgilerinizi düzenleyin:
   ```php
   $servername = "localhost";
   $username = "root";  // Veritabanı kullanıcı adınız
   $password = "";      // Veritabanı şifreniz
   $dbname = "linwood"; // Veritabanı adınız
   ```

### Yerel Geliştirme Ortamı

1. Projeyi bilgisayarınıza klonlayın veya indirin:
   ```
   git clone https://github.com/kullaniciadi/linwood-roleplay.git
   ```

2. Dosyaları web sunucunuzun kök dizinine (XAMPP için htdocs, WAMP için www) kopyalayın:
   ```
   cp -r linwood-roleplay /path/to/your/webserver/root
   ```

3. Web tarayıcınızda aşağıdaki URL'i açın:
   ```
   http://localhost/linwood-roleplay
   ```

### Canlı Sunucu İçin Dağıtım

1. Tüm dosyaları web sunucunuza yükleyin (FTP, SSH veya seçtiğiniz yöntemi kullanarak)
2. Dosyaların doğru izinlere sahip olduğundan emin olun:
   - PHP dosyaları: 644
   - Klasörler: 755
   - `db.php` gibi hassas bilgiler içeren dosyalar: 600
3. Sunucunuzda bir MySQL veritabanı oluşturun
4. `db.php` dosyasını veritabanı bağlantı bilgilerinizle güncelleyin
5. Tarayıcınızdan `create_tables.php` dosyasını çalıştırarak veritabanı tablolarını oluşturun
6. Alan adınızı ayarlayın ve yönlendirin

## 🔧 Özelleştirme

### Renk Şeması Değiştirme

Renk şeması `css/variables.css` dosyasında CSS değişkenleri kullanılarak düzenlenmiştir:

```css
:root {
  --color-primary: #e61e25;
  --color-primary-hover: #c81a20;
  --color-secondary: #3b82f6;
  --color-dark: #0e0e0e;
  --color-dark-lighter: #191919;
  /* ... */
}
```

### Modüler CSS Yapısı

Proje, her bileşen için ayrı CSS dosyalarıyla modüler bir yaklaşım kullanmaktadır:

- `base.css`: Temel HTML elementleri için stiller
- `animations.css`: Tüm animasyonlar ve geçiş efektleri
- `components/`: Özel bileşenler için CSS dosyaları
- `utilities.css`: Yardımcı CSS sınıfları
- `variables.css`: Renk şeması ve diğer CSS değişkenleri

Yeni bileşenler eklerken, `css/components/` dizininde yeni bir dosya oluşturun ve `style.css` dosyasına import edin.

### Slider Görsellerini Değiştirme

1. Yeni slider görsellerinizi `img/slider/` klasörüne ekleyin
2. İlgili PHP dosyalarında görsel yollarını güncelleyin

### Sosyal Medya Bağlantıları

Sosyal medya bağlantılarını `includes/footer.php` dosyasında düzenleyebilirsiniz.

## 📱 Responsive Tasarım

Bu web sitesi beş farklı ekran boyutu için optimize edilmiştir:

- **Extra Small (< 480px)**: Akıllı telefonlar (dikey mod)
- **Small (< 640px)**: Akıllı telefonlar (yatay mod)
- **Medium (< 768px)**: Tabletler (dikey mod)
- **Large (< 1024px)**: Tabletler (yatay mod) / küçük laptoplar
- **Extra Large (≥ 1024px)**: Masaüstü bilgisayarlar ve büyük ekranlar

Responsive stil ayarları `css/responsive.css` dosyasında bulunmaktadır.

## 🌐 Tarayıcı Uyumluluğu

- Google Chrome (önerilen)
- Mozilla Firefox
- Safari
- Microsoft Edge
- Opera

## 📝 Geliştirme Notları

### Veritabanı Şeması

Proje aşağıdaki veritabanı tablolarını kullanmaktadır:

- `users`: Kullanıcı bilgileri (id, username, email, password_hash, created_at, is_admin)
- `characters`: Oyuncu karakterleri (id, user_id, name, level, experience, money, created_at)
- `player_stats`: Oyuncu istatistikleri (id, character_id, playtime, arrests, deaths, kills)

### Gelecekteki İyileştirmeler

- RESTful API entegrasyonu
- Ajax ile sayfa yüklemelerinin optimize edilmesi
- Daha gelişmiş oyuncu istatistikleri paneli
- Forum veya canlı sohbet özelliği
- Gerçek zamanlı sunucu istatistikleri
- Çoklu dil desteği
- Admin paneli iyileştirmeleri

### Bilinen Sorunlar

- Bazı eski tarayıcılarda CSS filtreleri ve backdrop-filter efektleri düzgün çalışmayabilir
- Internet Explorer tarayıcısında CSS Grid ve Flexbox sorunları olabilir

## 📜 Lisans

Bu proje [MIT Lisansı](LICENSE) altında lisanslanmıştır.

## 📞 İletişim

Sorularınız veya önerileriniz için Discord sunucumuza katılabilirsiniz.

---

© 2025 Linwood Roleplay - Tüm Hakları Saklıdır.
