// Linwood Roleplay - Responsive Modern JavaScript

// Cihaz Tespiti
const isMobile = window.innerWidth < 768
const isSmallScreen = window.innerWidth < 480

// DOM Yükleme Kontrolü
document.addEventListener('DOMContentLoaded', () => {
  // Mobil Menü Fonksiyonu
  setupMobileMenu()
  
  // Responsive Slider Başlatma
  setupResponsiveSlider()
  
  // Sayaçları Başlat
  setupCounters()
  
  // Kaydırma Animasyonları ve Görünüm Animasyonları
  setupScrollAnimations()
  
  // Fade-in-up Animasyonları
  setupFadeAnimations()
  
  // Responsive İşlemler
  setupResponsiveHandlers()
})

// Responsive Mobil Menü Fonksiyonu
function setupMobileMenu() {
  const menuToggle = document.getElementById('menu-toggle')
  const mobileMenu = document.getElementById('mobile-menu')
  
  if (menuToggle && mobileMenu) {
    menuToggle.addEventListener('click', () => {
      if (mobileMenu.classList.contains('hidden')) {
        // Menüyü göster
        mobileMenu.classList.remove('hidden')
        // CSS animasyonu için bir süre sonra show class'ını ekle
        setTimeout(() => {
          mobileMenu.classList.add('show')
        }, 10)
        
        // İkon değiştir
        const icon = menuToggle.querySelector('i')
        if (icon) {
          icon.classList.remove('fa-bars')
          icon.classList.add('fa-times')
        }
      } else {
        // Menüyü gizle
        mobileMenu.classList.remove('show')
        // CSS animasyonu tamamlandıktan sonra hidden class'ını ekle
        setTimeout(() => {
          mobileMenu.classList.add('hidden')
        }, 300)
        
        // İkonu geri değiştir
        const icon = menuToggle.querySelector('i')
        if (icon) {
          icon.classList.remove('fa-times')
          icon.classList.add('fa-bars')
        }
      }
    })
  }
}

// Responsive Slider Fonksiyonu
function setupResponsiveSlider() {
  const slides = document.querySelectorAll('.slide')
  let currentSlide = 0
  // Mobil için daha hızlı slider geçişi
  const slideInterval = isMobile ? 5000 : 6000 
  
  // Slider boyutunu responsive yap
  function adjustSliderImages() {
    const sliderWidth = window.innerWidth
    slides.forEach(slide => {
      // Küçük cihazlarda daha küçük ve hızlı yüklenen görseller
      const imgSize = sliderWidth <= 480 ? '1000/600' : 
                      sliderWidth <= 768 ? '1280/720' : '1920/1080'
      
      const bgImage = slide.style.backgroundImage
      if (bgImage) {
        // Aynı rastgele sayıyı koruyarak boyutu değiştir
        const randomNum = bgImage.match(/random=(\d+)/)[1]
        slide.style.backgroundImage = `url('https://picsum.photos/${imgSize}?random=${randomNum}')`
      }
    })
  }
  
  // İlk yükleme için görsel boyutlarını ayarla
  adjustSliderImages()
  
  if (slides.length > 0) {
    // Slider döngüsünü başlat
    const sliderInterval = setInterval(() => {
      // Mevcut slide'ı gizle
      slides[currentSlide].style.opacity = '0'
      
      // Sonraki slide'a geç
      currentSlide = (currentSlide + 1) % slides.length
      
      // Yeni slide'ı göster ve hafif zoom efekti ekle (küçük ekranlarda daha az zoom)
      slides[currentSlide].style.opacity = '1'
      const scaleAmount = isSmallScreen ? '1.03' : '1.05'
      slides[currentSlide].style.transform = `scale(${scaleAmount})`
      
      // Zoom efektini yavaşça küçült (küçük ekranlarda daha kısa sürede)
      setTimeout(() => {
        const duration = isSmallScreen ? '6s' : '10s'
        slides[currentSlide].style.transition = `transform ${duration} ease-out`
        slides[currentSlide].style.transform = 'scale(1)'
      }, 100)
      
      // Bir sonraki geçiş için transition'ı sıfırla
      setTimeout(() => {
        slides[currentSlide].style.transition = 'opacity 1.5s'
      }, isSmallScreen ? 5500 : 9000)
      
    }, slideInterval)
    
    // Sayfa görünür olmadığında kaynakları korumak için interval'i durdur
    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        clearInterval(sliderInterval)
      } else {
        // Sayfa tekrar görünür olduğunda slider'ı yeniden başlat
        setupResponsiveSlider()
      }
    })
  }
  
  // Pencere yeniden boyutlandırıldığında slider boyutlarını ayarla
  window.addEventListener('resize', () => {
    const newIsMobile = window.innerWidth < 768
    const newIsSmallScreen = window.innerWidth < 480
    
    // Cihaz türü değiştiyse
    if (newIsMobile !== isMobile || newIsSmallScreen !== isSmallScreen) {
      // Global değişkenleri güncelle
      isMobile = newIsMobile
      isSmallScreen = newIsSmallScreen
      
      // Görsel boyutlarını ayarla
      adjustSliderImages()
    }
  })
}

