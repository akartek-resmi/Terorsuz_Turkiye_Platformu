<?php if (!defined("TTP_BOOTSTRAPPED")) { http_response_code(403); exit("Forbidden"); } ?>
    <?php $ttpHeaderStyle = $ttpHeaderStyle ?? 'solid'; ?>
    <header id="masthead" class="ttp-header-<?= $ttpHeaderStyle === 'hero' ? 'hero' : 'solid' ?>" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
      <p class="main-title bhf-hidden" itemprop="headline"><a href="/index.php"
          title="Ter&ouml;rs&uuml;z T&uuml;rkiye Platformu" rel="home">Ter&ouml;rs&uuml;z T&uuml;rkiye Platformu</a></p>
      <style>
        .elementor-7 .elementor-element.elementor-element-4ca17dc9 {
          --display: flex;
          --flex-direction: column;
          --container-widget-width: calc((1 - var(--container-widget-flex-grow)) * 100%);
          --container-widget-height: initial;
          --container-widget-flex-grow: 0;
          --container-widget-align-self: initial;
          --flex-wrap-mobile: wrap;
          --align-items: stretch;
          --gap: 0px 0px;
          --row-gap: 0px;
          --column-gap: 0px;
          --padding-top: 0px;
          --padding-bottom: 0px;
          --padding-left: 0px;
          --padding-right: 0px;
        }

        .elementor-7 .elementor-element.elementor-element-2d7a5a97 {
          --display: flex;
          --flex-direction: row;
          --container-widget-width: calc((1 - var(--container-widget-flex-grow)) * 100%);
          --container-widget-height: 100%;
          --container-widget-flex-grow: 1;
          --container-widget-align-self: stretch;
          --flex-wrap-mobile: wrap;
          --justify-content: space-between;
          --align-items: center;
          --gap: 10px 10px;
          --row-gap: 10px;
          --column-gap: 10px;
          --padding-top: 8px;
          --padding-bottom: 8px;
          --padding-left: 15px;
          --padding-right: 15px;
        }

        .elementor-7 .elementor-element.elementor-element-2d7a5a97:not(.elementor-motion-effects-element-type-background),
        .elementor-7 .elementor-element.elementor-element-2d7a5a97>.elementor-motion-effects-container>.elementor-motion-effects-layer {
          background-color: #1D4113;
        }

        .elementor-widget-icon-list .elementor-icon-list-item:not(:last-child):after {
          border-color: var(--e-global-color-text);
        }

        .elementor-widget-icon-list .elementor-icon-list-icon i {
          color: var(--e-global-color-primary);
        }

        .elementor-widget-icon-list .elementor-icon-list-icon svg {
          fill: var(--e-global-color-primary);
        }

        .elementor-widget-icon-list .elementor-icon-list-item>.elementor-icon-list-text,
        .elementor-widget-icon-list .elementor-icon-list-item>a {
          font-family: var(--e-global-typography-text-font-family), Sans-serif;
          font-weight: var(--e-global-typography-text-font-weight);
        }

        .elementor-widget-icon-list .elementor-icon-list-text {
          color: var(--e-global-color-secondary);
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child) {
          padding-block-end: calc(15px/2);
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child) {
          margin-block-start: calc(15px/2);
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item {
          margin-inline: calc(15px/2);
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items.elementor-inline-items {
          margin-inline: calc(-15px/2);
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after {
          inset-inline-end: calc(-15px/2);
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-icon i {
          color: #ffffff;
          transition: color 0.3s;
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-icon svg {
          fill: #ffffff;
          transition: fill 0.3s;
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 {
          --e-icon-list-icon-size: 1em;
          --icon-vertical-align: center;
          --icon-vertical-offset: -1px;
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-icon {
          padding-inline-end: 0px;
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-item>.elementor-icon-list-text,
        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-item>a {
          font-family: "Roboto", Sans-serif;
          font-weight: 400;
        }

        .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-text {
          color: #ffffff;
          transition: color 0.3s;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-5eb0945>a i {
          color: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-5eb0945>a svg {
          fill: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-5eb0945>a {
          background-color: rgba(255, 255, 255, 0);
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-5eb0945>a:hover {
          color: #4852ba;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-5eb0945>a:hover svg {
          fill: #4852ba;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-404d637>a i {
          color: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-404d637>a svg {
          fill: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-404d637>a {
          background-color: rgba(161, 161, 161, 0);
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-404d637>a:hover {
          color: #1da1f2;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-404d637>a:hover svg {
          fill: #1da1f2;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-98fdd10>a i {
          color: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-98fdd10>a svg {
          fill: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-98fdd10>a:hover {
          color: #0077b5;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-98fdd10>a:hover svg {
          fill: #0077b5;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-e2aa959>a i {
          color: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-e2aa959>a svg {
          fill: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-e2aa959>a:hover {
          color: #e4405f;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .elementor-repeater-item-e2aa959>a:hover svg {
          fill: #e4405f;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796>.elementor-widget-container {
          padding: 0px 0px 0px 0px;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media {
          text-align: right;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media>li>a {
          text-align: center;
          text-decoration: none;
          width: 30px;
          height: 30px;
          line-height: 28px;
        }

        .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media>li {
          display: inline-block;
          margin: 0px -2px 0px 10px;
        }

        .elementor-7 .elementor-element.elementor-element-674ce3f2 {
          --display: flex;
          --flex-direction: row;
          --container-widget-width: calc((1 - var(--container-widget-flex-grow)) * 100%);
          --container-widget-height: 100%;
          --container-widget-flex-grow: 1;
          --container-widget-align-self: stretch;
          --flex-wrap-mobile: wrap;
          --align-items: center;
          --gap: 10px 10px;
          --row-gap: 10px;
          --column-gap: 10px;
          --padding-top: 10px;
          --padding-bottom: 10px;
          --padding-left: 0px;
          --padding-right: 0px;
        }

        .elementor-7 .elementor-element.elementor-element-674ce3f2:not(.elementor-motion-effects-element-type-background),
        .elementor-7 .elementor-element.elementor-element-674ce3f2>.elementor-motion-effects-container>.elementor-motion-effects-layer {
          background-color: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-43f4a29 {
          --display: flex;
          --gap: 0px 0px;
          --row-gap: 0px;
          --column-gap: 0px;
          --padding-top: 0px;
          --padding-bottom: 0px;
          --padding-left: 15px;
          --padding-right: 15px;
        }

        .elementor-7 .elementor-element.elementor-element-43f4a29.e-con {
          --flex-grow: 0;
          --flex-shrink: 0;
        }

        .elementor-widget-image .widget-image-caption {
          color: var(--e-global-color-text);
          font-family: var(--e-global-typography-text-font-family), Sans-serif;
          font-weight: var(--e-global-typography-text-font-weight);
        }

        .elementor-7 .elementor-element.elementor-element-6d538e30 {
          width: var(--container-widget-width, 77.033%);
          max-width: 77.033%;
          --container-widget-width: 77.033%;
          --container-widget-flex-grow: 0;
          text-align: start;
        }

        .elementor-7 .elementor-element.elementor-element-6d538e30.elementor-element {
          --flex-grow: 0;
          --flex-shrink: 0;
        }

        .elementor-7 .elementor-element.elementor-element-6d538e30 img {
          width: 230px;
        }

        .elementor-7 .elementor-element.elementor-element-75f773f0 {
          --display: flex;
          --flex-direction: row;
          --container-widget-width: calc((1 - var(--container-widget-flex-grow)) * 100%);
          --container-widget-height: 100%;
          --container-widget-flex-grow: 1;
          --container-widget-align-self: stretch;
          --flex-wrap-mobile: wrap;
          --justify-content: flex-end;
          --align-items: center;
          --gap: 0px 0px;
          --row-gap: 0px;
          --column-gap: 0px;
          --padding-top: 0px;
          --padding-bottom: 0px;
          --padding-left: 15px;
          --padding-right: 15px;
        }

        .elementor-7 .elementor-element.elementor-element-75f773f0.e-con {
          --flex-grow: 0;
          --flex-shrink: 0;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger:hover {
          background-color: #ff5e13;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af {
          width: auto;
          max-width: auto;
          z-index: 15;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-menu-container {
          height: 70px;
          border-radius: 0px 0px 0px 0px;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a {
          font-family: "Roboto", Sans-serif;
          font-size: 14px;
          font-weight: 500;
          text-transform: uppercase;
          color: #1D4113;
          padding: 0px 8px 0px 8px;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a:hover {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a:focus {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a:active {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li:hover>a {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li:hover>a .elementskit-submenu-indicator {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a:hover .elementskit-submenu-indicator {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a:focus .elementskit-submenu-indicator {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a:active .elementskit-submenu-indicator {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li.current-menu-item>a {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li.current-menu-ancestor>a {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li.current-menu-ancestor>a .elementskit-submenu-indicator {
          color: #1D4113;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a .elementskit-submenu-indicator {
          color: #021343;
          fill: #021343;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a .ekit-submenu-indicator-icon {
          color: #021343;
          fill: #021343;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li>a {
          font-family: "Roboto", Sans-serif;
          font-size: 15px;
          font-weight: 400;
          padding: 6px 0px 7px 0px;
          color: #000000;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li>a:hover {
          color: #121147;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li>a:focus {
          color: #121147;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li>a:active {
          color: #121147;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li:hover>a {
          color: #121147;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li.current-menu-item>a {
          color: #707070 !important;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-submenu-panel {
          padding: 15px 15px 15px 25px;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel {
          border-radius: 0px 0px 0px 0px;
          min-width: 220px;
          box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.12);
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger {
          float: right;
          border-style: solid;
          border-color: #ff5e13;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger .elementskit-menu-hamburger-icon {
          background-color: #ff5e13;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger>.ekit-menu-icon {
          color: #ff5e13;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger:hover .elementskit-menu-hamburger-icon {
          background-color: rgba(255, 255, 255, 0.5);
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger:hover>.ekit-menu-icon {
          color: rgba(255, 255, 255, 0.5);
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-close {
          color: #ff5e13;
        }

        .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-close:hover {
          color: rgba(0, 0, 0, 0.5);
        }

        .elementor-7 .elementor-element.elementor-element-5b4863a2 {
          width: auto;
          max-width: auto;
          margin: 0px 0px calc(var(--kit-widget-spacing, 0px) + 0px) 20px;
        }

        .elementor-7 .elementor-element.elementor-element-5b4863a2 .ekit_navsearch-button :is(i, svg) {
          font-size: 16px;
        }

        .elementor-7 .elementor-element.elementor-element-5b4863a2 .ekit_navsearch-button,
        .elementor-7 .elementor-element.elementor-element-5b4863a2 .ekit_search-button {
          color: #FFFFFF;
          fill: #FFFFFF;
        }

        .elementor-7 .elementor-element.elementor-element-5b4863a2 .ekit_navsearch-button {
          background-color: #1D4113;
          margin: 5px 5px 5px 5px;
          padding: 0px 0px 0px 0px;
          width: 30px;
          height: 30px;
          line-height: 30px;
          text-align: center;
        }

        .elementor-7 .elementor-element.elementor-element-7e31bba .ekit-btn-wraper .elementskit-btn {
          justify-content: center;
        }

        .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn {
          background-color: #1D4113;
          border-style: none;
        }

        .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn:hover {
          color: #ffffff;
          fill: #ffffff;
        }

        .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn> :is(i, svg) {
          font-size: 14px;
        }

        .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn>i,
        .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn>svg {
          margin-right: 5px;
        }

        .rtl .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn>i,
        .rtl .elementor-7 .elementor-element.elementor-element-7e31bba .elementskit-btn>svg {
          margin-left: 5px;
          margin-right: 0;
        }

        @media(max-width:1024px) {
          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:last-child) {
            padding-block-end: calc(9px/2);
          }

          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items:not(.elementor-inline-items) .elementor-icon-list-item:not(:first-child) {
            margin-block-start: calc(9px/2);
          }

          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item {
            margin-inline: calc(9px/2);
          }

          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items.elementor-inline-items {
            margin-inline: calc(-9px/2);
          }

          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-items.elementor-inline-items .elementor-icon-list-item:after {
            inset-inline-end: calc(-9px/2);
          }

          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-item>.elementor-icon-list-text,
          .elementor-7 .elementor-element.elementor-element-7d9adc09 .elementor-icon-list-item>a {
            font-size: 13px;
          }

          .elementor-7 .elementor-element.elementor-element-38d88796>.elementor-widget-container {
            margin: 0px -10px 0px 0px;
          }

          .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media>li {
            margin: 0px 0px 0px 0px;
          }

          .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media>li>a i {
            font-size: 12px;
          }

          .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media>li>a svg {
            max-width: 12px;
          }

          .elementor-7 .elementor-element.elementor-element-674ce3f2 {
            --padding-top: 12px;
            --padding-bottom: 12px;
            --padding-left: 0px;
            --padding-right: 0px;
          }

          .elementor-7 .elementor-element.elementor-element-75f773f0 {
            --align-items: center;
            --container-widget-width: calc((1 - var(--container-widget-flex-grow)) * 100%);
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-nav-identity-panel {
            padding: 10px 0px 10px 0px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-menu-container {
            max-width: 350px;
            border-radius: 0px 0px 0px 0px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav>li>a {
            color: #000000;
            padding: 10px 15px 10px 15px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel>li>a {
            padding: 15px 15px 15px 15px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-navbar-nav .elementskit-submenu-panel {
            border-radius: 0px 0px 0px 0px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger {
            padding: 8px 8px 8px 8px;
            width: 45px;
            border-radius: 3px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-close {
            padding: 8px 8px 8px 8px;
            margin: 12px 12px 12px 12px;
            width: 45px;
            border-radius: 3px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-nav-logo>img {
            max-width: 160px;
            max-height: 60px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-nav-logo {
            margin: 5px 0px 5px 0px;
            padding: 5px 5px 5px 5px;
          }
        }

        @media(min-width:768px) {
          .elementor-7 .elementor-element.elementor-element-2d7a5a97 {
            --content-width: 1200px;
          }

          .elementor-7 .elementor-element.elementor-element-674ce3f2 {
            --content-width: 1230px;
          }

          .elementor-7 .elementor-element.elementor-element-43f4a29 {
            --width: 12.232%;
          }

          .elementor-7 .elementor-element.elementor-element-75f773f0 {
            --width: 81.606%;
          }
        }

        @media(max-width:767px) {
          .elementor-7 .elementor-element.elementor-element-2d7a5a97 {
            --justify-content: center;
            --align-items: center;
            --container-widget-width: calc((1 - var(--container-widget-flex-grow)) * 100%);
            --padding-top: 10px;
            --padding-bottom: 6px;
            --padding-left: 0px;
            --padding-right: 0px;
          }

          .elementor-7 .elementor-element.elementor-element-38d88796 .ekit_social_media {
            text-align: center;
          }

          .elementor-7 .elementor-element.elementor-element-674ce3f2 {
            --flex-wrap: nowrap;
          }

          .elementor-7 .elementor-element.elementor-element-43f4a29 {
            --width: 50%;
          }

          .elementor-7 .elementor-element.elementor-element-6d538e30 img {
            max-width: 130px;
          }

          .elementor-7 .elementor-element.elementor-element-75f773f0 {
            --width: 50%;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af button.elementskit-menu-hamburger {
            border-width: 1px 1px 1px 1px;
          }

          .elementor-7 .elementor-element.elementor-element-1d98a9af .elementskit-nav-logo>img {
            max-width: 120px;
            max-height: 50px;
          }
        }
      
    </style>
      <div class="ttp-header-unified-wrapper">
        <!-- SOL: BÜYÜTÜLMÜŞ LOGO (İki satır boyunca dikey uzanır) -->
        <div class="ttp-header-logo-container">
          <a href="/index.php" class="ttp-main-logo-link" title="Terörsüz Türkiye Platformu">
            <img fetchpriority="high" src="/wp-content/uploads/2026/03/Terorsuz-Turkiye-2-copy.png"
              alt="Terörsüz Türkiye Platformu" class="ttp-main-logo-img">
          </a>
        </div>

        <!-- SAĞ: İKİ SATIRLI ÜST VE ALT ŞERİT -->
        <div class="ttp-header-nav-column">
          <!-- 1. ÜST SATIR: İletişim, Sosyal Medya ve Dil Seçici -->
          <div class="ttp-top-bar-row">
            <div
              class="elementor-element elementor-element-7d9adc09 elementor-icon-list--layout-inline elementor-widget elementor-widget-icon-list"
              data-id="7d9adc09" data-element_type="widget" data-widget_type="icon-list.default"
              style="margin-block-end: 0px">
              <ul class="elementor-icon-list-items elementor-inline-items">
                <li class="elementor-icon-list-item elementor-inline-item">
                  <a href="<?= ($w = get_setting('contact_whatsapp')) ? 'https://wa.me/' . preg_replace('/\D/', '', $w) : '#' ?>" target="_blank" rel="noopener">
                    <span class="elementor-icon-list-icon">
                      <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" style="display: block;">
                        <path
                          d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                      </svg>
                    </span>
                    <span class="elementor-icon-list-text"><?= htmlspecialchars($w ?: 'Whatsapp İletişim') ?></span>
                  </a>
                </li>
                <li class="elementor-icon-list-item elementor-inline-item">
                  <a href="<?= ($e = get_setting('contact_email')) ? 'mailto:' . htmlspecialchars($e) : '#' ?>">
                    <span class="elementor-icon-list-icon">
                      <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" style="display: block;">
                        <path
                          d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zm0 2v.511l-8 5.333-8-5.333V6h16zM4 18V9.044l7.445 4.963a1.003 1.003 0 0 0 1.11 0L20 9.044 20.002 18H4z" />
                      </svg>
                    </span>
                    <span class="elementor-icon-list-text"><?= htmlspecialchars($e ?: 'E-posta') ?></span>
                  </a>
                </li>
                <li class="elementor-icon-list-item elementor-inline-item">
                  <span class="elementor-icon-list-icon">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" style="display: block;">
                      <path
                        d="M12 2C7.589 2 4 5.589 4 9.995c0 5.253 7.156 11.458 7.461 11.721a.823.823 0 0 0 1.078 0C12.844 21.453 20 15.248 20 9.995 20 5.589 16.411 2 12 2zm0 12c-2.206 0-4-1.794-4-4s1.794-4 4-4 4 1.794 4 4-1.794 4-4 4z" />
                    </svg>
                  </span>
                  <span class="elementor-icon-list-text"><?= htmlspecialchars(get_setting('contact_address') ?: 'Adres') ?></span>
                </li>
              </ul>
            </div>

            <div class="ttp-topbar-right-group">
              <div
                class="elementor-element elementor-element-38d88796 elementor-widget elementor-widget-elementskit-social-media"
                data-id="38d88796" data-element_type="widget" data-widget_type="elementskit-social-media.default"
                style="margin-block-end: 0px">
                <div class="elementor-widget-container">
                  <div class="ekit-wid-con">
                    <ul class="ekit_social_media">
                      <?php $ttpSocial = ['facebook'=>['Facebook','facebook','icon-facebook'],'twitter'=>['Twitter','twitter','icon-x-twitter'],'linkedin'=>['youtube','v','icon-youtube-v'],'instagram'=>['Instagram','1','icon-instagram-1']];
                      foreach ($ttpSocial as $skey => [$label, $cls, $icon]): $url = get_setting('social_' . $skey); if (!$url) continue; ?>
                      <li><a href="<?= htmlspecialchars(safe_url($url)) ?>" target="_blank" rel="noopener" aria-label="<?= $label ?>"
                          class="<?= $cls ?>"><i aria-hidden="true" class="icon <?= $icon ?>"></i></a></li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Gömülü Dil Seçici -->
              <div class="ttp-embedded-lang-switcher notranslate" id="ttpLangSwitcher" translate="no">
                <button type="button" class="ttp-lang-toggle-btn" id="ttpLangBtn" aria-label="Dil Seçimi"
                  aria-expanded="false">
                  <span class="ttp-flag-icon">
                    <svg viewBox="0 0 1200 800" width="22" height="15"
                      style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.4);">
                      <rect width="1200" height="800" fill="#E30A17" />
                      <circle cx="425" cy="400" r="200" fill="#ffffff" />
                      <circle cx="475" cy="400" r="160" fill="#E30A17" />
                      <polygon points="583.33,400 700.86,438.19 628.21,338.19 628.21,461.81 700.86,361.81"
                        fill="#ffffff" />
                    </svg>
                  </span>
                  <span class="ttp-lang-code">TR</span>
                  <svg class="ttp-chevron" width="10" height="6" viewBox="0 0 10 6" fill="none" stroke="#444"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 1l4 4 4-4" />
                  </svg>
                </button>
                <div class="ttp-lang-dropdown-menu" id="ttpLangDropdown">
                  <a href="javascript:void(0)" class="ttp-lang-option active" data-lang="tr"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 1200 800" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="1200" height="800" fill="#E30A17" />
                        <circle cx="425" cy="400" r="200" fill="#ffffff" />
                        <circle cx="475" cy="400" r="160" fill="#E30A17" />
                        <polygon points="583.33,400 700.86,438.19 628.21,338.19 628.21,461.81 700.86,361.81"
                          fill="#ffffff" />
                      </svg></span><span class="ttp-lang-name">Turkish (TR)</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="ar"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="16" fill="#006C35" />
                        <path d="M5,6.5 Q12,4.5 19,6.5 Q12,8.5 5,6.5" fill="none" stroke="#fff" stroke-width="1.2" />
                        <line x1="7" y1="11" x2="17" y2="11" stroke="#fff" stroke-width="1" />
                      </svg></span><span class="ttp-lang-name">Arabic</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="az"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="5.33" fill="#00B5E2" />
                        <rect y="5.33" width="24" height="5.34" fill="#EF3340" />
                        <rect y="10.67" width="24" height="5.33" fill="#509E2F" />
                        <circle cx="11.5" cy="8" r="2.2" fill="#fff" />
                        <circle cx="12" cy="8" r="1.8" fill="#EF3340" />
                        <circle cx="13.5" cy="8" r="0.7" fill="#fff" />
                      </svg></span><span class="ttp-lang-name">Azerbaijani</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="bg"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="5.33" fill="#FFFFFF" />
                        <rect y="5.33" width="24" height="5.34" fill="#00966E" />
                        <rect y="10.67" width="24" height="5.33" fill="#D62612" />
                      </svg></span><span class="ttp-lang-name">Bulgarian</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="zh-CN"><span
                      class="ttp-flag-icon"><svg viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="16" fill="#DE2910" />
                        <polygon points="4.5,2.5 5.2,4.5 3.5,3.3 5.5,3.3 3.8,4.5" fill="#FFDE00" />
                        <circle cx="7.5" cy="2" r="0.5" fill="#FFDE00" />
                        <circle cx="8.5" cy="3.5" r="0.5" fill="#FFDE00" />
                        <circle cx="8.5" cy="5.5" r="0.5" fill="#FFDE00" />
                        <circle cx="7.5" cy="7" r="0.5" fill="#FFDE00" />
                      </svg></span><span class="ttp-lang-name">Chinese (Simplified)</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="en"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="16" fill="#012169" />
                        <path d="M0,0 L24,16 M24,0 L0,16" stroke="#fff" stroke-width="2.5" />
                        <path d="M0,0 L24,16 M24,0 L0,16" stroke="#C8102E" stroke-width="1.5" />
                        <path d="M12,0 V16 M0,8 H24" stroke="#fff" stroke-width="4.5" />
                        <path d="M12,0 V16 M0,8 H24" stroke="#C8102E" stroke-width="2.5" />
                      </svg></span><span class="ttp-lang-name">English</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="fr"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="8" height="16" fill="#002395" />
                        <rect x="8" width="8" height="16" fill="#FFFFFF" />
                        <rect x="16" width="8" height="16" fill="#ED2939" />
                      </svg></span><span class="ttp-lang-name">French</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="de"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="5.33" fill="#000000" />
                        <rect y="5.33" width="24" height="5.34" fill="#DD0000" />
                        <rect y="10.67" width="24" height="5.33" fill="#FFCE00" />
                      </svg></span><span class="ttp-lang-name">German</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="it"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="8" height="16" fill="#009246" />
                        <rect x="8" width="8" height="16" fill="#FFFFFF" />
                        <rect x="16" width="8" height="16" fill="#CE2B37" />
                      </svg></span><span class="ttp-lang-name">Italian</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="ku"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="5.33" fill="#E4002B" />
                        <rect y="5.33" width="24" height="5.34" fill="#FFFFFF" />
                        <rect y="10.67" width="24" height="5.33" fill="#00843D" />
                        <circle cx="12" cy="8" r="2.3" fill="#FFD100" />
                      </svg></span><span class="ttp-lang-name">Kurdish (Kurmanji)</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="fa"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="5.33" fill="#239F40" />
                        <rect y="5.33" width="24" height="5.34" fill="#FFFFFF" />
                        <rect y="10.67" width="24" height="5.33" fill="#DA0000" />
                        <circle cx="12" cy="8" r="1.4" fill="#DA0000" />
                      </svg></span><span class="ttp-lang-name">Persian</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="ru"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="5.33" fill="#FFFFFF" />
                        <rect y="5.33" width="24" height="5.34" fill="#0039A6" />
                        <rect y="10.67" width="24" height="5.33" fill="#D52B1E" />
                      </svg></span><span class="ttp-lang-name">Russian</span></a>
                  <a href="javascript:void(0)" class="ttp-lang-option" data-lang="es"><span class="ttp-flag-icon"><svg
                        viewBox="0 0 24 16" width="22" height="15"
                        style="border-radius: 2px; display: block; box-shadow: 0 0 1px rgba(0,0,0,0.3);">
                        <rect width="24" height="4" fill="#AA151B" />
                        <rect y="4" width="24" height="8" fill="#F1BF00" />
                        <rect y="12" width="24" height="4" fill="#AA151B" />
                        <circle cx="6" cy="8" r="1.3" fill="#AA151B" />
                      </svg></span><span class="ttp-lang-name">Spanish</span></a>
                  <span class="ttp-lang-attribution">Google Çeviri ile desteklenmektedir</span>
                </div>
              </div>
            </div>
          </div>

          <!-- 2. ALT SATIR: Menü, Arama ve Belge Doğrulama -->
          <div class="ttp-bottom-nav-row">
            <div class="elementor-element elementor-element-1d98a9af elementor-widget elementor-widget-ekit-nav-menu"
              data-id="1d98a9af" data-element_type="widget" data-widget_type="ekit-nav-menu.default">
              <div class="elementor-widget-container">
                <nav class="ekit-wid-con ekit_menu_responsive_tablet" data-hamburger-icon=""
                  data-hamburger-icon-type="icon" data-responsive-breakpoint="1024" data-close-on-anchor="no">
                  <button class="elementskit-menu-hamburger elementskit-menu-toggler" type="button"
                    aria-label="hamburger-icon">
                    <span class="elementskit-menu-hamburger-icon"></span><span
                      class="elementskit-menu-hamburger-icon"></span><span
                      class="elementskit-menu-hamburger-icon"></span>
                  </button>
                  <div id="ekit-megamenu-ana"
                    class="elementskit-menu-container elementskit-menu-offcanvas-elements elementskit-navbar-nav-default ekit-nav-menu-one-page-no ekit-nav-dropdown-hover">
                    <!-- `submenu-click-on-icon` BİLEREK YOK: o sınıf varken
                         ElementsKit alt menüyü yalnızca sağdaki chevron ikonuna
                         tıklanınca açıyordu (nav-menu.js: tıklama hedefi
                         `.elementskit-submenu-indicator` değilse yok sayılıyor).
                         Mobilde bu küçük hedefe basmak zor olduğu için sınıf
                         kaldırıldı; artık "Kurumsal"/"Temsilcilikler" satırının
                         herhangi bir yerine basmak alt menüyü açıyor. Bu güvenli,
                         çünkü bu iki öğenin <a>'sında href yok (role="button"). -->
                    <ul id="menu-ana" class="elementskit-navbar-nav elementskit-menu-po-center">
                      <li id="menu-item-16"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-16 nav-item"><a
                          href="/index.php" class="ekit-menu-nav-link">Anasayfa</a></li>
                      <li id="menu-item-27"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-27 nav-item elementskit-dropdown-has relative_position">
                        <a class="ekit-menu-nav-link ekit-menu-dropdown-toggle" role="button" aria-haspopup="true">Kurumsal<i
                            aria-hidden="true" class="icon icon-down-arrow1 elementskit-submenu-indicator"></i></a>
                        <ul class="elementskit-dropdown elementskit-submenu-panel">
                          <li id="menu-item-17"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-17 nav-item"><a
                              href="/kurumsal/hakkimizda.php" class=" dropdown-item">Hakkımızda</a></li>
                          <li id="menu-item-18"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-18 nav-item"><a
                              href="/index.php#misyon-vizyon-section" class=" dropdown-item">Vizyonumuz</a></li>
                          <li id="menu-item-19"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-19 nav-item"><a
                              href="/index.php#misyon-vizyon-section" class=" dropdown-item">Misyonumuz</a></li>
                          <li id="menu-item-20"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-20 nav-item"><a
                              href="/kurumsal/tuzuk.php" class=" dropdown-item">Tüzüğümüz</a></li>
                          <li id="menu-item-26"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-26 nav-item"><a
                              href="/kurumsal/belgeler.php" class=" dropdown-item">Belgeler</a></li>
                        </ul>
                      </li>
                      <li id="menu-item-21"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-21 nav-item"><a
                          href="/index.php#yonetim-kurulu-section" class="ekit-menu-nav-link">Yönetim Kurulu</a></li>
                      <li id="menu-item-22"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-22 nav-item elementskit-dropdown-has relative_position">
                        <a class="ekit-menu-nav-link ekit-menu-dropdown-toggle" role="button" aria-haspopup="true">Temsilcilikler<i
                            aria-hidden="true" class="icon icon-down-arrow1 elementskit-submenu-indicator"></i></a>
                        <ul class="elementskit-dropdown elementskit-submenu-panel">
                          <li id="menu-item-228"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-228 nav-item"><a
                              href="/il-ve-ilce-baskanliklari/" class=" dropdown-item">İl ve İlçe
                              Başkanlıkları</a></li>
                          <li id="menu-item-98"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-98 nav-item"><a
                              href="/ulke-temsilcilikleri.php" class=" dropdown-item">Ülke Temsilcilikleri</a></li>
                        </ul>
                      </li>
                      <li id="menu-item-23"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-23 nav-item"><a
                          href="/projeler.php" class="ekit-menu-nav-link">Projeler</a></li>
                      <li id="menu-item-186"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-186 nav-item"><a
                          href="/haberler/" class="ekit-menu-nav-link">Haberler</a></li>
                      <li id="menu-item-25"
                        class="menu-item menu-item-type-custom menu-item-object-custom menu-item-25 nav-item"><a
                          href="/iletisim.php" class="ekit-menu-nav-link">İletişim</a></li>
                    </ul>
                    <!-- Mobil menü paneli başlığı. Logo daha önce ElementsKit'in
                         hiç değiştirilmemiş "placeholder.png" dosyasını gösteriyordu
                         (panelde kırık/boş bir görsel olarak çıkıyordu); header'daki
                         gerçek logoyla değiştirildi. -->
                    <div class="elementskit-nav-identity-panel"><a class="elementskit-nav-logo" href="/index.php"><img
                          src="/wp-content/uploads/2026/03/Terorsuz-Turkiye-2-copy.png"
                          alt="Terörsüz Türkiye Platformu" decoding="async" /></a><button
                        class="elementskit-menu-close elementskit-menu-toggler" type="button"
                        aria-label="Menüyü kapat">&times;</button></div>
                  </div>
                  <div
                    class="elementskit-menu-overlay elementskit-menu-offcanvas-elements elementskit-menu-toggler ekit-nav-menu--overlay">
                  </div>
                </nav>
              </div>
            </div>

            <!-- Arama ve Belge Doğrulama -->
            <div class="ttp-header-actions-group">
              <div
                class="elementor-element elementor-element-5b4863a2 elementor-widget elementor-widget-elementskit-header-search"
                data-id="5b4863a2" data-element_type="widget" data-widget_type="elementskit-header-search.default">
                <div class="ekit-wid-con">
                  <!-- ElementsKit'in kendi arama modalı (magnific-popup) bu statik
                       dışa aktarımda hiç açılmıyor: header-search.js Elementor'un
                       widget init kancalarına bağlı, onlar burada çalışmıyor.
                       Bağımsız bir katman kullanılıyor (bkz. ttp-search-js). -->
                  <button type="button" class="ekit_navsearch-button ttp-search-open"
                    aria-label="Ara" aria-haspopup="dialog" aria-expanded="false">
                    <i aria-hidden="true" class="icon icon-search11"></i>
                  </button>
                  <div class="ttp-search-overlay" id="ttp-search-overlay" role="dialog"
                    aria-modal="true" aria-label="Sitede ara" hidden>
                    <button type="button" class="ttp-search-close" aria-label="Kapat">&times;</button>
                    <form role="search" method="get" class="ttp-search-form" action="/haberler/">
                      <input type="search" class="ttp-search-input" name="s"
                        placeholder="Haberlerde ara…" aria-label="Arama terimi">
                      <button type="submit" class="ttp-search-submit">Ara</button>
                    </form>
                  </div>
                </div>
              </div>

              <div
                class="elementor-element elementor-element-7e31bba elementor-widget elementor-widget-elementskit-button"
                data-id="7e31bba" data-element_type="widget" data-widget_type="elementskit-button.default">
                <div class="ekit-wid-con">
                  <div class="ekit-btn-wraper">
                    <a href="/il-ve-ilce-baskanliklari/" class="elementskit-btn whitespace--normal">Belge Doğrulama</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php if (!empty($ttpPageTitle)): ?>
          <div class="ttp-page-header">
            <div class="ttp-page-header-inner">
              <h1 class="ttp-page-title"><?= htmlspecialchars($ttpPageTitle) ?></h1>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </header>
