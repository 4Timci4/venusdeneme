# Linwood Roleplay Web Sitesi

![Linwood Roleplay](https://picsum.photos/800/400?random=1)

## 📝 Proje Hakkında

Linwood Roleplay, FiveM tabanlı bir roleplay sunucusu için tasarlanmış modern ve responsive bir web sitesidir. Kullanıcılara sunucu hakkında bilgi vermek, sunucu kurallarını açıklamak ve market öğelerini tanıtmak amacıyla oluşturulmuştur.

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

## 🛠️ Kullanılan Teknolojiler

- HTML5
- CSS3
- JavaScript
- [Tailwind CSS](https://tailwindcss.com/) - Modern utility-first CSS framework
- [Font Awesome](https://fontawesome.com/) - İkonlar için
- [Google Fonts](https://fonts.google.com/) - Web fontları (Poppins)

## 📂 Proje Yapısı

```
/
├── index.html            # Ana sayfa
├── rules.html            # Kurallar sayfası
├── market.html           # Market sayfası
├── style.css             # Özel CSS stilleri
├── script.js             # JavaScript kodları
├── img/                  # Görseller
│   ├── icons/            # İkonlar
│   ├── logos/            # Logolar
│   └── slider/           # Slider görselleri
└── README.md             # Proje dokümantasyonu
```

## 📄 Sayfalar ve İşlevleri

### 1. Ana Sayfa (index.html)
- Sunucu tanıtımı
- Öne çıkan özellikler
- İstatistikler
- Sosyal medya bağlantıları

### 2. Kurallar Sayfası (rules.html)
- Sunucu kuralları kategorileri
- Genel kurallar
- Roleplay kuralları
- Trafik ve araç kuralları
- Suç ve polis kuralları

### 3. Market Sayfası (market.html)
- VIP Paketleri
- Özel araçlar
- Özel mülkler
- Ödeme bilgileri

## 🚀 Kurulum ve Çalıştırma

### Yerel Geliştirme Ortamı

1. Projeyi bilgisayarınıza klonlayın veya indirin:
   ```
   git clone https://github.com/kullaniciadi/linwood-roleplay.git
   ```

2. Proje klasörüne gidin:
   ```
   cd linwood-roleplay
   ```

3. İndex.html dosyasını bir tarayıcıda açın veya yerel bir sunucu kullanın:
   ```
   # Eğer Python yüklüyse:
   python -m http.server 8000
   # Veya Node.js yüklüyse:
   npx serve
   ```

### Canlı Sunucu İçin Dağıtım

1. Tüm dosyaları web sunucunuza yükleyin (FTP, SSH veya seçtiğiniz yöntemi kullanarak)
2. Dosyaların doğru izinlere sahip olduğundan emin olun (genellikle 644)
3. Alan adınızı ayarlayın ve yönlendirin

## 🔧 Özelleştirme

### Renk Şeması Değiştirme

Renk şeması `style.css` dosyasında CSS değişkenleri kullanılarak düzenlenmiştir:

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

### Slider Görsellerini Değiştirme

1. Yeni slider görsellerinizi `img/slider/` klasörüne ekleyin
2. `index.html` dosyasındaki ilgili slide div'lerinin background-image URL'lerini güncelleyin

### Sosyal Medya Bağlantıları

Sosyal medya bağlantılarını her sayfanın footer bölümünde bulabilir ve düzenleyebilirsiniz.

## 📱 Responsive Tasarım

Bu web sitesi beş farklı ekran boyutu için optimize edilmiştir:

- **Extra Small (< 480px)**: Akıllı telefonlar (dikey mod)
- **Small (< 640px)**: Akıllı telefonlar (yatay mod)
- **Medium (< 768px)**: Tabletler (dikey mod)
- **Large (< 1024px)**: Tabletler (yatay mod) / küçük laptoplar
- **Extra Large (≥ 1024px)**: Masaüstü bilgisayarlar ve büyük ekranlar

## 🌐 Tarayıcı Uyumluluğu

- Google Chrome (önerilen)
- Mozilla Firefox
- Safari
- Microsoft Edge
- Opera

## 📝 Geliştirme Notları

### Gelecekteki İyileştirmeler

- Backend entegrasyonu (PHP/Node.js)
- Kullanıcı girişi ve kayıt sistemi
- Forum veya canlı sohbet özelliği
- Gerçek zamanlı sunucu istatistikleri

### Bilinen Sorunlar

- Bazı eski tarayıcılarda CSS filtreleri ve backdrop-filter efektleri düzgün çalışmayabilir
- Internet Explorer tarayıcısında CSS Grid ve Flexbox sorunları olabilir

## 📜 Lisans

Bu proje [MIT Lisansı](LICENSE) altında lisanslanmıştır.

## 📞 İletişim

Sorularınız veya önerileriniz için Discord sunucumuza katılabilirsiniz.

---

© 2025 Linwood Roleplay - Tüm Hakları Saklıdır.
