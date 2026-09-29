<?php if (!defined("TTP_BOOTSTRAPPED")) { http_response_code(403); exit("Forbidden"); } ?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="profile" href="https://gmpg.org/xfn/11" />
  <link rel="pingback" href="https://www.terorsuzturkiyeplatformu.org/xmlrpc.php" />
  <title><?= htmlspecialchars($ttpTitle ?? 'Terörsüz Türkiye Platformu') ?></title>
  <meta name='robots' content='max-image-preview:large' />
  <link rel='stylesheet' id='sbi-tokens-local-css'
    href='/wp-content/plugins/instagram-feed/assets/tokens/sb-tokens-local.css@ver=6.13.0.css' media='all' />
  <link rel='stylesheet' id='sbi_styles-css'
    href='/wp-content/plugins/instagram-feed/css/sbi-styles.min.css@ver=6.13.0.css' media='all' />
  <link rel='stylesheet' id='hfe-widgets-style-css'
    href='/wp-content/plugins/header-footer-elementor/inc/widgets-css/frontend.css@ver=2.9.4.css' media='all' />
  <link rel='stylesheet' id='sb-elementor-shared-style-css'
    href='/wp-content/plugins/instagram-feed/vendor/smashballoon/framework/Packages/Blocks/css/sb-elementor.css@ver=1.0.0.css'
    media='all' />
  <link rel='stylesheet' id='hfe-style-css'
    href='/wp-content/plugins/header-footer-elementor/assets/css/header-footer-elementor.css@ver=2.9.4.css'
    media='all' />
  <link rel='stylesheet' id='elementor-frontend-css'
    href='/wp-content/plugins/elementor/assets/css/frontend.min.css@ver=4.2.4.css' media='all' />
  <link rel='stylesheet' id='elementor-post-6-css' href='/wp-content/uploads/elementor/css/post-6.css@ver=1788218490.css'
    media='all' />
  <link rel='stylesheet' id='ekit-widget-common-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/common.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='ekit-heading-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/heading.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='widget-image-css'
    href='/wp-content/plugins/elementor/assets/css/widget-image.min.css@ver=4.2.4.css' media='all' />
  <link rel='stylesheet' id='ekit-button-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/button.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='ekit-icon-box-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/icon-box.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='mediaelement-css'
    href='/wp-includes/js/mediaelement/mediaelementplayer-legacy.min.css@ver=4.2.17.css' media='all' />
  <link rel='stylesheet' id='wp-mediaelement-css'
    href='/wp-includes/js/mediaelement/wp-mediaelement.min.css@ver=a19ab9e1c3fb0414e506421e96e9eb64.css' media='all' />
  <link rel='stylesheet' id='magnific-popup-css'
    href='/wp-content/plugins/elementskit-lite/assets/libs/magnific-popup/magnific-popup.css@ver=1788279241.css'
    media='all' />
  <link rel='stylesheet' id='ekit-video-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/video.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='ekit-testimonial-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/testimonial.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='swiper-css'
    href='/wp-content/plugins/elementor/assets/lib/swiper/v8/css/swiper.min.css@ver=8.4.5.css' media='all' />
  <link rel='stylesheet' id='ekit-blog-posts-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/blog-posts.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='elementor-post-34-css'
    href='/wp-content/uploads/elementor/css/post-34.css@ver=1788218490.css' media='all' />
  <link rel='stylesheet' id='elementor-post-7-css' href='/wp-content/uploads/elementor/css/post-7.css@ver=1788218490.css'
    media='all' />
  <link rel='stylesheet' id='elementor-post-165-css'
    href='/wp-content/uploads/elementor/css/post-165.css@ver=1788218490.css' media='all' />
  <link rel='stylesheet' id='hello-elementor-css'
    href='/wp-content/themes/hello-elementor/assets/css/reset.css@ver=3.4.9.css' media='all' />
  <link rel='stylesheet' id='hello-elementor-theme-style-css'
    href='/wp-content/themes/hello-elementor/assets/css/theme.css@ver=3.4.9.css' media='all' />
  <link rel='stylesheet' id='hello-elementor-header-footer-css'
    href='/wp-content/themes/hello-elementor/assets/css/header-footer.css@ver=3.4.9.css' media='all' />
  <link rel='stylesheet' id='hfe-elementor-icons-css'
    href='/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css@ver=5.34.0.css' media='all' />
  <link rel='stylesheet' id='hfe-icons-list-css'
    href='/wp-content/plugins/elementor/assets/css/widget-icon-list.min.css@ver=3.24.3.css' media='all' />
  <link rel='stylesheet' id='hfe-social-icons-css'
    href='/wp-content/plugins/elementor/assets/css/widget-social-icons.min.css@ver=3.24.0.css' media='all' />
  <link rel='stylesheet' id='hfe-social-share-icons-brands-css'
    href='/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.css@ver=5.15.3.css' media='all' />
  <link rel='stylesheet' id='hfe-social-share-icons-fontawesome-css'
    href='/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.css@ver=5.15.3.css' media='all' />
  <link rel='stylesheet' id='hfe-nav-menu-icons-css'
    href='/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.css@ver=5.15.3.css' media='all' />
  <link rel='stylesheet' id='ekit-nav-menu-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/nav-menu.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='ekit-header-search-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/header-search.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='ekit-header-offcanvas-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/header-offcanvas.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='ekit-header-info-css'
    href='/wp-content/plugins/elementskit-lite/widgets/init/assets/css/header-info.css@ver=4.0.2.css' media='all' />
  <link rel='stylesheet' id='elementor-gf-roboto-css'
    href='https://fonts.googleapis.com/css?family=Roboto:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&#038;display=swap&#038;subset=latin-ext'
    media='all' />
  <link rel='stylesheet' id='elementor-gf-robotoslab-css'
    href='https://fonts.googleapis.com/css?family=Roboto+Slab:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&#038;display=swap&#038;subset=latin-ext'
    media='all' />
  <link rel='stylesheet' id='elementor-gf-firasans-css'
    href='https://fonts.googleapis.com/css?family=Fira+Sans:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&#038;display=swap&#038;subset=latin-ext'
    media='all' />
  <link rel='stylesheet' id='elementor-gf-lato-css'
    href='https://fonts.googleapis.com/css?family=Lato:100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic&#038;display=swap&#038;subset=latin-ext'
    media='all' />
  <link rel='stylesheet' id='elementor-icons-ekiticons-css'
    href='/wp-content/plugins/elementskit-lite/modules/elementskit-icon-pack/assets/css/ekiticons.css@ver=4.0.2.css'
    media='all' />
  <script type='text/javascript'>
    var elementskit = {
      resturl: 'https://www.terorsuzturkiyeplatformu.org/index.php/wp-json/elementskit/v1/',
    }
  </script>
  <script src="/wp-includes/js/jquery/jquery.min.js@ver=3.7.1" id="jquery-core-js"></script>
  <script src="/wp-includes/js/jquery/jquery-migrate.min.js@ver=3.4.1" id="jquery-migrate-js"></script>
  <script id="jquery-js-after">
    !function ($) { "use strict"; $(document).ready(function () { $(this).scrollTop() > 100 && $(".hfe-scroll-to-top-wrap").removeClass("hfe-scroll-to-top-hide"), $(window).scroll(function () { $(this).scrollTop() < 100 ? $(".hfe-scroll-to-top-wrap").fadeOut(300) : $(".hfe-scroll-to-top-wrap").fadeIn(300) }), $(".hfe-scroll-to-top-wrap").on("click", function () { $("html, body").animate({ scrollTop: 0 }, 300); return !1 }) }) }(jQuery);
    !function ($) { 'use strict'; $(document).ready(function () { var bar = $('.hfe-reading-progress-bar'); if (!bar.length) return; $(window).on('scroll', function () { var s = $(window).scrollTop(), d = $(document).height() - $(window).height(), p = d ? s / d * 100 : 0; bar.css('width', p + '%') }); }); }(jQuery);
  </script>
  <link rel="canonical" href="/index.php" />
  <meta name="generator"
    content="Elementor 4.2.4; features: e_font_icon_svg, additional_custom_breakpoints; settings: css_print_method-external, google_font-enabled, font_display-swap">
  <link rel="stylesheet" href="<?= TTP_BASE ?>/assets/css/ttp-base.css?v=<?= TTP_ASSET_VER ?>" />
  <link rel="stylesheet" href="<?= TTP_BASE ?>/assets/css/ttp-responsive.css?v=<?= TTP_ASSET_VER ?>" />