// Responsive Sayaç Animasyonu
function setupCounters() {
  // Hedef sayılar (istediğiniz gibi değiştirebilirsiniz)
  const targetNumbers = {
    'counter-characters': 1250,
    'counter-whitelist': 780,
    'counter-admins': 25,
    'counter-properties': 1800
  }
  
  // IntersectionObserver ile görünürlük kontrolü
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      // Eğer element görünür hale geldiyse
      if (entry.isIntersecting) {
        const counter = entry.target
        const id = counter.getAttribute('id')
        const targetValue = targetNumbers[id]
        
        if (targetValue) {
          // Sayaç animasyonunu başlat
          animateCounter(counter, targetValue)
          
          // Sayaç kartına görünür sınıfı ekle
          const counterCard = counter.closest('.counter-card')
          if (counterCard) {
            counterCard.classList.add('visible')
          }
        }
        
        // Bir kez animasyon yaptıktan sonra gözlemlemeyi durdur
        observer.unobserve(counter)
      }
    })
  }, { threshold: 0.2 })
  
  // Tüm sayaçları gözlemle
  Object.keys(targetNumbers).forEach(id => {
    const counterElement = document.getElementById(id)
    if (counterElement) {
      observer.observe(counterElement)
    }
  })
}

// Responsive Sayaç Animasyonu Fonksiyonu
function animateCounter(element, targetNumber) {
  let startTime
  const duration = 2500 // 2.5 saniye
  const startValue = 0
  
  function updateCounter(timestamp) {
    if (!startTime) startTime = timestamp
    const progress = Math.min((timestamp - startTime) / duration, 1)
    
    // Eased animasyon (easeOutExpo)
    const easedProgress = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress)
    const currentValue = Math.floor(easedProgress * (targetNumber - startValue) + startValue)
    
    element.textContent = currentValue.toLocaleString()
    
    if (progress < 1) {
      requestAnimationFrame(updateCounter)
    } else {
      // Animasyon tamamlandığında glow efekti ekle
      element.classList.add('text-glow')
    }
  }
  
  // Animasyonu başlat
  element.classList.add('counter-animate')
  requestAnimationFrame(updateCounter)
}

// Responsive Scroll Animasyonları
function setupScrollAnimations() {
  // Tüm bağlantıları seç
  const links = document.querySelectorAll('a[href^="#"]')
  
  links.forEach(link => {
    link.addEventListener('click', function(e) {
      // Varsayılan davranışı engelle
      e.preventDefault()
      
      // Hedef elementi al
      const targetId = this.getAttribute('href')
      if (targetId === '#') return
      
      const targetElement = document.querySelector(targetId)
      
      if (targetElement) {
        // Header yüksekliğini al ve offset olarak kullan
        const headerHeight = document.querySelector('header').offsetHeight
        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight
        
        // Düzgün kaydırma
        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        })
      }
    })
  })
}

