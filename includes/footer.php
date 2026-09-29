<?php if (!defined("TTP_BOOTSTRAPPED")) { http_response_code(403); exit("Forbidden"); } ?>
    <footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" class="ttp-site-footer"
      role="contentinfo">
      <div class="ttp-footer-container">
        <div class="ttp-footer-main">
          <!-- 1. Sütun: Marka & Platform Bilgisi -->
          <div class="ttp-footer-brand">
            <a href="/index.php" class="ttp-footer-logo-link" title="Terörsüz Türkiye Platformu">
              <img src="/wp-content/uploads/2026/03/Terorsuz-Turkiye-2-copy-300x300.png"
                alt="Terörsüz Türkiye Platformu Logosu" class="ttp-footer-logo" width="50" height="50">
              <div class="ttp-footer-brand-title">
                <span class="ttp-footer-title">TERÖRSÜZ TÜRKİYE</span>
                <span class="ttp-footer-subtitle">PLATFORMU</span>
              </div>
            </a>
            <p class="ttp-footer-tagline">
              Milli birlik, kardeşlik ve dayanışma iradesiyle terörsüz bir gelecek için 81 ilde el ele.
            </p>
          </div>

          <!-- 2. Sütun: Hızlı Bağlantılar (Header Menü ile Birebir Aynı Başlıklar & Alt Başlıklar) -->
          <div class="ttp-footer-nav-wrap">
            <h4 class="ttp-footer-heading">Hızlı Bağlantılar</h4>
            <div class="ttp-footer-nav-columns">
              <!-- Sol Kolon: Anasayfa, Kurumsal, Yönetim Kurulu -->
              <div class="ttp-footer-nav-col">
                <div class="ttp-footer-nav-group">
                  <a href="/index.php" class="ttp-footer-nav-main-link">Anasayfa</a>
                </div>

                <div class="ttp-footer-nav-group">
                  <span class="ttp-footer-nav-title">Kurumsal</span>
                  <ul class="ttp-footer-nav-sublist">
                    <li><a href="/kurumsal/hakkimizda.php">Hakkımızda</a></li>
                    <li><a href="/index.php#misyon-vizyon-section">Vizyonumuz</a></li>
                    <li><a href="/index.php#misyon-vizyon-section">Misyonumuz</a></li>
                    <li><a href="/kurumsal/tuzuk.php">Tüzüğümüz</a></li>
                    <li><a href="/kurumsal/belgeler.php">Belgeler</a></li>
                  </ul>
                </div>

                <div class="ttp-footer-nav-group">
                  <a href="/index.php#yonetim-kurulu-section" class="ttp-footer-nav-main-link">Yönetim Kurulu</a>
                </div>
              </div>

              <!-- Sağ Kolon: Temsilcilikler, Projeler, Haberler, İletişim -->
              <div class="ttp-footer-nav-col">
                <div class="ttp-footer-nav-group">
                  <span class="ttp-footer-nav-title">Temsilcilikler</span>
                  <ul class="ttp-footer-nav-sublist">
                    <li><a href="/il-ve-ilce-baskanliklari/">İl ve İlçe Başkanlıkları</a></li>
                    <li><a href="/ulke-temsilcilikleri.php">Ülke Temsilcilikleri</a></li>
                  </ul>
                </div>

                <div class="ttp-footer-nav-group">
                  <a href="/projeler.php" class="ttp-footer-nav-main-link">Projeler</a>
                </div>

                <div class="ttp-footer-nav-group">
                  <a href="/haberler/" class="ttp-footer-nav-main-link">Haberler</a>
                </div>

                <div class="ttp-footer-nav-group">
                  <a href="/iletisim.php" class="ttp-footer-nav-main-link">İletişim</a>
                </div>
              </div>
            </div>
          </div>

          <!-- 3. Sütun: İletişim & Sosyal Medya -->
          <div class="ttp-footer-contact">
            <h4 class="ttp-footer-heading">İletişim</h4>
            <a href="https://wa.me/90212695163" target="_blank" class="ttp-footer-contact-item">
              <span class="ttp-footer-contact-icon">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                  </path>
                </svg>
              </span>
              <span>WhatsApp İletişim Hattı</span>
            </a>

            <a href="mailto:info@terorsuzturkiyeplatformu.org" class="ttp-footer-contact-item">
              <span class="ttp-footer-contact-icon">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                  stroke-linecap="round" stroke-linejoin="round">
                  <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                  <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
              </span>
              <span>info@terorsuzturkiyeplatformu.org</span>
            </a>

            <div class="ttp-footer-social-row">
              <a href="https://facebook.com" target="_blank" rel="noopener" aria-label="Facebook"
                class="ttp-footer-soc">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
              </a>
              <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="X Twitter"
                class="ttp-footer-soc">
                <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                </svg>
              </a>
              <a href="https://youtube.com" target="_blank" rel="noopener" aria-label="YouTube" class="ttp-footer-soc">
                <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                </svg>
              </a>
              <a href="https://instagram.com/tcterorsuzturkiyeplatformu" target="_blank" rel="noopener"
                aria-label="Instagram" class="ttp-footer-soc">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- Alt Telif ve Hukuki Haklar Barı -->
        <div class="ttp-footer-bottom">
          <div class="ttp-footer-copy">
            © 2026 <strong>Terörsüz Türkiye Platformu</strong>. Tüm hakları saklıdır.
          </div>
          <div class="ttp-footer-legal">
            <a href="#">Gizlilik Politikası</a>
            <span>•</span>
            <a href="#">Kullanım Şartları</a>
            <span>•</span>
            <a href="#">KVKK</a>
          </div>
        </div>
      </div>
    </footer>