<?php
$ttpHeroDesktop = asset_url(get_setting('hero_image_desktop'));
$ttpHeroMobile  = asset_url(get_setting('hero_image_mobile'));
if ($ttpHeroDesktop !== '' || $ttpHeroMobile !== ''):
    $ttpHeroWide     = $ttpHeroDesktop !== '' ? $ttpHeroDesktop : $ttpHeroMobile;
    $ttpHeroPortrait = $ttpHeroMobile !== ''  ? $ttpHeroMobile  : $ttpHeroDesktop;
?>
  <style id="ttp-hero-bg">
    :root { --ttp-hero-image: url("<?= htmlspecialchars($ttpHeroWide, ENT_QUOTES) ?>?v=<?= TTP_ASSET_VER ?>"); }
    @media (orientation: portrait) {
      :root { --ttp-hero-image: url("<?= htmlspecialchars($ttpHeroPortrait, ENT_QUOTES) ?>?v=<?= TTP_ASSET_VER ?>"); }
    }
  </style>
<?php endif; ?>
</head>
<body data-rsssl=1
  class="home wp-singular page-template-default page page-id-34 wp-embed-responsive wp-theme-hello-elementor ehf-header ehf-footer ehf-template-hello-elementor ehf-stylesheet-hello-elementor hello-elementor-default elementor-default elementor-kit-6 elementor-page elementor-page-34">