// Fade-in-up Animasyonları
function setupFadeAnimations() {
  // Tüm fade-in-up elementlerini seç
  const fadeElements = document.querySelectorAll('.fade-in-up')
  
  // IntersectionObserver ile görünürlük kontrolü
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      // Eğer element görünür hale geldiyse
      if (entry.isIntersecting) {
        // Görünür sınıfını ekle
        entry.target.classList.add('visible')
        
        // Bir kez göründükten sonra gözlemlemeyi durdur
        observer.unobserve(entry.target)
      }
    })
  }, { 
    threshold: 0.15,
    rootMargin: '0px 0px -100px 0px' // Ekranın alt kısmından 100px yukarıda tetiklensin
  })
  
  // Tüm fade elementlerini gözlemle
  fadeElements.forEach(element => {
    observer.observe(element)
  })
}

// Responsive İşlemler
function setupResponsiveHandlers() {
  // Tarayıcı yeniden boyutlandırıldığında çağrılacak fonksiyon
  function handleResize() {
    const width = window.innerWidth
    
    // 1. Hero bölümü yüksekliğini ayarla
    const heroSection = document.querySelector('section:first-of-type')
    if (heroSection) {
      if (width < 480) {
        heroSection.style.height = '400px'
      } else if (width < 768) {
        heroSection.style.height = '500px'
      } else {
        heroSection.style.height = '600px'
      }
    }
    
    // 2. İçerik bölümlerindeki boşlukları ayarla
    document.querySelectorAll('.fade-in-up').forEach(el => {
      if (el.classList.contains('visible')) {
        el.classList.remove('fade-in-up')
      }
    })
  }
  
  // Pencere yeniden boyutlandırıldığında
  window.addEventListener('resize', handleResize)
  
  // Touch cihazları için dokunma hedeflerini geliştir
  if ('ontouchstart' in window) {
    document.querySelectorAll('a, button, .btn').forEach(el => {
      if (el.offsetWidth < 44 || el.offsetHeight < 44) {
        el.style.minHeight = '44px'
        el.style.minWidth = '44px'
        el.style.display = 'inline-flex'
        el.style.alignItems = 'center'
        el.style.justifyContent = 'center'
      }
    })
  }
  
  // Navbar Scroll Efekti - performans için throttle edilmiş
  let lastScrollPosition = 0
  let ticking = false
  
  window.addEventListener('scroll', () => {
    lastScrollPosition = window.scrollY
    
    if (!ticking) {
      window.requestAnimationFrame(() => {
        const header = document.querySelector('.modern-header')
        
        // Scroll pozisyonuna göre header'ı güncelle (mobil için farklı eşik)
        const threshold = isMobile ? 30 : 50
        if (lastScrollPosition > threshold) {
          header.style.background = 'rgba(0, 0, 0, 0.95)'
          header.style.backdropFilter = 'blur(10px)'
          header.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.3)'
        } else {
          header.style.background = 'rgba(0, 0, 0, 0.8)'
          header.style.backdropFilter = 'blur(10px)'
          header.style.boxShadow = 'none'
        }
        
        ticking = false
      })
      
      ticking = true
    }
  })
  
  // Mobil ağlar için sayfa performansını optimize et
  if ('connection' in navigator) {
    const connection = navigator.connection
    
    if (connection.saveData || connection.effectiveType.includes('2g') || connection.effectiveType.includes('slow')) {
      // Yavaş bağlantıda animasyonları devre dışı bırak
      document.documentElement.style.setProperty('--transition-normal', '0s')
      document.documentElement.style.setProperty('--transition-slow', '0s')
      
      // Animasyonları devre dışı bırak
      const style = document.createElement('style')
      style.textContent = `
        .fade-in-up, .counter-animate, .scroll-indicator {
          animation: none !important;
          opacity: 1 !important;
          transform: none !important;
        }
      `
      document.head.appendChild(style)
    }
  }
}
