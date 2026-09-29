;(function ($, window, document, undefined) {
  'use strict';

  var State = {
    completed: 'is-completed',
    selected: 'is-selected'
  };

  var PLACEHOLDER_AVATAR = '/assets/images/placeholder-avatar.svg';

  function setupLightbox() {
    var $lightbox = $('#ttp-lightbox');
    if (!$lightbox.length) {
      $lightbox = $(
        '<div id="ttp-lightbox" class="ttp-lightbox">' +
          '<button type="button" class="ttp-lightbox-close" aria-label="Kapat">&times;</button>' +
          '<img class="ttp-lightbox-img" src="" alt="" />' +
        '</div>'
      ).appendTo('body');
    }

    $(document).on('click', '.ttp-cert-btn, .ttp-cert-btn-sm', function () {
      var cert = $(this).data('cert');
      if (!cert) return;
      $lightbox.find('.ttp-lightbox-img').attr({ src: cert, alt: $(this).data('cert-title') || '' });
      $lightbox.addClass('is-open');
    });

    $lightbox.on('click', function (e) {
      if (e.target === this || $(e.target).hasClass('ttp-lightbox-close')) {
        $lightbox.removeClass('is-open');
      }
    });

    $(document).on('keydown', function (e) {
      if (e.key === 'Escape') $lightbox.removeClass('is-open');
    });
  }

  function renderRegionalCoordinator() {
    var coords = window.TTP_REGIONAL_COORDINATORS || [];
    var $mount = $('#bolge-sorumlusu-banner');
    if (!$mount.length) return;

    if (!coords.length) {
      $mount.closest('.ttp-region-section').hide();
      return;
    }

    var html = '';
    coords.forEach(function (coord) {
      html += '<div class="ttp-region-capsule">';
      html += '  <div class="ttp-region-photo-wrap">';
      html += '    <img class="ttp-region-img" src="' + (coord.photo || PLACEHOLDER_AVATAR) + '" alt="' + coord.name + '" onerror="this.onerror=null;this.src=\'' + PLACEHOLDER_AVATAR + '\';" />';
      html += '  </div>';
      html += '  <div class="ttp-region-info">';
      html += '    <h4 class="ttp-region-name">' + coord.name + '</h4>';
      html += '    <span class="ttp-region-role">' + coord.title + '</span>';
      if (coord.certificate) {
        html += '    <button type="button" class="ttp-cert-btn-sm" data-cert="' + coord.certificate + '" data-cert-title="' + coord.name + ' - Yetki Belgesi">Yetki Belgesi</button>';
      }
      html += '  </div>';
      html += '</div>';
    });
    $mount.html(html);
  }

  function initTurkeyMap() {
    var $mapSection = $('#teskilat-haritasi');
    if (!$mapSection.length) return;

    setupLightbox();
    renderRegionalCoordinator();

    var $container = $mapSection.find('.turkey-map-drawing');
    var $turkey = $('#turkiye');
    var $paths = $container.find('path');
    var $groups = $turkey.find('g');
    var $tooltip = $('.turkey-map-name');
    var $listContainer = $('#temsilciler-piramidi');

    // Tooltip: Body seviyesinde konumlandırma
    if (!$tooltip.length) {
      $tooltip = $('<div class="turkey-map-name"></div>').appendTo('body');
    } else if ($tooltip.parent()[0] !== document.body) {
      $tooltip.detach().appendTo('body');
    }

    var PROVINCES = window.TURKEY_PROVINCES_DATA || {};

    // 1. Temsilciliği olan illere kırmızı renk için "is-completed" sınıfı ekle
    $groups.each(function () {
      var _this = $(this);
      var plate = String(_this.data('plaka-kodu') || '').padStart(2, '0');
      if (PROVINCES[plate] && PROVINCES[plate].hasRepresentative) {
        _this.addClass(State.completed);
      }
    });

    // 2. Tooltip (sadece il adı)
    $paths.bind({
      mouseenter: function (event) {
        var _this = $(this);
        var parentG = _this.closest('g');
        if (parentG.attr('id') === 'guney-kibris') return false;

        var plate = String(parentG.attr('data-plaka-kodu') || parentG.data('plaka-kodu') || '').padStart(2, '0');
        var pData = PROVINCES[plate];
        var ilAdi = (pData && pData.name) || parentG.data('il-adi') || parentG.attr('id');
        $tooltip.html('<div>' + ilAdi + '</div>').show();

        _this.on('mousemove.turkeyMap', function (e) {
          $tooltip.css({
            position: 'absolute',
            top: (e.pageY + 25) + 'px',
            left: e.pageX + 'px',
            zIndex: 999999,
            pointerEvents: 'none'
          });
        });
      },
      mouseleave: function () {
        $(this).off('mousemove.turkeyMap');
        $tooltip.html('').hide();
      }
    });

    // 3. İl Detay Paneli Render Fonksiyonu
    function renderPanel(plate, ilAdi) {
      var pData = PROVINCES[plate];
      var hasRep = pData && pData.hasRepresentative && pData.hierarchy;

      var html = '';
      if (hasRep) {
        var hier = pData.hierarchy;
        var pres = hier.president || {};
        var vPres = hier.vicePresidents || [];
        var board = hier.boardMembers || [];

        html += '<div class="ttp-panel">';

        // Başlık şeridi
        html += '  <div class="ttp-panel-head">';
        html += '    <div class="ttp-panel-head-left">';
        html += '      <h3 class="ttp-panel-city">' + ilAdi + ' <span>İl Temsilciliği</span></h3>';
        html += '    </div>';
        if (pres.address) {
          html += '    <div class="ttp-panel-address">';
          html += '      <i class="fas fa-map-marker-alt"></i> ' + pres.address;
          html += '    </div>';
        }
        html += '  </div>';

        // Piramit Gövdesi
        html += '  <div class="ttp-pyramid-body">';

        // 1. Kademe: İl Başkanı (Piramit Zirvesi)
        html += '    <div class="ttp-tier ttp-tier-apex">';
        html += '      <div class="ttp-card ttp-card-apex">';
        html += '        <img class="ttp-photo" src="' + (pres.photo || PLACEHOLDER_AVATAR) + '" alt="' + (pres.name || ilAdi) + '" onerror="this.onerror=null;this.src=\'' + PLACEHOLDER_AVATAR + '\';" />';
        html += '        <div class="ttp-badge-role">İL BAŞKANI</div>';
        html += '        <div class="ttp-name-apex">' + (pres.name || ilAdi + ' İl Başkanı') + '</div>';
        if (pres.certificate) {
          html += '        <button type="button" class="ttp-cert-btn" data-cert="' + pres.certificate + '" data-cert-title="' + (pres.name || ilAdi) + ' - Yetki Belgesi">Yetki Belgesini Gör</button>';
        }
        if (pres.phone || pres.email) {
          html += '        <div class="ttp-contacts-apex">';
          if (pres.phone) {
            html += '          <a class="ttp-contact-link" href="tel:' + pres.phone.replace(/\s+/g, '') + '"><i class="fas fa-phone"></i> ' + pres.phone + '</a>';
          }
          if (pres.email) {
            html += '          <a class="ttp-contact-link" href="mailto:' + pres.email + '"><i class="fas fa-envelope"></i> ' + pres.email + '</a>';
          }
          html += '        </div>';
        }
        html += '      </div>';
        html += '    </div>';

        // 2. Kademe: Başkan Yardımcıları (Orta Kat)
        if (vPres && vPres.length > 0) {
          html += '    <div class="ttp-connector"><div class="ttp-connector-line"></div></div>';
          html += '    <div class="ttp-tier ttp-tier-vices">';
          html += '      <div class="ttp-tier-title">BAŞKAN YARDIMCILARI</div>';
          html += '      <div class="ttp-tier-row">';
          vPres.forEach(function (vp) {
            html += '        <div class="ttp-card ttp-card-vice">';
            html += '          <div class="ttp-badge-role">' + (vp.title || 'Başkan Yardımcısı') + '</div>';
            html += '          <div class="ttp-name">' + vp.name + '</div>';
            html += '        </div>';
          });
          html += '      </div>';
          html += '    </div>';
        }

        // 3. Kademe: İl Yönetim Kurulu (Piramit Tabanı)
        if (board && board.length > 0) {
          html += '    <div class="ttp-connector"><div class="ttp-connector-line"></div></div>';
          html += '    <div class="ttp-tier ttp-tier-board">';
          html += '      <div class="ttp-tier-title">İL YÖNETİM KURULU</div>';
          html += '      <div class="ttp-tier-row">';
          board.forEach(function (bm) {
            html += '        <div class="ttp-card ttp-card-board">';
            html += '          <div class="ttp-badge-role">' + (bm.title || 'Yönetim Kurulu') + '</div>';
            html += '          <div class="ttp-name">' + bm.name + '</div>';
            html += '        </div>';
          });
          html += '      </div>';
          html += '    </div>';
        }

        /* Teşkilat ağacı (admin panelden yönetilen, sınırsız derinlikte).
           Ağaç `hierarchy.children` altında iç içe geliyor; burada kademe
           kademe (BFS) düz satırlara çevrilip piramidin altına ekleniyor.
           Üretim sırası DFS olduğu için aynı üste bağlı kişiler yan yana kalır.
           1. kademe "yardımcı" kartı, 2+ kademe "yönetim kurulu" kartı stilinde. */
        var tree = hier.children || [];
        var level = tree;
        var depth = 0;
        while (level.length > 0) {
          var isFirstLevel = depth === 0;
          html += '    <div class="ttp-connector"><div class="ttp-connector-line"></div></div>';
          html += '    <div class="ttp-tier ' + (isFirstLevel ? 'ttp-tier-vices' : 'ttp-tier-board') + '">';
          html += '      <div class="ttp-tier-row">';
          var next = [];
          level.forEach(function (node) {
            var cardClass = isFirstLevel ? 'ttp-card-vice' : 'ttp-card-board';
            html += '        <div class="ttp-card ' + cardClass + '">';
            if (node.photo) {
              html += '          <img class="ttp-photo ttp-photo-sm" src="' + node.photo + '" alt="' + (node.name || '') + '" onerror="this.onerror=null;this.src=\'' + PLACEHOLDER_AVATAR + '\';" />';
            }
            if (node.title) {
              html += '          <div class="ttp-badge-role">' + node.title + '</div>';
            }
            html += '          <div class="ttp-name">' + (node.name || '') + '</div>';
            if (node.certificate) {
              html += '          <button type="button" class="ttp-cert-btn-sm" data-cert="' + node.certificate + '" data-cert-title="' + (node.name || '') + ' - Yetki Belgesi">Yetki Belgesi</button>';
            }
            html += '        </div>';
            if (node.children && node.children.length) {
              next = next.concat(node.children);
            }
          });
          html += '      </div>';
          html += '    </div>';
          level = next;
          depth++;
        }

        html += '  </div>'; // .ttp-pyramid-body
        html += '</div>'; // .ttp-panel

      } else {
        html += '<div class="ttp-empty-notice">';
        html += '  <div>';
        html += '    <h4>' + ilAdi + ' Temsilciliği</h4>';
        html += '    <p>Bu ilimizde teşkilatlanma ve il başkanlığı atama çalışmaları devam etmektedir.</p>';
        html += '  </div>';
        html += '  <div>';
        html += '    <a href="#xs_contact_form" class="ttp-apply-btn">Temsilcilik Başvurusu</a>';
        html += '  </div>';
        html += '</div>';
      }

      $listContainer.html(html).hide().fadeIn(280);
    }

    // 4. İle tıklandığında
    function selectProvince(el) {
      var $el = $(el);
      var $g = $el.is('g') ? $el : $el.closest('g');
      if (!$g.length || $g.attr('id') === 'guney-kibris') return false;

      $groups.removeClass(State.selected);
      $g.addClass(State.selected);

      var plate = String($g.attr('data-plaka-kodu') || $g.data('plaka-kodu') || '').padStart(2, '0');
      var pData = PROVINCES[plate];
      var ilAdi = (pData && pData.name) || $g.data('il-adi') || $g.attr('id');

      renderPanel(plate, ilAdi);

      if ($listContainer.length) {
        var containerTop = $listContainer.offset().top;
        var windowBottom = $(window).scrollTop() + $(window).height();
        if (containerTop > windowBottom - 100) {
          $('html, body').stop().animate({
            scrollTop: containerTop - 90
          }, 450);
        }
      }
    }

    $container.on('click', 'path', function (e) {
      e.stopPropagation();
      selectProvince(this);
    });

    $groups.on('click', function () {
      selectProvince(this);
    });

    (function renderMobileProvinceList() {
      var reps = [];
      Object.keys(PROVINCES).forEach(function (plate) {
        var p = PROVINCES[plate];
        if (p && p.hasRepresentative) reps.push({ plate: plate, name: p.name });
      });
      if (!reps.length || !$listContainer.length) return;
      reps.sort(function (a, b) { return a.name.localeCompare(b.name, 'tr'); });

      var $wrap = $('<div class="ttp-mobile-province-list"></div>');
      var $chips = $('<div class="ttp-mobile-province-chips"></div>');
      reps.forEach(function (r) {
        $chips.append(
          $('<button type="button" class="ttp-mobile-province-chip"></button>')
            .attr('data-plaka-kodu', r.plate)
            .text(r.name)
        );
      });
      $wrap.append($chips);
      $wrap.insertBefore($listContainer);

      $wrap.on('click', '.ttp-mobile-province-chip', function () {
        var plate = String($(this).attr('data-plaka-kodu')).padStart(2, '0');
        var $g = $groups.filter(function () {
          return String($(this).attr('data-plaka-kodu') || $(this).data('plaka-kodu') || '').padStart(2, '0') === plate;
        });
        if ($g.length) selectProvince($g[0]);
      });
    })();
  }

  $(document).ready(function () {
    initTurkeyMap();
  });

})(window.jQuery, window, document);
